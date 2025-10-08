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
import { ProductoServicio } from '@/types';

// 2. Props del componente actualizados
type IndexProps = {
  productoServicios: ProductoServicio[];
};

const Index = ({ productoServicios }: IndexProps) => {

  const [globalFilter, setGlobalFilter] = useState('');
  const [sorting, setSorting] = useState<SortingState>([]);

  // 3. Definición de columnas adaptada a ProductoServicio
  const columns = useMemo<ColumnDef<ProductoServicio>[]>(
    () => [
        {
            accessorKey: 'codigo_prestacion',
            header: 'Código',
        },
        {
            accessorKey: 'nombre_prestacion',
            header: 'Nombre de Prestación',
        },
        {
            accessorKey: 'tipo',
            header: 'Tipo',
        },
        {
            accessorKey: 'importe',
            header: 'Importe',
            // Opcional: Formatear la celda para mostrar como moneda
            cell: info => `$${Number(info.getValue()).toFixed(2)}`
        },
    ],
    []
  );

  // 4. Se utiliza el nuevo prop para los datos
  const data = useMemo(() => productoServicios, [productoServicios]);

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
      {/* 5. Textos y títulos actualizados */}
      <Head title="Productos y Servicios" />
      <div className="p-4 md:p-8">
        <div className="flex items-center justify-between mb-6">
          <h1 className="text-3xl font-bold text-black">Listado de Productos y Servicios</h1>
        </div>
             <div className="flex justify-between items-center mb-6">
                <div className="flex items-center space-x-4">
                  <BackButton />
                </div>
                
                {/* 6. Rutas y texto del botón actualizados */}
                <AddButton href={route('producto-servicios.create')}>
                  Agregar Producto/Servicio
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
                    // 7. Ruta de navegación actualizada
                    onClick={() => {
                        router.get(route('producto-servicios.show', row.original.id));
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

// 8. Título del layout actualizado
Index.layout = (page: React.ReactNode) => <MainLayout pageTitle="Consulta de Productos y Servicios" children={page} />;

export default Index;