import React from "react";
import { Head } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { router} from "@inertiajs/react";
import { MdLocalHospital, MdMedicalServices } from "react-icons/md"
import { route } from "ziggy-js";

import { usePermission } from "@/hooks/use-permission";

export default function Reserva () {

    const { can } = usePermission();
    
    return (
        <MainLayout pageTitle="Reservaciones" link="dashboard">
            <Head title={"Selecione su reserva"}/>
            <div className="p-4 max-w-sm mx-auto">
            </div>
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 p-4">
                {/* Botón Consultorios */}
                {can('consultar consultorios') && (
                    <>
                        <button
                            onClick={() => router.visit(route('reservaciones.index'))}
                            className="h-40 text-xl flex flex-col items-center justify-center gap-3 bg-white rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-gray-100 group"
                        >
                            <MdLocalHospital className="text-5xl text-blue-600 group-hover:text-blue-700" />
                            <span className="font-semibold text-gray-700">Consultorios</span>
                        </button>
                    </>
                )}

                {/* Botón Quirófanos */}
                {can('consultar reservaciones quirofanos') && (
                    <>
                        <button   className="h-40 text-xl flex flex-col items-center justify-center gap-3 bg-white rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-gray-100 group"
                            onClick={() => router.visit(route('quirofanos.index'))}>
                            
                            <MdMedicalServices className="text-5xl text-red-600 group-hover:text-red-700" />
                            <span className="font-semibold text-gray-700">Quirófanos</span>
                        </button>
                    </>
                )}
            </div>
        </MainLayout>
    );
}