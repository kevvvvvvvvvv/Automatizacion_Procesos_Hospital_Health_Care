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
   TIPOS ADAPTADOS A QUIRÓFANO
========================= */
type Habitacion = {
    id: number;
    nombre: string;
};

type User = {
    name?: string;
    nombre?: string;
};

type ReservacionQuirofano = {
    id: number;
    localizacion: string;
    fecha: string;
    horarios: string[]; // Array de strings ["2025-10-10 08:00:00", ...]
    instrumentista: string;
    anestesiologo: string;
    habitacion: Habitacion | null;
    user: User | null;
};

interface Props {
    reservaciones: ReservacionQuirofano[];
}

const Index = ({ reservaciones }: Props) => {
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
                // Extraemos solo la hora del primer bloque seleccionado
                return horarios[0].split(" ")[1].substring(0, 5) + " hrs";
            },
        },
        {
            id: "localizacion",
            header: "Ubicación",
            cell: ({ row }) => row.original.localizacion,
        },
        {
            id: "quirofano",
            header: "Quirófano",
            cell: ({ row }) => row.original.habitacion?.nombre ?? "No asignado",
        },
        {
            id: "equipo",
            header: "Equipo Médico",
            cell: ({ row }) => (
                <div className="text-xs">
                    <p><span className="font-semibold">Inst:</span> {row.original.instrumentista}</p>
                    <p><span className="font-semibold">Anest:</span> {row.original.anestesiologo}</p>
                </div>
            ),
        },
        {
            id: "usuario",
            header: "Solicitante",
            cell: ({ row }) => (
                <span className="font-medium text-gray-700 uppercase text-xs">
                    {row.original.user?.name || row.original.user?.nombre || "N/A"}
                </span>
            ),
        },
        {
            id: "acciones",
            header: "Acciones",
            cell: ({ row }) => (
                <div className="flex gap-2">
                    <Link
                        href={route("quirofanos.show", row.original.id)}
                        className="p-2 text-gray-600 hover:bg-gray-100 rounded-full transition"
                    >
                        <Eye size={18} />
                    </Link>
                    <Link
                        href={route("quirofanos.edit", row.original.id)}
                        onClick={(e) => e.stopPropagation()}
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
            <div className="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <h1 className="text-2xl font-bold text-gray-800">
                    Control de Quirófanos
                </h1>

                <AddButton href={route("quirofanos.create")}>
                    Nueva Reservación
                </AddButton>
            </div>

            <div className="mb-4">
                <input
                    type="text"
                    value={globalFilter}
                    onChange={(e) => setGlobalFilter(e.target.value)}
                    placeholder="Buscar por médico, equipo o fecha..."
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
            
            {/* Paginación simple */}
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