import React from "react";
import { Form, Head, Link, useForm } from "@inertiajs/react";
import MainLayout from "@/layouts/MainLayout";
import { usePage, router} from "@inertiajs/react";
import CardButton from '@/components/ui/card-button';
import { MdLocalHospital, MdMedicalServices } from "react-icons/md"
import { route } from "ziggy-js";
import { Eye } from "lucide-react";
import InfoField from "@/components/ui/info-field";
import { Button } from "@headlessui/react";
import { User } from "@/types";

interface Props{
    auth: {
        user:User;
    };
}

export default function Reserva () {
    const {auth} = usePage<Props>().props;
    const user = auth.user;
    
    return (
        <MainLayout pageTitle="Reservaciones" link="dashboard">
            <Head title={"Selecione su reserva"}/>
            <div className="p-4 max-w-sm mx-auto">
                </div>
           <div className="grid grid-cols-1 md:grid-cols-2 gap-8 p-4">
    {/* Botón Consultorios */}
    <button
        onClick={() => router.visit(route('reservaciones.index'))}
        className="h-40 text-xl flex flex-col items-center justify-center gap-3 bg-white rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-gray-100 group"
    >
        
        <MdLocalHospital className="text-5xl text-blue-600 group-hover:text-blue-700" />
        <span className="font-semibold text-gray-700">Consultorios</span>
    </button>

    {/* Botón Quirófanos */}
    <button   className="h-40 text-xl flex flex-col items-center justify-center gap-3 bg-white rounded-xl shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300 border border-gray-100 group"
onClick={() => router.visit(route('quirofanos.create'))}>
        
        <MdMedicalServices className="text-5xl text-red-600 group-hover:text-red-700" />
        <span className="font-semibold text-gray-700">Quirófanos</span>
    </button>
</div>
        </MainLayout>
    );
}