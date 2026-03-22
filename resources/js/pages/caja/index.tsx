import React from 'react';
import { AperturaCaja } from './apertura-caja';
import { PanelCaja } from './panel-caja';
import { SesionCaja, Caja } from '@/types';

import MainLayout from '@/layouts/MainLayout';

interface Props {
    sesionActiva: SesionCaja | null;
    cajas: Caja[];
}

const Index = ({ 
    sesionActiva,
    cajas, 
}: Props) => {
    
    const renderContent = () => {
        if (!sesionActiva) {
            return <AperturaCaja 
                        cajas={cajas}
                    />;
        }

        return <PanelCaja sesion={sesionActiva} />;
    };

    return (
        <MainLayout>
            <div className="py-6">
                <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {renderContent()}
                </div>
            </div>
        </MainLayout>
    );
}

export default Index;