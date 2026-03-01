import MainLayout from "@/layouts/MainLayout";
import { FaRegHeart, FaFileSignature, FaHeadSideVirus, FaBookMedical} from "react-icons/fa6";
import { Head, usePage, router } from '@inertiajs/react';
import CardButton from '@/components/ui/card-button';
import { route } from 'ziggy-js';

export default function dashboardReportes(){
return(
    <>
    <Head title=" Reportes"/>
    <MainLayout link="dashboard">
        <div className="p-4 max-w-sm mx-auto">
                </div>
                <div>
                    <CardButton
                        icon={FaFileSignature}
                        text="Reporte de tios de estancia"
                        onClick={() => router.visit(route('reporte.estancias.show'))}
                     />
                </div>
                <div>
                    <CardButton
                        icon={FaRegHeart}
                        text="Reporte de signos vitales"
                            onClick={() => router.visit(route('reporte.estancias.show'))}
                     />
                </div>
                <div>
                    <CardButton
                        icon={FaHeadSideVirus}
                        text="Reporte de estado de conciencia"
                        onClick={() => router.visit(route('reporte.escalas.show'))}
                     />
                </div><div>
                    <CardButton
                        icon={FaBookMedical}
                        text="Reporte de interconsultas"
                        onClick={() => router.visit(route('reporte.motivos.show'))}
                     />
                </div>
    </MainLayout>
    </>
);
}