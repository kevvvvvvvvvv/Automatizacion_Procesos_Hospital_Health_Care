import React, { useState, useMemo } from 'react';
import { Head, router } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';

// Importaciones de TanStack Table
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

// 1. Definimos el TIPO para nuestros datos de paciente
type Paciente = {
  curpp: string;
  nombre: string;
  apellidop: string;
  apellidom: string;
  telefono: string;
};

// Props que el componente recibe desde el controlador de Laravel
type IndexProps = {
  pacientes: Paciente[];
};

const Index = ({ pacientes }: IndexProps) => {
  // Estado para el filtro de búsqueda global
  const [globalFilter, setGlobalFilter] = useState('');
  // Estado para el ordenamiento de columnas
  const [sorting, setSorting] = useState<SortingState>([]);

  // 2. Definición de las COLUMNAS para la tabla (sin la columna de acciones)
  const columns = useMemo<ColumnDef<Paciente>[]>(
    () => [
      {
        accessorKey: 'curpp',
        header: 'CURP',
      },
      {
        id: 'nombreCompleto',
        header: 'Nombre Completo',
        accessorFn: row => `${row.nombre} ${row.apellidop} ${row.apellidom}`,
      },
      {
        accessorKey: 'telefono',
        header: 'Teléfono',
      },
    ],
    []
  );

  // Memoizamos los datos
  const data = useMemo(() => pacientes, [pacientes]);

  // 3. Hook principal de TanStack Table
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
    <MainLayout>
      <Head title="Pacientes" />
      <div className="p-4 md:p-8">
        <div className="flex items-center justify-between mb-6">
          <h1 className="text-3xl font-bold text-black">Listado de Pacientes</h1>
        </div>

        {/* Campo de búsqueda */}
        <div className="mb-4">
          <input
            type="text"
            value={globalFilter}
            onChange={e => setGlobalFilter(e.target.value)}
            placeholder="Buscar en toda la tabla..."
            className="w-full max-w-sm p-2 border border-gray-300 rounded-lg text-black"
          />
        </div>

        {/* 4. Renderizado de la TABLA */}
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
                        router.get(route('pacientes.show', row.original.curpp));
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

        {/* 5. Controles de PAGINACIÓN */}
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
    </MainLayout>
  );
};

// Asigna el layout persistente
Index.layout = (page: React.ReactNode) => <MainLayout children={page} />;

export default Index;