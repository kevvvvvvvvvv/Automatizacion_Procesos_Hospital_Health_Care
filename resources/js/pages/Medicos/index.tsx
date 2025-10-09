import React, { useState, useMemo } from 'react';
import { Head, router } from '@inertiajs/react';
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
import BackButton from '@/components/ui/back-button';

interface Doctor {
  id: number;
  nombre_completo: string;
  email: string;
  fecha_nacimiento: string;
  cargo: string;
  responsable: string;
  created_at: string;
  sexo?: string;  // Para mostrar más info
}

interface Props {
  doctores: Doctor[];
  flash?: {
    success?: string;
  };
}

const DoctorIndex: React.FC<Props> = ({ doctores, flash }) => {
  const [globalFilter, setGlobalFilter] = useState('');
  const [sorting, setSorting] = useState<SortingState>([]);

  // Columnas: Incluye 'sexo' para toda la info
  const columns = useMemo<ColumnDef<Doctor>[]>(
    () => [
      {
        accessorKey: 'nombre_completo',
        header: 'Nombre Completo',
      },
      {
        accessorKey: 'email',
        header: 'Email',
      },
      {
        accessorKey: 'sexo',
        header: 'Sexo',
      },
      {
        accessorKey: 'fecha_nacimiento',
        header: 'Fecha de Nacimiento',
      },
      {
        accessorKey: 'cargo',
        header: 'Cargo',
      },
      {
        accessorKey: 'responsable',
        header: 'Responsable',
      },
      {
        accessorKey: 'created_at',
        header: 'Creado',
      },
    ],
    []
  );

  const data = useMemo(() => doctores, [doctores]);

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

  // Función para handle clic en fila (evita conflictos con sorting)
  const handleRowClick = (e: React.MouseEvent, id: number) => {
    e.preventDefault();  // Opcional: Previene default si hay links en celdas
    router.get(route('doctores.show', id));  //  CORREGIDO: Usa 'doctores.show' (nombre de ruta correcto)
  };

  return (
    <>
      <Head title="Doctores" />
      <div className="p-4 md:p-8">
        <div className="flex items-center justify-between mb-6">
          <h1 className="text-3xl font-bold text-black">Listado de Doctores</h1>
        </div>

        {flash?.success && (
          <div className="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {flash.success}
          </div>
        )}

        <div className="flex justify-between items-center mb-6">
          <div className="flex items-center space-x-4">
            <BackButton />
          </div>
          <AddButton href={route('doctores.create')}>
            Agregar Doctor
          </AddButton>
        </div>

        <div className="mb-4">
          <input
            type="text"
            value={globalFilter}
            onChange={(e) => setGlobalFilter(e.target.value)}
            placeholder="Buscar en toda la tabla..."
            className="w-full max-w-sm p-2 border border-gray-300 rounded-lg text-gray-900"
          />
        </div>

        <div className="overflow-x-auto bg-white rounded-lg shadow">
          <table className="w-full text-sm text-left text-gray-700">
            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
              {table.getHeaderGroups().map((headerGroup) => (
                <tr key={headerGroup.id}>
                  {headerGroup.headers.map((header) => (
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
              {table.getRowModel().rows.map((row) => (
                <tr
                  key={row.id}
                  className="border-b hover:bg-gray-100 cursor-pointer"
                  onClick={(e) => handleRowClick(e, row.original.id)}  //  CORREGIDO: Usa función con ruta correcta
                >
                  {row.getVisibleCells().map((cell) => (
                    <td key={cell.id} className="px-6 py-4">
                      {flexRender(cell.column.columnDef.cell, cell.getContext()) || 'N/A'}
                    </td>
                  ))}
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {table.getRowModel().rows.length === 0 && (
          <div className="text-center py-4 text-gray-500">
            {globalFilter ? 'No se encontraron doctores.' : `No hay doctores registrados aún. (Total recibidos: ${doctores.length})`}
          </div>
        )}

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

DoctorIndex.layout = (page: React.ReactNode) => (
  <MainLayout pageTitle="Consulta de doctores" children={page} />
);

export default DoctorIndex;
