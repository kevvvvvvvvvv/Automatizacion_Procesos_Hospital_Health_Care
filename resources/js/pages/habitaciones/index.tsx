import React, { useState, useMemo } from 'react';
import { Head, router, Link } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';
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
import { Habitacion } from '@/types';
import { Pencil } from 'lucide-react';

type IndexProps = {
  habitaciones: Habitacion[];
};

const Index = ({ habitaciones }: IndexProps) => {
  const [globalFilter, setGlobalFilter] = useState('');
  const [sorting, setSorting] = useState<SortingState>([]);

  const columns = useMemo<ColumnDef<Habitacion>[]>(
    () => [
      {
        accessorKey: 'identificador',
        header: 'Identificador',
      },
      {
        accessorKey: 'tipo',
        header: 'Tipo',
      },
      {
        accessorKey: 'ubicacion',
        header: 'Ubicación',
      },
      {
        accessorKey: 'piso',
        header: 'Piso',
      },
      {
        accessorKey: 'estado',
        header: 'Estado',
        cell: ({ row }) => (
          <div className="flex items-center">
            <span
              className={`h-2.5 w-2.5 rounded-full mr-2 ${
                row.original.estado === 'Libre' ? 'bg-green-500' : 'bg-red-500'
              }`}
            ></span>
            {row.original.estado}
          </div>
        ),
      },
      {
        id: 'paciente',
        header: 'Paciente',
        cell: ({ row }) => {
          const paciente = row.original.estancia_activa?.paciente;

          return paciente
            ? `${paciente.nombre} ${paciente.apellido_paterno} ${paciente.apellido_materno}`
            : <span className="text-gray-400">N/A</span>;
        },
      },
      {
        id: 'acciones',
        header: 'Acciones',
        cell: ({ row }) => (
          <div className="flex space-x-2">
            <Link
              href={route('habitaciones.edit', row.original.id)}
              className="p-2 text-blue-500 hover:bg-blue-100 hover:text-blue-700 rounded-full transition"
              title="Editar habitación"
              onClick={(e) => {
                // evito que el click suba al TR y dispare router.get(...)
                e.stopPropagation();
              }}
            >
              <Pencil size={18} />
            </Link>
          </div>
        ),
      },
    ],
    []
  );

  const data = useMemo(() => habitaciones, [habitaciones]);

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
      <Head title="Habitaciones" />
      <div className="p-4 md:p-8">
        <div className="flex items-center justify-between mb-6">
          <h1 className="text-3xl font-bold text-black">Listado de Habitaciones</h1>
        </div>

        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4"></div>

          <AddButton href={route('habitaciones.create')}>Agregar Habitación</AddButton>
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
                    router.get(route('habitaciones.show', row.original.id));
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

Index.layout = (page: React.ReactNode) => <MainLayout pageTitle="Consulta de habitaciones" children={page} link="dashboard" />;

export default Index;
