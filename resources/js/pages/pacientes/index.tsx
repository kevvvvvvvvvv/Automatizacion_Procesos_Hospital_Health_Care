import React, { useState, useMemo } from 'react';
import { Head, router } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import {route}  from 'ziggy-js';


import {
    useReactTable,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getFilteredRowModel,
    ColumnDef,
    flexRender,
    SortingState,
} from '@tanstack/react-table';

import AddButton from '@/components/ui/add-button';
import BackButton from '@/components/ui/back-button';


type Paciente = {
  id: number;
  curp: string;
  nombre: string;
  apellido_paterno: string;
  apellido_materno: string;
  telefono: string;
};

type IndexProps = {
  pacientes: Paciente[];
};

const Index = ({ pacientes }: IndexProps) => {

  const [globalFilter, setGlobalFilter] = useState('');

  const [sorting, setSorting] = useState<SortingState>([]);

  const columns = useMemo<ColumnDef<Paciente>[]>(
    () => [
      {
        accessorKey: 'curp',
        header: 'CURP',
      },
      {
        id: 'nombreCompleto',
        header: 'Nombre Completo',
        accessorFn: row => `${row.nombre} ${row.apellido_paterno} ${row.apellido_materno}`,
      },
      {
        accessorKey: 'telefono',
        header: 'Teléfono',
      },
      {
        id: 'actions',
        header: 'Acciones',
        cell: ({ row }) => (
          <div className="flex space-x-2">
            <button
              onClick={(e) => {
                e.stopPropagation(); // Evita que se active el clic de la fila
                router.get(route('pacientes.edit', row.original.id));
              }}
              className="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600"
            >
              Editar
            </button>
            <button
              onClick={(e) => {
                e.stopPropagation(); // Evita que se active el clic de la fila
                if (confirm('¿Estás seguro de eliminar este paciente?')) {
                  router.delete(route('pacientes.destroy', row.original.id));
                }
              }}
              className="px-3 py-1 bg-red-500 text-white rounded text-sm hover:bg-red-600"
            >
              Eliminar
            </button>
          </div>
        ),
      },
    ],
    []
  );

  const data = useMemo(() => pacientes, [pacientes]);

  const table = useReactTable({
    data,
    columns,
    state: {
      globalFilter,
      sorting,
    },
    onGlobalFilterChange: setGlobalFilter,
    onSortingChange: setSorting,
    getCoreRowModel: getCoreRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
  });

  return (
    <>
      <Head title="Pacientes" />
      <div className="p-4 md:p-8">
        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            <BackButton />
          </div>
          
          <AddButton href={route('pacientes.create')}>
            Agregar Paciente
          </AddButton>
        </div>

        <div className="mb-4">
          <input
            type="text"
            value={globalFilter}
            onChange={e => setGlobalFilter(e.target.value)}
            placeholder="Buscar en toda la tabla..."
            className="w-full max-w-sm p-2 border border-gray-300 rounded-lg text-black"
          />
        </div>


        <div className="overflow-x-auto bg-white rounded-lg shadow">
          <table className="w-full text-sm text-left text-gray-700">
            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
              {table.getHeaderGroups().map(headerGroup => (
                <tr key={headerGroup.id}>
                  {headerGroup.headers.map(header => (
                    <th key={header.id} scope="col" className="px-6 py-3">
                      <div
                        className="flex items-center cursor-pointer select-none"
                        onClick={header.column.getToggleSortingHandler()}
                      >
                        {flexRender(header.column.columnDef.header, header.getContext())}
                        {{ asc: ' 🔼', desc: ' 🔽' }[header.column.getIsSorted() as string] ?? null}
                      </div>
                    </th>
                  ))}
                </tr>
              ))}
            </thead>
              <tbody>
                {table.getRowModel().rows.map(row => (
                  <tr 
                    key={row.id} 
                    className="border-b hover:bg-gray-100 cursor-pointer" 
                    onClick={() => {
                        router.get(route('pacientes.show', row.original.id));
                    }}
                  >
                    {row.getVisibleCells().map(cell => (
                      <td key={cell.id} className="px-6 py-4">
                        {flexRender(cell.column.columnDef.cell, cell.getContext())}
                      </td>
                    ))}
                  </tr>
                ))}
              </tbody>
          </table>
        </div>

        <div className="flex items-center justify-between mt-4">
          <button
            onClick={() => table.previousPage()}
            disabled={!table.getCanPreviousPage()}
            className="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md disabled:opacity-50"
          >
            Anterior
          </button>
          <span className="text-sm">
            Página{' '}
            <strong>
              {table.getState().pagination.pageIndex + 1} de {table.getPageCount()}
            </strong>
          </span>
          <button
            onClick={() => table.nextPage()}
            disabled={!table.getCanNextPage()}
            className="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md disabled:opacity-50"
          >
            Siguiente
          </button>
        </div>
      </div>
    </>
  );
};


Index.layout = (page: React.ReactNode) => <MainLayout pageTitle="Consulta de pacientes" children={page} />;

export default Index;
