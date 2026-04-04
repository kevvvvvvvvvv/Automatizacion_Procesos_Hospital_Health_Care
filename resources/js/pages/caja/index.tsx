import React from 'react';
import { AperturaCaja } from './apertura-caja';
import { PanelCaja } from './panel-caja';
import { SesionCaja, Caja, MetodoPago } from '@/types';
import { Head } from '@inertiajs/react';

import MainLayout from '@/layouts/MainLayout';

interface Props {
    sesionActiva: SesionCaja;
    cajas: Caja[];
    fondo: SesionCaja;
    metodos_pago: MetodoPago []
}

const Index = ({ 
    sesionActiva,
    cajas, 
    fondo,
    metodos_pago = [],
}: Props) => {

    const renderContent = () => {
        if (!sesionActiva) {
            return <AperturaCaja 
                        cajas={cajas}
                    />;
        }

        return <PanelCaja 
                    sesion={sesionActiva} 
                    metodos_pago={metodos_pago}
                    fondo={fondo}
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