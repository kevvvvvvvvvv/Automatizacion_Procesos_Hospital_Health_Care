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
import { Pencil } from "lucide-react";
import { User } from '@/types';


type Habitacion = {
    identificador: string;
    tipo: string;
};

type ReservacionHorario = {
    fecha_hora: string;
    habitacion: Habitacion | null;
};

type Reservacion = {
    id: number;
    localizacion: string;
    fecha: string;
    horas: number;
    horarios: ReservacionHorario[];
    estatus: string;
    user: User | null; 
    stripe_payment_id:string;
};

interface Props {
    reservaciones: Reservacion[];
}


const Index = ({ reservaciones }: Props) => {
    const [globalFilter, setGlobalFilter] = useState("");
    const [sorting, setSorting] = useState<SortingState>([]);

    const data = useMemo(() => reservaciones ?? [], [reservaciones]);

    const columns = useMemo<ColumnDef<Reservacion>[]>(() => [
        {
        accessorKey: "fecha",
        header: "Fecha",
        cell: ({ row }) =>
            new Date(row.original.fecha).toLocaleDateString("es-MX"),
        },
        {
        id: "horario",
        header: "Horario",
        cell: ({ row }) =>
            row.original.horarios.length
            ? new Date(row.original.horarios[0].fecha_hora).toLocaleString("es-MX")
            : "—",
        },
        {
        id: "localizacion",
        header: "Hubicacion",
        cell: ({row}) =>
            row.original.localizacion ?? "No encontrado",
        },
        {
        id: "consultorio",
        header: "Consultorio",
        cell: ({ row }) =>
            row.original.horarios[0]?.habitacion?.identificador ?? "No asignado",
        },
        {
        id: "usuario",
        header: "Reservado por",
        cell: ({ row }) => {
            const user = row.original.user;
            return (
            <span className="font-medium text-gray-700">
                {user ? ( user.nombre || "Sin nombre") : "N/A"}
            </span>
            );
        },
        },
        {
        id: "Estatus",
        header: "Estatus",
        cell: ({row}) =>
            row.original.estatus ?? "No encontrado",
        },
        {
            id: 'stripe_payment_id',
            header: 'Código de pago',
            cell: ({row}) => row.original.stripe_payment_id
        },
        {
        id: "acciones",
        header: "Acciones",
        cell: ({ row }) => (
            <Link
                href={route("reservaciones.edit", reservaciones)}
                onClick={(e) => e.stopPropagation()}
                className="p-2 text-blue-600 hover:bg-blue-100 rounded-full"
            >
                <Pencil size={18} />
            </Link>
        ),
        },
    ], []);

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
        <Head title="Reservaciones" />

        <div className="p-4 md:p-8">
            <div className="flex justify-between mb-6">
            <h1 className="text-3xl font-bold text-black">
                Listado de reservaciones
            </h1>

            <AddButton href={route("reservaciones.create")}>
                Crear reservación
            </AddButton>
            </div>

            <input
            type="text"
            value={globalFilter}
            onChange={(e) => setGlobalFilter(e.target.value)}
            placeholder="Buscar..."
            className="mb-4 w-full max-w-sm p-2 border rounded-lg text-black"
            />

        <div className="overflow-x-auto bg-white rounded-lg shadow">
            <table className="w-full text-sm">
                <thead className="bg-gray-50 uppercase text-xs">
                {table.getHeaderGroups().map((hg) => (
                    <tr key={hg.id}>
                    {hg.headers.map((header) => (
                        <th key={header.id} className="px-6 py-3 text-left">
                        {flexRender(header.column.columnDef.header, header.getContext())}
                        </th>
                    ))}
                    </tr>
                ))}
                </thead>

                <tbody>
                {table.getRowModel().rows.map((row) => (
                    <tr
                    key={row.id}
                    className="border-b hover:bg-gray-100 cursor-pointer transition"
                    onClick={() =>
                        router.get(route("reservaciones.show", { reservacione: row.original.id }))
                    }
                    >
                    {row.getVisibleCells().map((cell) => (
                        <td key={cell.id} className="px-6 py-4 text-black">
                        {flexRender(cell.column.columnDef.cell, cell.getContext())}
                        </td>
                    ))}
                    </tr>
                ))}
                </tbody>
            </table>
            </div>
        </div>
        </>
    );
};

Index.layout = (page: React.ReactNode) => (
    <MainLayout pageTitle="Reservaciones de consultorio" link="rerservaciones.reserva">
        {page}
    </MainLayout>
);

export default Index;
