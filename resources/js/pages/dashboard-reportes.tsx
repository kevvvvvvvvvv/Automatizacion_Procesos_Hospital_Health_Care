import MainLayout from "@/layouts/MainLayout";
import { FaUserDoctor, FaBowlFood,  FaFileSignature} from "react-icons/fa6";
import { Head } from "@inertiajs/react";
import CardButton from '@/components/ui/card-button';

export default function dashboardReportes(){
return(
    <>
    <Head title=" Reportes"/>
    <MainLayout>
        <div className="p-4 max-w-sm mx-auto">
                </div>
         <div>
                    <CardButton
                        icon={FaFileSignature}
                        text="Pacientes"
                        onClick={() => router.visit(route('pacientes.index'))}
                     />
                </div>
        
    </MainLayout>
    </>
);
}