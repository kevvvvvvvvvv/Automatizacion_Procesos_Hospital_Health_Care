import React, { useState, useMemo } from "react";
import { Head, router, Link } from "@inertiajs/react";
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
import { Pencil, Eye, Search, Calendar, Clock, User, Activity } from "lucide-react";
import { usePermission } from "@/hooks/use-permission";

import MainLayout from "@/layouts/MainLayout";
import AddButton from "@/components/ui/add-button";

type ReservacionQuirofano = {
    id: number;
    fecha: string;
    localizacion: string;
    medico_operacion: string;
    paciente_nombre: string;
    instrumentista: string;
    anestesiologo: string;
    horarios: string[]; 
    user_nombre: string;
    comentarios: string;
    habitacion_nombre: string;
    estancia_id: number;
};

interface Props {
    reservaciones: ReservacionQuirofano[];
}

const Index = ({ reservaciones }: Props) => {
    const { can } = usePermission();
    const [globalFilter, setGlobalFilter] = useState("");
    const [sorting, setSorting] = useState<SortingState>([]);

    const data = useMemo(() => reservaciones ?? [], [reservaciones]);

    // Lógica de formateo de horario extraída para reusabilidad
    const formatHorario = (horarios: string[]) => {
        if (!horarios || horarios.length === 0) return { rago: "—", duracion: "" };
        try {
            const sorted = [...horarios].sort();
            const inicio = sorted[0].split(" ")[1].substring(0, 5);
            const ultimoBloque = sorted[sorted.length - 1].split(" ")[1];
            const [horas, minutos] = ultimoBloque.split(":").map(Number);
            let finHoras = horas;
            let finMinutos = minutos + 30;
            if (finMinutos === 60) { finHoras += 1; finMinutos = 0; }
            const fin = `${String(finHoras).padStart(2, '0')}:${String(finMinutos).padStart(2, '0')}`;
            
            const duracionMinutos = horarios.length * 30;
            const h = Math.floor(duracionMinutos / 60);
            const m = duracionMinutos % 60;
            const duracion = h > 0 ? `${h}h ${m > 0 ? m + 'm' : ''}` : `${m} min`;
            
            return { rango: `${inicio} - ${fin}`, duracion };
        } catch (e) { return { rango: "Error", duracion: "" }; }
    };

    const columns = useMemo<ColumnDef<ReservacionQuirofano>[]>(() => [
        {
            accessorKey: "fecha",
            header: "Fecha",
            cell: ({ row }) => (
                <div className="flex flex-col">
                    <span className="font-medium text-gray-900">{new Date(row.original.fecha).toLocaleDateString("es-MX", { day: '2-digit', month: 'short' })}</span>
                    <span className="text-[10px] text-gray-400 uppercase">{new Date(row.original.fecha).getFullYear()}</span>
                </div>
            ),
        },
        {
            id: "horario_completo",
            header: "Horario",
            cell: ({ row }) => {
                const { rango, duracion } = formatHorario(row.original.horarios);
                return (
                    <div className="flex flex-col">
                        <span className="font-bold text-indigo-700 whitespace-nowrap">{rango}</span>
                        <span className="text-[10px] text-gray-400 font-medium italic">Est: {duracion}</span>
                    </div>
                );
            },
        },
        {
            accessorKey: "paciente_nombre",
            header: "Paciente",
            cell: ({ row }) => <span className="font-semibold text-gray-700">{row.original.paciente_nombre}</span>
        },
        {
            accessorKey: "medico_operacion",
            header: "Cirujano",
            cell: ({ row }) => <span className="text-xs font-bold text-gray-500 uppercase">{row.original.medico_operacion}</span>
        },
        {
            id: "acciones",
            header: () => <div className="text-right">Acciones</div>,
            cell: ({ row }) => (
                <div className="flex justify-end gap-1" onClick={(e) => e.stopPropagation()}>
                    <Link href={route("quirofanos.show", row.original.id)} className="p-2 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                        <Eye size={18} />
                    </Link>
                    {can('editar reservaciones quirofanos') && (
                        <Link href={route("quirofanos.edit", row.original.id)} className="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                            <Pencil size={18} />
                        </Link>
                    )}
                </div>
            ),
        },
    ], [can]);

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
        initialState: { pagination: { pageSize: 10 } }
    });

    return (
        <div className="max-w-7xl mx-auto p-4 md:p-6 lg:p-8 space-y-6">
            <Head title="Control de Quirófanos" />
            
            {/* Header Section */}
            <div className="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h1 className="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">
                        Control de Quirófanos
                    </h1>
                    <p className="text-sm text-gray-500">Gestión de tiempos y personal médico</p>
                </div>
                {can('crear reservaciones quirofanos') && (
                    <AddButton 
                        href={route("quirofanos.create")} 
                        className="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl shadow-lg shadow-indigo-200 transition-all flex justify-center items-center gap-2"
                    >
                        Programar cirugía
                    </AddButton>    
                )}
            </div>

            {/* Search Bar */}
            <div className="relative group max-w-md">
                <Search className="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-indigo-500 transition-colors" size={18} />
                <input
                    type="text"
                    value={globalFilter}
                    onChange={(e) => setGlobalFilter(e.target.value)}
                    placeholder="Buscar paciente o cirujano..."
                    className="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-2xl text-sm shadow-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all"
                />
            </div>

            {/* Mobile View (Cards) - Visible only on small screens */}
            <div className="grid grid-cols-1 gap-4 md:hidden">
                {table.getRowModel().rows.length > 0 ? (
                    table.getRowModel().rows.map((row) => {
                        const { rango, duracion } = formatHorario(row.original.horarios);
                        return (
                            <div 
                                key={row.id} 
                                onClick={() => router.get(route("quirofanos.show", row.original.id))}
                                className="bg-white p-5 rounded-2xl border border-gray-100 shadow-sm active:scale-[0.98] transition-transform"
                            >
                                <div className="flex justify-between items-start mb-3">
                                    <div className="flex items-center gap-2 bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-bold">
                                        <Clock size={14} /> {rango}
                                    </div>
                                    <span className="text-xs text-gray-400 font-medium">{new Date(row.original.fecha).toLocaleDateString()}</span>
                                </div>
                                <h3 className="font-bold text-gray-800 text-lg mb-1">{row.original.paciente_nombre}</h3>
                                <div className="space-y-2 mb-4">
                                    <div className="flex items-center gap-2 text-sm text-gray-500">
                                        <Activity size={14} className="text-gray-400" />
                                        <span>Cirujano: <span className="font-medium text-gray-700">{row.original.medico_operacion}</span></span>
                                    </div>
                                    {row.original.comentarios && (
                                        <p className="text-xs text-gray-400 line-clamp-1 italic italic">"{row.original.comentarios}"</p>
                                    )}
                                </div>
                                <div className="flex justify-end gap-2 border-t pt-4">
                                    <Link href={route("quirofanos.show", row.original.id)} className="flex-1 text-center py-2 text-sm font-semibold text-gray-600 bg-gray-50 rounded-lg">Ver</Link>
                                    {can('editar reservaciones quirofanos') && (
                                        <Link href={route("quirofanos.edit", row.original.id)} className="flex-1 text-center py-2 text-sm font-semibold text-blue-600 bg-blue-50 rounded-lg">Editar</Link>
                                    )}
                                </div>
                            </div>
                        );
                    })
                ) : (
                    <div className="text-center py-10 text-gray-400">No hay registros</div>
                )}
            </div>

            {/* Desktop View (Table) - Hidden on mobile */}
            <div className="hidden md:block bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div className="overflow-x-auto">
                    <table className="w-full text-left">
                        <thead className="bg-gray-50/50 border-b border-gray-100">
                            {table.getHeaderGroups().map((hg) => (
                                <tr key={hg.id}>
                                    {hg.headers.map((header) => (
                                        <th key={header.id} className="px-6 py-4 text-[11px] font-bold text-gray-400 uppercase tracking-widest">
                                            {flexRender(header.column.columnDef.header, header.getContext())}
                                        </th>
                                    ))}
                                </tr>
                            ))}
                        </thead>
                        <tbody className="divide-y divide-gray-50">
                            {table.getRowModel().rows.map((row) => (
                                <tr
                                    key={row.id}
                                    className="hover:bg-indigo-50/30 cursor-pointer transition-colors group"
                                    onClick={() => router.get(route("quirofanos.show", row.original.id))}
                                >
                                    {row.getVisibleCells().map((cell) => (
                                        <td key={cell.id} className="px-6 py-4 text-sm">
                                            {flexRender(cell.column.columnDef.cell, cell.getContext())}
                                        </td>
                                    ))}
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
            
            {/* Pagination */}
            <div className="flex flex-col sm:flex-row items-center justify-between gap-4 pt-4 border-t border-gray-100">
                <div className="text-xs font-medium text-gray-500 bg-gray-100 px-4 py-2 rounded-full">
                    Mostrando <span className="text-gray-900">{table.getRowModel().rows.length}</span> de <span className="text-gray-900">{data.length}</span> cirugías
                </div>
                <div className="flex gap-2 w-full sm:w-auto">
                    <button 
                        onClick={() => table.previousPage()} 
                        disabled={!table.getCanPreviousPage()}
                        className="flex-1 sm:flex-none px-5 py-2 border border-gray-200 rounded-xl text-xs font-bold hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all"
                    > Anterior </button>
                    <button 
                        onClick={() => table.nextPage()} 
                        disabled={!table.getCanNextPage()}
                        className="flex-1 sm:flex-none px-5 py-2 bg-white border border-gray-200 rounded-xl text-xs font-bold hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition-all"
                    > Siguiente </button>
                </div>
            </div>
        </div>
    );
};

Index.layout = (page: React.ReactNode) => (
    <MainLayout pageTitle="Listado Quirófanos" link="rerservaciones.reserva">
        {page}
    </MainLayout>
);

export default Index;