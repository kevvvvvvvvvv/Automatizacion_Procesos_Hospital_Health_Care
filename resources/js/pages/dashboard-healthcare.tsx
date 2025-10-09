import React from 'react';
import { FaUser } from "react-icons/fa";
import { LuBedSingle } from "react-icons/lu";
import { RiArchiveDrawerFill } from "react-icons/ri";
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
    const { props } = usePage<PageProps>();
    const user = props.auth.user;

    return (
        <>
            <Head title="Dashboard" />
            <MainLayout userName={user.nombre}>
                <div className="p-4 max-w-sm mx-auto">
                </div>
                <div>
                    <CardButton
                        icon={FaUser}
                        text="Pacientes"
                        bgColor="#1B1C38"
                        onClick={() => router.visit(route('pacientes.index'))}
                    />
                </div>
                <div>
                    <CardButton
                        icon={LuBedSingle}
                        text="Habitaciones"
                        bgColor="#1B1C38"
                        onClick={() => router.visit(route('habitaciones.index'))}
                    />
                </div>
                <div>
                    <CardButton
                        icon={RiArchiveDrawerFill}
                        text="Productos y servicios"
                        bgColor="#1B1C38"
                        onClick={() => router.visit(route('producto-servicios.index'))}
                    />
                </div>
            </MainLayout>
        </>
    );
}
