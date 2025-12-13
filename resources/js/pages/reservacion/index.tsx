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

type Reservacion = {
  id: number;
  fecha_hora_inicio: string;
  fecha_hora_fin: string;
  habitacion: {
    identificador: string; // Consultorio 1, 2, 3...
    tipo: string;          // consultorio
  } | null;
  user: {
    name: string;
  } | null;
};

interface Props {
  reservaciones: Reservacion[];
}

const Index = ({ reservaciones }: Props) => {
  const [globalFilter, setGlobalFilter] = useState("");
  const [sorting, setSorting] = useState<SortingState>([]);

  const data = useMemo(() => reservaciones ?? [], [reservaciones]);

  const columns = useMemo<ColumnDef<Reservacion>[]>(
    () => [
      {
        accessorKey: "fecha_hora_inicio",
        header: "Inicio",
        cell: ({ row }) => {
          const fecha = new Date(row.original.fecha_hora_inicio);
          return fecha.toLocaleString("es-MX");
        },
      },
      {
        accessorKey: "fecha_hora_fin",
        header: "Fin",
        cell: ({ row }) => {
          const fecha = new Date(row.original.fecha_hora_fin);
          return fecha.toLocaleString("es-MX");
        },
      },
      {
        id: "consultorio",
        header: "Consultorio",
        cell: ({ row }) =>
          row.original.habitacion?.identificador ?? "No asignado",
      },
      {
        id: "tipo",
        header: "Tipo",
        cell: ({ row }) =>
          row.original.habitacion?.tipo ?? "—",
      },
      {
        id: "usuario",
        header: "Reservado por",
        cell: ({ row }) => row.original.user?.name ?? "N/A",
      },
      {
        id: "acciones",
        header: "Acciones",
        cell: ({ row }) => (
          <Link
            href={route("reservaciones.edit", row.original.id)}
            onClick={(e) => e.stopPropagation()}
            className="p-2 text-blue-600 hover:bg-blue-100 rounded-full"
          >
            <Pencil size={18} />
          </Link>
        ),
      },
    ],
    []
  );

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
        <div className="flex items-center justify-between mb-6">
          <h1 className="text-3xl font-bold text-black">
            Listado de Reservaciones
          </h1>
        </div>

        <div className="flex justify-between items-center mb-6">
          <div />
          <AddButton href={route("reservaciones.create")}>
            Crear Reservación
          </AddButton>
        </div>

        <div className="mb-4">
          <input
            type="text"
            value={globalFilter}
            onChange={(e) => setGlobalFilter(e.target.value)}
            placeholder="Buscar..."
            className="w-full max-w-sm p-2 border border-gray-300 rounded-lg text-black"
          />
        </div>

        <div className="overflow-x-auto bg-white rounded-lg shadow">
          <table className="w-full text-sm text-left text-gray-700">
            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
              {table.getHeaderGroups().map((headerGroup) => (
                <tr key={headerGroup.id}>
                  {headerGroup.headers.map((header) => (
                    <th key={header.id} className="px-6 py-3">
                      <div
                        className="flex items-center cursor-pointer select-none"
                        onClick={header.column.getToggleSortingHandler()}
                      >
                        {flexRender(
                          header.column.columnDef.header,
                          header.getContext()
                        )}
                        {{
                          asc: " 🔼",
                          desc: " 🔽",
                        }[header.column.getIsSorted() as string] ?? null}
                      </div>
                    </th>
                  ))}
                </tr>
              ))}
            </thead>

            <tbody>
              {table.getRowModel().rows.map((row) => (
                <tr
                  key={row.id}
                  className="border-b hover:bg-gray-100 cursor-pointer"
                  onClick={() =>
                    router.get(route("reservaciones.show", row.original.id))
                  }
                >
                  {row.getVisibleCells().map((cell) => (
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
            Página{" "}
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

Index.layout = (page: React.ReactNode) => (
  <MainLayout pageTitle="Reservaciones" link="dashboard">
    {page}
  </MainLayout>
);

export default Index;
