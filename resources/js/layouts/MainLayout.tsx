import React, { useState, useEffect, useRef } from 'react';
import { Link, usePage, router } from '@inertiajs/react';
import { route } from 'ziggy-js';

import { SharedProps, LaravelNotification } from '@/types';

const formatTime = (time: string): string => {
    return new Date(time).toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
};

interface AlertProps {
    message: string | null;
    type: 'success' | 'error';
    onClose: () => void;
}

type MainLayoutProps = {
    children: React.ReactNode;
    link?: string;
    pageTitle?: string;
    linkParams?: any;    
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
const LogOut = () =>(
    <svg 
    
    xmlns="http://www.w3.org/2000/svg"
    className="h-6 w-6"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        strokeWidth={2}>
    
    <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.252.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"></path>
    </svg>
)
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
const Tools = () =>(
    <svg 
    xmlns="http://www.w3.org/2000/svg" 
    fill="none" 
    viewBox="0 0 24 24" 
    strokeWidth="1.5" 
    stroke="currentColor" 
    className="size-6">
    <path 
    strokeLinecap="round" 
    strokeLinejoin="round" 
    d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
    </svg>
);

const FlashAlert: React.FC<AlertProps> = ({ message, type, onClose }) => {
    
    useEffect(() => {
        if (message) {
            const timer = setTimeout(() => {
                onClose();
            }, 5000); 
            return () => clearTimeout(timer);
        }
    }, [message, onClose]);

    if (!message) {
        return null;
    }

    const baseStyles = "fixed top-5 right-5 z-50 p-4 rounded-lg shadow-lg flex items-center max-w-sm";
    
    const typeStyles = {
        success: "bg-green-100 border border-green-400 text-green-700",
        error: "bg-red-100 border border-red-400 text-red-700"
    };

    const icons = {
        success: (
            <svg className="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clipRule="evenodd" />
            </svg>
        ),
        error: (
            <svg className="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clipRule="evenodd" />
            </svg>
        )
    };

    return (
        <div className={`${baseStyles} ${typeStyles[type]}`} role="alert">
            {icons[type]}
            <span className="flex-1">{message}</span>
            <button
                type="button"
                className={`ml-3 -mr-1 -my-1 p-1 rounded-md ${typeStyles[type]} opacity-70 hover:opacity-100`}
                onClick={onClose}
                aria-label="Cerrar"
            >
                <svg className="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fillRule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clipRule="evenodd" />
                </svg>
            </button>
        </div>
    );
};


const MainLayout = ({ pageTitle, children, link, linkParams }: MainLayoutProps) => {
    

    const { props } = usePage<SharedProps>();
    const { flash, auth } = props;
    const authUser = auth.user;

    const [alert, setAlert] = useState<{ message: string | null, type: 'success' | 'error' }>({
        message: null,
        type: 'success',
    });
    
    const [isPanelOpen, setIsPanelOpen] = useState(false);
    const initialNotifications = authUser?.notifications || []; 
    const [notifications, setNotifications] = useState<LaravelNotification[]>(initialNotifications);
    const panelRef = useRef<HTMLDivElement>(null);
    const buttonRef = useRef<HTMLButtonElement>(null);
    const userId = authUser?.id;

    useEffect(() => {
        if (flash?.success) {
            setAlert({ message: flash.success, type: 'success' });
        } else if (flash?.error) {
            setAlert({ message: flash.error, type: 'error' });
        }
    }, [flash]);
    
    useEffect(() => {
        if (!userId) return;

        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification: any) => { 
                const newNotif: LaravelNotification = {
                    id: notification.id,
                    type: notification.type,
                    read_at: null,
                    created_at: new Date().toISOString(),
                    data: notification 
                };

                setNotifications((prev) => [newNotif, ...prev]);
            });

        return () => {
            window.Echo.leave(`App.Models.User.${userId}`);
        };
    }, [userId]);

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

    const handleCloseAlert = () => {
        setAlert({ message: null, type: 'success' });
    };
    
    const unreadCount = notifications.filter((n: LaravelNotification) => !n.read_at).length;

    const markAllAsRead = () => {
        router.post(route('notifications.mark-all-as-read'), {}, {
            preserveScroll: true,
            onSuccess: () => {
                setNotifications(prev => prev.map((n: LaravelNotification) => ({ ...n, read_at: new Date().toISOString() })))
            }
        });
    }

    return (
        <div className="h-dvh bg-gray-100 flex flex-col md:flex-row overflow-hidden">
        
            <aside className="w-full md:w-20 bg-white flex flex-row md:flex-col items-center justify-center md:justify-start py-4 md:py-6 shadow order-2 md:order-1 gap-2 md:gap-4 shrink-0 z-50">
                
                <Link
                href="/dashboard"
                className="flex flex-col items-center justify-center p-3 rounded-md text-black hover:bg-gray-100 transition"
                title="Inicio"
                >
                    <HomeIcon />
                    <span className="text-xs mt-1 select-none hidden md:block">Inicio</span>
                </Link>


                
                <div className="relative">
                <button
                    ref={buttonRef} 
                    onClick={() => setIsPanelOpen(prev => !prev)}
                    className="relative flex flex-col items-center justify-center p-3 rounded-md text-black hover:bg-gray-100 transition"
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
                                bottom-full mb-2 left-1/2 -translate-x-1/2
                                md:left-full md:top-0 md:ml-2 md:bottom-auto md:-translate-x-0 md:right-auto"
                    >
                    <div className="flex justify-between items-center p-4 border-b">
                        <h3 className="font-semibold text-lg">Notificaciones</h3>
                        {unreadCount > 0 && (
                        <button 
                            onClick={markAllAsRead}
                            className="text-xs text-blue-600 hover:underline"
                        >
                            Marcar todas como leídas
                        </button>
                        )}
                    </div>
                    <ul className="divide-y max-h-80 overflow-y-auto">
                        {notifications.length > 0 ? (
                            notifications.map((notif: LaravelNotification) => {
                                const targetUrl = notif.data.action_url 
                                    || (notif.data.hoja_id ? route('solicitudes-medicamentos.show', { hojasenfermeria: notif.data.hoja_id }) : null);
                                const cardContent = (
                                    <div className={`p-4 hover:bg-gray-50 ${!notif.read_at ? 'bg-blue-50' : ''}`}>
                                        {notif.data.title && (
                                            <p className="text-xs font-bold text-gray-500 uppercase mb-1">
                                                {notif.data.title}
                                            </p>
                                        )}
                                        
                                        <p className={`text-sm ${!notif.read_at ? 'font-semibold' : 'font-normal'}`}>
                                            {notif.data.message}
                                        </p>
                                    
                                        {notif.data.action_text && targetUrl && (
                                            <span className="text-xs text-blue-600 font-medium mt-1 block">
                                                {notif.data.action_text} &rarr;
                                            </span>
                                        )}

                                        <span className="text-xs text-gray-500 block mt-1">
                                            {formatTime(notif.created_at)}
                                        </span>
                                    </div>
                                );
                                return (
                                    <li key={notif.id}>
                                        {targetUrl ? (
                                            <Link 
                                                href={targetUrl}
                                                onClick={() => setIsPanelOpen(false)}
                                                className="block" 
                                            >
                                                {cardContent}
                                            </Link>
                                        ) : (
                                            cardContent
                                        )}
                                    </li>
                                );
                            })
                        ) : (
                            <li className="p-6 text-center text-gray-500">
                                No hay notificaciones nuevas.
                            </li>
                        )}
                    </ul>

                    <div className="p-2 text-center border-t">
                        <Link 
                            href={route('notificaciones.index')} 
                            className="text-sm text-blue-600 hover:underline font-medium" 
                            onClick={() => setIsPanelOpen(false)}
                        >
                            Ver todas las notificaciones
                        </Link>
                        
                    </div>
                    </div>
                )}
                </div>
                    <div className="relative">
                    <Link
                        href={route('logout')}
                        method="post"
                        as="button"
                        className="flex flex-col items-center justify-center p-3 rounded-md text-black hover:bg-gray-100 transition"
                        title="Cerrar Sesión"
                    >

                        <LogOut/>
                        <span className='text-xs mt-1 select-none hidden md:block'>Cerrar Sesión</span>
                    </Link>
                    </div>
                    <Link
                    href={route("mantenimiento.index")}
                    className="flex flex-col items-center justify-center p-3 rounded-md text-black hover:bg-gray-100 transition"
                    title="Inicio"
                    >
                        <Tools />
                        <span className="text-xs mt-1 select-none hidden md:block">Reportar</span>
                    </Link>
            </aside>

            <FlashAlert 
                message={alert.message}
                type={alert.type}
                onClose={handleCloseAlert}
            />
            
            <div className="flex-1 flex flex-col order-1 md:order-2 h-full relative min-h-0 overflow-y-auto">
                <div className='flex flex-row px-6 pt-6 shrink-0'>
                                
                    {link && (
                        <Link className="pr-5" href={route(link, linkParams)}>
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            strokeWidth="1.5"
                            stroke="currentColor"
                            className="size-10 bg-[#1B1C38] text-white rounded-full p-2"
                        >
                            <path
                            strokeLinecap="round"
                            strokeLinejoin="round"
                            d="M15.75 19.5 8.25 12l7.5-7.5"
                            />
                        </svg>
                        </Link>
                    )}
                    
                    <div>
                        <h1 className="text-2xl font-extrabold font-sans">
                            Hola, {authUser?.nombre}
                        </h1>
                        <h3>{pageTitle}</h3>
                    </div>
                </div>

                <main className="px-6 pb-20 md:pb-10 pt-4">
                    {children}
                </main>
            </div>
        </div>
    );
};

export default MainLayout;