import React from 'react';
import { FaUser } from "react-icons/fa";
import { LuBedSingle } from "react-icons/lu";
import { RiArchiveDrawerFill , } from "react-icons/ri";
import {FaRegCheckCircle} from "react-icons/fa";
import {FaDatabase} from "react-icons/fa";
import { MdCalendarMonth,  } from "react-icons/md"
import { MdHistory, MdAdd,  } from "react-icons/md";
import { FaUserDoctor, FaBowlFood,  } from "react-icons/fa6";
import { route } from 'ziggy-js';
import { Head, usePage, router } from '@inertiajs/react';
import { usePermission } from '@/hooks/use-permission';
import MainLayout from '@/layouts/MainLayout';
import CardButton from '@/components/ui/card-button';
import {PageProps} from '@/types';

export default function Dashboard() {
    const { can } = usePermission();
    const { auth } = usePage<PageProps>().props;

    return (
        <>
            <Head title="Dashboard" />
            <MainLayout pageTitle={`Dashboard de ${auth.user.roles}`}>
                <div className="p-4 max-w-sm mx-auto">
                </div>
                <div>
                    {can('consultar pacientes') && (
                    <CardButton
                        icon={FaUser}
                        text="Pacientes"
                        onClick={() => router.visit(route('pacientes.index'))}
                    />)}
                </div>
                <div>
                    {can('consultar habitaciones') && (
                    <CardButton
                        icon={LuBedSingle}
                        text="Habitaciones"
                        onClick={() => router.visit(route('habitaciones.index'))}
                    />)}
                </div>
                <div>
                    {can('consultar productos y servicios') && (
                    <CardButton
                        icon={RiArchiveDrawerFill}
                        text="Productos y servicios"
                        onClick={() => router.visit(route('producto-servicios.index'))}
                    />)}
                </div>
                <div>
                    {can('crear productos y servicios') && (
                    <CardButton
                        icon={MdAdd}
                        text="Añadir nuevo producto o servicio"
                        onClick={() => router.visit(route('producto-servicios.create'))}
                    />)}
                </div>      
                
                <div>
                    {can('consultar colaboradores') && (
                    <CardButton
                        icon={FaUserDoctor}
                        text="Colaboradores"
                        onClick={() => router.visit(route('doctores.index'))}
                    />)}
                </div>  
                <div>
                    {can('consultar historial') && (
                    <CardButton
                        icon={MdHistory}
                        text="Historial"
                        onClick={() => router.visit(route('historiales.index'))}
                    />)}
                </div>
                <div>
                    <CardButton
                        icon={MdCalendarMonth}
                        text="Reservar"
                        onClick={() => router.visit(route('rerservaciones.reserva'))}
                    />
                </div>     

                <div>
                    {can('consultar dietas') && (
                     <CardButton
                        icon={FaBowlFood}
                        text="Dietas"
                        onClick={() => router.visit(route('dietas.index'))}
                    />
                    )}
                </div>
                <div>
                    {can('consultar peticion medicamentos') && (
                     <CardButton
                        icon={FaRegCheckCircle}
                        text="Petición de medicamentos"
                        onClick={() => router.visit(route('solicitudes-medicamentos.index'))}
                    />
                    )}
                </div>
                
                <div>
                    {can('consultar base de datos') && (
                     <CardButton
                        icon={FaDatabase}
                        text="Respaldo de la base de datos"
                        onClick={() => router.visit(route('respaldo.index'))}
                    />
                    )}
                </div>                 
            </MainLayout>
        </>
    );
}
