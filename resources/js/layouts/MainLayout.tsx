import React, { useState, useEffect, useRef } from 'react';
import { Link } from '@inertiajs/react';
import { Toaster } from 'react-hot-toast';

type Notification = {
    id: string;
    message: string;
    time: string;
    read: boolean;
};

type MainLayoutProps = {
    children: React.ReactNode;
    userName?: string;
    pageTitle?: string;
    // authUserId?: number; 
};

const HomeIcon = () => (
    <svg
        xmlns="http://www.w3.org/2000/svg"
        className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        strokeWidth={2}
    >
        <path strokeLinecap="round" strokeLinejoin="round" d="M3 12l9-9 9 9v9a3 3 0 01-3 3h-3a3 3 0 01-3-3v-6H6a3 3 0 00-3 3v3z" />
    </svg>
);

const BellIcon = () => (
    <svg 
        xmlns="http://www.w3.org/2000/svg" 
        className="h-6 w-6" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke="currentColor" 
        strokeWidth={2}
    >
        <path 
        strokeLinecap="round" 
        strokeLinejoin="round" 
        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-5-5.917V5a1 1 0 00-2 0v.083A6 6 0 006 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" 
        />
    </svg>
    );

const MainLayout: React.FC<MainLayoutProps> = ({ children, userName, pageTitle }) => {
  
    const [isPanelOpen, setIsPanelOpen] = useState(false);
    const [notifications, setNotifications] = useState<Notification[]>([]);
    const panelRef = useRef<HTMLDivElement>(null);
    const buttonRef = useRef<HTMLButtonElement>(null);

    useEffect(() => {
        // MOCKUP: Simular carga de datos
        setTimeout(() => {
        setNotifications([
            { id: '1', message: 'Nueva denuncia registrada (#DEN-001)', time: 'hace 2 min', read: false },
            { id: '2', message: 'Oficio #123 ha sido actualizado.', time: 'hace 10 min', read: false },
            { id: '3', message: 'Recordatorio: Junta de equipo a las 4pm.', time: 'hace 1 hora', read: true },
        ]);
        }, 1000);
    }, []); 

    useEffect(() => {
        function handleClickOutside(event: MouseEvent) {
        if (
            isPanelOpen &&
            panelRef.current &&
            !panelRef.current.contains(event.target as Node) &&
            buttonRef.current &&
            !buttonRef.current.contains(event.target as Node)
        ) {
            setIsPanelOpen(false);
        }
        }
        document.addEventListener('mousedown', handleClickOutside);
        return () => {
        document.removeEventListener('mousedown', handleClickOutside);
        };
    }, [isPanelOpen, panelRef, buttonRef]); 

    const unreadCount = notifications.filter(n => !n.read).length;


    return (
        <div className="min-h-screen bg-gray-100 flex flex-col md:flex-row">
        <Toaster position="top-right" reverseOrder={false} />
        
        <aside className="w-full md:w-20 bg-[#1B1C38] flex flex-row md:flex-col items-center justify-center md:justify-start py-4 md:py-6 shadow order-2 md:order-1 gap-2 md:gap-4">
            
            <Link
            href="/"
            className="flex flex-col items-center justify-center p-3 rounded-md text-white hover:bg-[#16172d] transition"
            title="Inicio"
            >
            <HomeIcon />
            <span className="text-xs mt-1 select-none hidden md:block">Inicio</span>
            </Link>

            <div className="relative">
            <button
                ref={buttonRef} 
                onClick={() => setIsPanelOpen(prev => !prev)}
                className="relative flex flex-col items-center justify-center p-3 rounded-md text-white hover:bg-[#16172d] transition"
                title="Notificaciones"
            >
                <BellIcon />
                {unreadCount > 0 && (
                <span className="absolute top-2 right-2 flex h-2.5 w-2.5">
                    <span className="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                    <span className="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-500 border border-white"></span>
                </span>
                )}
                <span className="text-xs mt-1 select-none hidden md:block">Avisos</span>
            </button>

            {isPanelOpen && (
                <div
                ref={panelRef} 
                className="absolute z-50 w-80 bg-white rounded-lg shadow-xl text-gray-900
                            bottom-full mb-2 left-1/2 -translate-x-1/2 /* <-- Posición Móvil (Centrado) */
                            md:left-full md:top-0 md:ml-2 md:bottom-auto md:-translate-x-0 md:right-auto /* <-- Posición Desktop (A la derecha) */"
                >
                <div className="flex justify-between items-center p-4 border-b">
                    <h3 className="font-semibold text-lg">Notificaciones</h3>
                    {unreadCount > 0 && (
                    <button 
                        onClick={() => setNotifications(prev => prev.map(n => ({ ...n, read: true })))}
                        className="text-xs text-blue-600 hover:underline"
                    >
                        Marcar todas como leídas
                    </button>
                    )}
                </div>
                

                <ul className="divide-y max-h-80 overflow-y-auto">
                    {notifications.length > 0 ? (
                    notifications.map(notif => (
                        <li 
                        key={notif.id} 
                        className={`p-4 hover:bg-gray-50 ${!notif.read ? 'bg-blue-50' : ''}`}
                        >
                        <p className={`text-sm ${!notif.read ? 'font-semibold' : 'font-normal'}`}>
                            {notif.message}
                        </p>
                        <span className="text-xs text-gray-500">{notif.time}</span>
                        </li>
                    ))
                    ) : (
                    <li className="p-6 text-center text-gray-500">
                        No hay notificaciones nuevas.
                    </li>
                    )}
                </ul>

                <div className="p-2 text-center border-t">
                    <Link href="/notificaciones" className="text-sm text-blue-600 hover:underline" onClick={() => setIsPanelOpen(false)}>
                    Ver todas las notificaciones
                    </Link>
                </div>
                </div>
            )}
            </div>
        </aside>

        <div className="flex-1 flex flex-col order-1 md:order-2">
            {/* Header */}
            <header className="flex items-center gap-4 p-4 bg-white shadow">
            <img src="/images/flor.png" alt="Logo" className="h-10 w-auto" />
            {userName && <h1 className="text-2xl font-bold">Hola {userName}</h1>}
            <div>
            
            </div>
            </header>

            {/* Main */}
            <main className="p-6 flex-1 overflow-auto">
            {pageTitle && <h2 className="text-3xl mb-4 text-center font-extrabold">{pageTitle}</h2>}
            {children}
            </main>
        </div>
        </div>
    );
};

export default MainLayout;