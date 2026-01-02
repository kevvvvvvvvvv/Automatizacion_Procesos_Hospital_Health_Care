import React from 'react';
import { FaUser } from "react-icons/fa";
import { LuBedSingle } from "react-icons/lu";
import { RiArchiveDrawerFill } from "react-icons/ri";
import { MdCalendarMonth } from "react-icons/md"
import { MdHistory, MdAdd } from "react-icons/md";
import { FaUserDoctor, FaBowlFood } from "react-icons/fa6";
import { route } from 'ziggy-js';
import { Head, usePage, PageProps as InertiaPageProps, router } from '@inertiajs/react';
import { User } from '@/types';
import MainLayout from '@/layouts/MainLayout';
import CardButton from '@/components/ui/card-button';


interface PageProps extends InertiaPageProps {
    auth: {
        user: User;
    };
}

export default function Dashboard() {
    const { auth } = usePage<PageProps>().props;
    const user = auth.user;

    const can = (permissionName: string): boolean => {
        const userRoles = user.roles || [];
        const userPermissions = user.permissions || [];

        if (userRoles.includes('admin')) {
            return true;
        }

        return userPermissions.includes(permissionName);
    };

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
                     <CardButton
                        icon={FaBowlFood}
                        text="Dietas"
                        onClick={() => router.visit(route('dietas.index'))}
                    />
                </div>                   
            </MainLayout>
        </>
    );
}
