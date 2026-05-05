import MainLayout from "@/layouts/MainLayout";
import { FaRegHeart, FaFileSignature, FaHeadSideVirus, FaBookMedical} from "react-icons/fa6";
import { Head, usePage, router } from '@inertiajs/react';
import CardButton from '@/components/ui/card-button';
import { route } from 'ziggy-js';
import { usePermission } from '@/hooks/use-permission';
import {PageProps} from '@/types';
import { LuFileText } from "react-icons/lu";

export default function dashboardReportes(){
    const { can, hasRole } = usePermission();
        const { auth } = usePage<PageProps>().props;
return(
    <>
    <Head title=" Reportes"/>
    <MainLayout link="dashboard">
        <div className="p-4 max-w-sm mx-auto">
                </div>
                <div>
                    {can('crear consentimientos') && (
                    <CardButton
                        icon={LuFileText} 
                        text="Formato Liga Fútbol"
                        onClick={() => window.open(route('liga-futbol.pdf'), '_blank')}
                    />
                    )}
                
                </div>
                <div>
                    {can('crear consentimientos') && (
                    <CardButton
                        icon={LuFileText} 
                        text="Formato de paquetes"
                        onClick={() => window.open(route('paquetes.pdf'), '_blank')}
                    />
                    )}
                
                </div>
    </MainLayout>
    </>
);
}