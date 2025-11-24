import React, { useState, useMemo } from 'react';
import { Head, router, Link } from '@inertiajs/react';
import MainLayout from '@/layouts/MainLayout';
import { route } from 'ziggy-js';
import { Pencil, Trash2 } from 'lucide-react';

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


type IndexProps = {
  productoServicios: ProductoServicio[];
};

const Index = ({ productoServicios }: IndexProps) => {

  const [globalFilter, setGlobalFilter] = useState('');
  const [sorting, setSorting] = useState<SortingState>([]);

  const handleDelete = (id: number) => {
    if (confirm('¿Estás seguro de que deseas eliminar este elemento?')) {
      router.delete(route('producto-servicios.destroy', id), {
        preserveScroll: true, 
      });
    }
  };

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
          accessorKey: 'subtipo',
          header: 'Subtipo',
        },
        {
            accessorKey: 'importe',
            header: 'Importe',
            cell: info => `$${Number(info.getValue()).toFixed(2)}`
        },
        {
          accessorKey: 'cantidad',
          header: 'Cantidad',
          cell: info =>`${Number(info.getValue())}`
        },
        {
            id: 'actions',
            header: 'Acciones',
            cell: ({ row }) => (
                <div className="flex items-center space-x-3">
                    <Link
                        href={route('producto-servicios.edit', row.original.id)}
                        className="text-blue-600 hover:text-blue-800"
                        onClick={(e) => e.stopPropagation()} 
                    >
                        <Pencil size={18} />
                    </Link>

                    <button
                        onClick={(e) => {
                            e.stopPropagation(); 
                            handleDelete(row.original.id);
                        }}
                        className="text-red-600 hover:text-red-800"
                    >
                        <Trash2 size={18} />
                    </button>
                </div>
            )
        }
    ],
    []
  );

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
      <Head title="Productos y Servicios" />
      <div className="p-4 md:p-8">
        <div className="flex items-center justify-between mb-6">
          <h1 className="text-3xl font-bold text-black">Listado de Productos y Servicios</h1>
        </div>
             <div className="flex justify-between items-center mb-6">
                <div className="flex items-center space-x-4">
                
                </div>
                
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
                    //onClick={() => {router.get(route('producto-servicios.show', row.original.id));}}
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

Index.layout = (page: React.ReactNode) => <MainLayout pageTitle="Consulta de productos y servicios" children={page} link="dashboard"/>;

export default Index;