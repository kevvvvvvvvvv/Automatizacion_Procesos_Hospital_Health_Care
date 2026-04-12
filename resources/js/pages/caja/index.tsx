import React from 'react';
import { AperturaCaja } from './apertura-caja';
import { PanelCaja } from './panel-caja';
import { SesionCaja, Caja, MetodoPago, MovimientoCaja } from '@/types';
import { Head } from '@inertiajs/react';

import MainLayout from '@/layouts/MainLayout';

interface Props {
    sesionActiva: SesionCaja;
    cajas: Caja[];
    fondo: SesionCaja;
    metodos_pago: MetodoPago [];
    fecha_filtrada: string;
    movimientos: MovimientoCaja[];
}

const Index = ({ 
    sesionActiva,
    cajas, 
    fondo,
    metodos_pago = [],
    fecha_filtrada,
    movimientos
}: Props) => {

    const renderContent = () => {
        if (!sesionActiva) {
            return <AperturaCaja 
                        cajas={cajas}
                    />;
        }

        return <PanelCaja 
                    fecha_filtrada={fecha_filtrada}
                    sesion={sesionActiva} 
                    metodos_pago={metodos_pago}
                    fondo={fondo}
                    movimientos={movimientos}
                />;
    };

    return (
        <MainLayout
            pageTitle='Registro de caja'
            link='dashboard'
        >
            <Head
                title='Registro de caja'
            />
            <div className="py-6">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {renderContent()}
                </div>
            </div>
        </MainLayout>
    );
}

export default Index;