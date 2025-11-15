import React, { useMemo } from 'react';
import MainLayout from '@/layouts/MainLayout';
import { useReactTable, getCoreRowModel, flexRender, CellContext, getPaginationRowModel } from '@tanstack/react-table';

import { HistoryEntry, PaginatedResponse } from '@/types';
import { router } from '@inertiajs/react';

type IndexProps = {
    histories: PaginatedResponse<HistoryEntry>;
}

const Index = ({ histories }: IndexProps) => {
    //const data = histories?.data ?? [];

    const columns = useMemo(
    () => [
        {
            accessorKey: 'user_name',
            header: 'Usuario',
        },
        {
            accessorKey: 'action',
            header: 'Acción',
            cell: ({ row }: CellContext<HistoryEntry, unknown>) => { 
                const action = row.original.action;
                let color = 'bg-gray-500';
                if (action === 'created') color = 'bg-green-500';
                if (action === 'updated') color = 'bg-yellow-500';
                if (action === 'deleted') color = 'bg-red-500';
                return <span className={`px-2 py-1 text-white text-xs rounded ${color}`}>{action}</span>;
            },
        },
        {
            header: 'Registro Afectado',
            accessorFn: (row: HistoryEntry) => `${row.model_name} #${row.model_id}`,
        },
        {
            header: 'Detalles',
            cell: ({ row }: CellContext<HistoryEntry, unknown>) => ( 
                <details>
                    <summary className="cursor-pointer text-blue-500 hover:underline">Ver</summary>
                    <div className="p-2 mt-2 bg-gray-100 rounded">
                        {row.original.before && (
                            <div>
                                <strong>Antes:</strong>
                                <pre className="text-xs bg-white p-1 rounded"><code>{JSON.stringify(row.original.before, null, 2)}</code></pre>
                            </div>
                        )}
                        {row.original.after && (
                            <div className="mt-2">
                                <strong>Después:</strong>
                                <pre className="text-xs bg-white p-1 rounded"><code>{JSON.stringify(row.original.after, null, 2)}</code></pre>
                            </div>
                        )}
                    </div>
                </details>
            ),
        },
        {
            accessorKey: 'created_at',
            header: 'Fecha',
        },
        ],
        []
    );

    const table = useReactTable({
        data: histories?.data ?? [],
        columns,
        getCoreRowModel: getCoreRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
        manualPagination: true,
        
        pageCount: histories?.last_page ?? 0, 
        
        state: {
            pagination: {
                pageIndex: (histories?.current_page ?? 1) - 1,
                pageSize: histories?.per_page ?? 10,
            },
        },
        
        onPaginationChange: (updater) => {
            if (!histories || typeof updater !== 'function') return;

            const newPageIndex = updater({
                pageIndex: histories.current_page - 1,
                pageSize: histories.per_page,
            }).pageIndex;
            router.get(
                histories.path,
                { page: newPageIndex + 1 },
                {
                    preserveState: true,
                    preserveScroll: true,
                }
            );
        },
    });

    return (
        <div>
            <h1 className="text-2xl font-bold mb-4">Historial de cambios</h1>

            <table className="min-w-full bg-white border">
                <thead>
                    {table.getHeaderGroups().map(headerGroup => (
                        <tr key={headerGroup.id} className="bg-gray-200">
                            {headerGroup.headers.map(header => (
                                <th key={header.id} className="p-3 text-left">
                                    {flexRender(header.column.columnDef.header, header.getContext())}
                                </th>
                            ))}
                        </tr>
                    ))}
                </thead>
                <tbody>
                    {table.getRowModel().rows.map(row => (
                        <tr key={row.id} className="border-b hover:bg-gray-50">
                            {row.getVisibleCells().map(cell => (
                                <td key={cell.id} className="p-3">
                                    {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                </td>
                            ))}
                        </tr>
                    ))}
                </tbody>
            </table>
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
        
    );
};

Index.layout = (page: React.ReactNode) => <MainLayout pageTitle="Consulta del Historial" children={page} />;

export default Index;