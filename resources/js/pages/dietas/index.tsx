import React, { useMemo, useState } from 'react';
import { Dieta } from '@/types/index';
import { Head, router, Link } from '@inertiajs/react';
import { route } from 'ziggy-js';

import MainLayout from '@/layouts/MainLayout';
import { Pencil, Trash2 } from 'lucide-react';
import AddButton from '@/components/ui/add-button';

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

interface Props {
    dietas: Dieta[];
}

const DietasIndex = ({ dietas }: Props) => {
    
    const [globalFilter, setGlobalFilter] = useState('');
    const [sorting, setSorting] = useState<SortingState>([]);

    const handleDelete = (id: number) => {
        if (confirm('¿Estás seguro de que deseas eliminar este alimento?')) {
            router.delete(route('dietas.destroy', id), {
                preserveScroll: true,
            });
        }
    }

    const columns = useMemo<ColumnDef<Dieta>[]>(
        () => [
            {            
                accessorKey: 'categoria_dieta.categoria', 
                header: 'Categoría',
            },
            {
                accessorKey: 'alimento',
                header: 'Descripción',
            },
            {
                accessorKey: 'costo',
                header: 'Costo',
                cell: ({ getValue }) => `$ ${parseFloat(getValue() as string).toFixed(2)}`
            },
            {
                id: 'acciones',
                header: 'Acciones',
                cell: ({ row }) => (
                    <div className="flex items-center space-x-2">
                        <Link
                            href={route('dietas.edit', row.original.id)}
                            className="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition-colors"
                        >
                            <Pencil className="w-4 h-4" />
                        </Link>

                        <button
                            onClick={() => handleDelete(row.original.id)}
                            className="p-2 text-red-600 hover:bg-red-100 rounded-full transition-colors"
                        >
                            <Trash2 className="w-4 h-4" />
                        </button>
                    </div>
                ),
            }
        ],
        []
    );

    const data = useMemo(() => dietas, [dietas]);

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
        <MainLayout pageTitle='Consulta de dietas'>
            <Head title="Consulta de dietas"/>
            
            <div className="p-4 md:p-8">
                <div className="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                    <h1 className="text-3xl font-bold text-gray-800">Listado de dietas</h1>
                    
                    <AddButton href={route('dietas.create')}>
                        Agregar dieta
                    </AddButton>
                </div>

                <div className="mb-4">
                    <input
                        type="text"
                        value={globalFilter ?? ''}
                        onChange={e => setGlobalFilter(e.target.value)}
                        placeholder="Buscar alimento, categoría..."
                        className="w-full max-w-sm p-2 border border-gray-300 rounded-lg text-black focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    />
                </div>

                <div className="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
                    <table className="w-full text-sm text-left text-gray-700">
                        <thead className="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            {table.getHeaderGroups().map(headerGroup => (
                                <tr key={headerGroup.id}>
                                    {headerGroup.headers.map(header => (
                                        <th key={header.id} scope="col" className="px-6 py-3">
                                            {header.isPlaceholder ? null : (
                                                <div
                                                    className={`flex items-center gap-2 ${
                                                        header.column.getCanSort() ? 'cursor-pointer select-none hover:text-blue-600' : ''
                                                    }`}
                                                    onClick={header.column.getToggleSortingHandler()}
                                                >
                                                    {flexRender(header.column.columnDef.header, header.getContext())}
                                                    {{
                                                        asc: ' 🔼',
                                                        desc: ' 🔽',
                                                    }[header.column.getIsSorted() as string] ?? null}
                                                </div>
                                            )}
                                        </th>
                                    ))}
                                </tr>
                            ))}
                        </thead>
                        <tbody className="divide-y divide-gray-200">
                            {table.getRowModel().rows.length > 0 ? (
                                table.getRowModel().rows.map(row => (
                                    <tr 
                                        key={row.id} 
                                        className="hover:bg-gray-50 transition-colors"
                                    >
                                        {row.getVisibleCells().map(cell => (
                                            <td key={cell.id} className="px-6 py-4">
                                                {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                            </td>
                                        ))}
                                    </tr>
                                ))
                            ) : (
                                <tr>
                                    <td colSpan={columns.length} className="px-6 py-8 text-center text-gray-500">
                                        No se encontraron registros.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>

                <div className="flex items-center justify-between mt-4">
                    <button
                        onClick={() => table.previousPage()}
                        disabled={!table.getCanPreviousPage()}
                        className="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Anterior
                    </button>
                    <span className="text-sm text-gray-600">
                        Página{' '}
                        <span className="font-semibold text-gray-900">
                            {table.getState().pagination.pageIndex + 1}
                        </span>{' '}
                        de{' '}
                        <span className="font-semibold text-gray-900">
                            {table.getPageCount()}
                        </span>
                    </span>
                    <button
                        onClick={() => table.nextPage()}
                        disabled={!table.getCanNextPage()}
                        className="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Siguiente
                    </button>
                </div>
            </div>
        </MainLayout>
    );
}

export default DietasIndex;