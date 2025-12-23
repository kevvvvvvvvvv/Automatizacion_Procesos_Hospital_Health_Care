import React, { useState, useMemo } from "react";
import { Head, router, Link } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { route } from "ziggy-js";
import {
    useReactTable,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getFilteredRowModel,
    ColumnDef,
    flexRender,
    SortingState,
} from "@tanstack/react-table";
import AddButton from "@/components/ui/add-button";
import { Pencil, Eye } from "lucide-react";

/* =========================
   TIPOS CORREGIDOS (Coinciden con el Controller)
========================= */
type ReservacionQuirofano = {
    id: number;
    fecha: string;
    localizacion: string;
    paciente_nombre: string;
    instrumentista: string;
    anestesiologo: string;
    horarios: string[]; 
    user_nombre: string;
    habitacion_nombre: string;
    estancia_id: number;
};

interface Props {
    reservaciones: ReservacionQuirofano[];
}

const Index = ({ reservaciones }: Props) => {
    console.log(reservaciones);
    const [globalFilter, setGlobalFilter] = useState("");
    const [sorting, setSorting] = useState<SortingState>([]);

    const data = useMemo(() => reservaciones ?? [], [reservaciones]);

    const columns = useMemo<ColumnDef<ReservacionQuirofano>[]>(() => [
        {
            accessorKey: "fecha",
            header: "Fecha",
            cell: ({ row }) => new Date(row.original.fecha).toLocaleDateString("es-MX"),
        },
        {
            id: "horario_inicio",
            header: "Inicio",
            cell: ({ row }) => {
                const horarios = row.original.horarios;
                if (!horarios || horarios.length === 0) return "—";
                // El formato es "YYYY-MM-DD HH:MM:SS", cortamos para ver HH:MM
                try {
                    return horarios[0].split(" ")[1].substring(0, 5) + " hrs";
                } catch (e) {
                    return "—";
                }
            },
        },
        {
            accessorKey: "paciente_nombre",
            header: "Paciente",
        },
        {
            accessorKey: "habitacion_nombre", // Usamos el nombre que viene del map del controller
            header: "Quirófano",
        },
        {
            id: "equipo",
            header: "Solicitudes",
            cell: ({ row }) => (
                <div className="text-xs">
                    <p><span className="font-semibold">Inst:</span> {row.original.instrumentista || 'No'}</p>
                    <p><span className="font-semibold">Anest:</span> {row.original.anestesiologo || 'No'}</p>
                </div>
            ),
        },
        {
            accessorKey: "user_nombre",
            header: "Solicitante",
            cell: ({ row }) => (
                <span className="font-medium text-gray-700 uppercase text-xs">
                    {row.original.user_nombre}
                </span>
            ),
        },
        {
            id: "acciones",
            header: "Acciones",
            cell: ({ row }) => (
                <div className="flex gap-2" onClick={(e) => e.stopPropagation()}>
                    <Link
                        href={route("quirofanos.show", row.original.id)}
                        className="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition"
                    >
                        <Eye size={18} />
                    </Link>
                    <Link
                        href={route("quirofanos.edit", row.original.id)}
                        className="p-2 text-blue-600 hover:bg-blue-100 rounded-full transition"
                    >
                        <Pencil size={18} />
                    </Link>
                </div>
            ),
        },
    ], []);

    const table = useReactTable({
        data,
        columns,
        state: { globalFilter, sorting },
        onGlobalFilterChange: setGlobalFilter,
        onSortingChange: setSorting,
        getCoreRowModel: getCoreRowModel(),
        getFilteredRowModel: getFilteredRowModel(),
        getSortedRowModel: getSortedRowModel(),
        getPaginationRowModel: getPaginationRowModel(),
    });

    return (
        <div className="p-4 md:p-8">
            <Head title="Control de Quirófanos" />
            
            <div className="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h1 className="text-2xl font-bold text-gray-800">
                    Control de Quirófanos
                </h1>

                {/* IMPORTANTE: El create de tu controller pide paciente y estancia. 
                    Si es una reservación general, podrías necesitar una ruta distinta 
                    o pasar parámetros nulos si tu route lo permite */}
                <AddButton href={route("quirofanos.create")}>
                    Nueva Reservación
                </AddButton>
            </div>

            <div className="mb-4">
                <input
                    type="text"
                    value={globalFilter}
                    onChange={(e) => setGlobalFilter(e.target.value)}
                    placeholder="Buscar por paciente, quirófano o solicitante..."
                    className="w-full max-w-sm p-2.5 border border-gray-300 rounded-lg text-sm shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none"
                />
            </div>

            <div className="overflow-hidden bg-white rounded-xl shadow-md border border-gray-200">
                <table className="w-full text-left border-collapse">
                    <thead className="bg-gray-50 border-b border-gray-200">
                        {table.getHeaderGroups().map((hg) => (
                            <tr key={hg.id}>
                                {hg.headers.map((header) => (
                                    <th key={header.id} className="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">
                                        {flexRender(header.column.columnDef.header, header.getContext())}
                                    </th>
                                ))}
                            </tr>
                        ))}
                    </thead>

                    <tbody className="divide-y divide-gray-100">
                        {table.getRowModel().rows.length > 0 ? (
                            table.getRowModel().rows.map((row) => (
                                <tr
                                    key={row.id}
                                    className="hover:bg-indigo-50/30 cursor-pointer transition-colors"
                                    onClick={() => router.get(route("quirofanos.show", row.original.id))}
                                >
                                    {row.getVisibleCells().map((cell) => (
                                        <td key={cell.id} className="px-6 py-4 text-sm text-gray-600">
                                            {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                        </td>
                                    ))}
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={columns.length} className="px-6 py-10 text-center text-gray-400">
                                    No se encontraron reservaciones activas.
                                </td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
            
            <div className="mt-4 flex items-center justify-between px-2">
                <div className="text-xs text-gray-500">
                    Mostrando {table.getRowModel().rows.length} de {data.length} registros
                </div>
                <div className="flex gap-2">
                    <button 
                        onClick={() => table.previousPage()} 
                        disabled={!table.getCanPreviousPage()}
                        className="px-3 py-1 border rounded text-xs disabled:opacity-30"
                    > Anterior </button>
                    <button 
                        onClick={() => table.nextPage()} 
                        disabled={!table.getCanNextPage()}
                        className="px-3 py-1 border rounded text-xs disabled:opacity-30"
                    > Siguiente </button>
                </div>
            </div>
        </div>
    );
};

Index.layout = (page: React.ReactNode) => (
    <MainLayout pageTitle="Listado Quirófanos" link="dashboard">
        {page}
    </MainLayout>
);

export default Index;