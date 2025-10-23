import React, { useState, useMemo } from 'react';
import { Head, router } from '@inertiajs/react';
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
import MainLayout from '@/layouts/MainLayout';
import PacienteCard from '@/components/paciente-card';
import { Paciente, Estancia, Venta } from '@/types'; 


interface IndexProps {
    paciente: Paciente;
    estancia: Estancia;
    ventas: Venta[]; 
}

type IndexComponent = React.FC<IndexProps> & {
    layout: (page: React.ReactElement) => React.ReactNode;
}

const Index: IndexComponent = ({ paciente, estancia, ventas }) => {

    const [globalFilter, setGlobalFilter] = useState('');
    const [sorting, setSorting] = useState<SortingState>([]);

    const columns = useMemo<ColumnDef<Venta>[]>(
        () => [
            {
                accessorKey: 'id',
                header: 'ID',
            },
            {
                accessorKey: 'fecha',
                header: 'Fecha',
                cell: ({ row }) => new Date(row.original.fecha).toLocaleDateString(),
            },
            {
                accessorKey: 'subtotal',
                header:'Subtotal',
                cell: ({row}) => `$${row.original.subtotal.toLocaleString('es-MX', { minimumFractionDigits: 2 })}`,
            },
            {
                accessorKey: 'total',
                header: 'Total',
                cell: ({ row }) => `$${row.original.total.toLocaleString('es-MX', { minimumFractionDigits: 2 })}`,
            },
            {
                accessorKey: 'descuento',
                headder: 'descuento',
                cell: ({ row }) => `$${row.original.descuento.toLocaleString('es-MX', { minimumFractionDigits: 2 })}`,
            },
            {
                accessorKey: 'estado',
                header: 'Estado',
            },
            {
                id: 'nombreUsuario', 
                header: 'Nombre del que realizó la venta', 
                accessorFn: (row) => {
                    if (!row.user) {
                        return 'Usuario no disponible'; 
                    }
                    return `${row.user.nombre} ${row.user.apellido_paterno} ${row.user.apellido_materno}`;
                },
            },
            {
                id: 'actions',
                header: 'Acciones',
                cell: ({ row }) => (
                    <div className="flex space-x-2">
                        <button
                            onClick={(e) => {
                                e.stopPropagation();
                                router.get(route('pacientes.estancias.ventas.edit', { 
                                    paciente: paciente.id, 
                                    estancia: estancia.id, 
                                    venta: row.original.id 
                                }));
                            }}
                            className="px-3 py-1 bg-blue-500 text-white rounded text-sm hover:bg-blue-600"
                        >
                            Editar
                        </button>
                    </div>
                ),
            },
        ],
        [paciente.id, estancia.id] 
    );

    const data = useMemo(() => ventas, [ventas]);

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
            <Head title={`Ventas de ${paciente.nombre}`} />
            
            <PacienteCard
                paciente={paciente}
                estancia={estancia}
            />

            <div className="p-4 md:p-8 mt-4 border-t">

                <div className="mb-4">
                    <input
                        type="text"
                        value={globalFilter}
                        onChange={e => setGlobalFilter(e.target.value)}
                        placeholder="Buscar en ventas..."
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
                                        router.get(route('pacientes.estancias.ventas.detallesventas', { 
                                            paciente: paciente.id, 
                                            estancia: estancia.id, 
                                            venta: row.original.id 
                                        }));
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

Index.layout = (page: React.ReactElement) => {
    return (
        <MainLayout pageTitle="Consulta de ventas" children={page} />
    );
};

export default Index;