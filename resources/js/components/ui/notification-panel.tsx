import React, { useState, useEffect, useRef } from 'react';
import { Link, usePage, router } from '@inertiajs/react'; 
import { SharedProps, LaravelNotification } from '@/types';
import { route } from 'ziggy-js'; 

const formatTime = (time: string): string => {
    return new Date(time).toLocaleTimeString('es-MX', { hour: '2-digit', minute: '2-digit' });
};

const NotificationPanel = () => {
    const { props } = usePage<SharedProps>();
    const authUser = props.auth.user;

    const [isPanelOpen, setIsPanelOpen] = useState(false);
    const panelRef = useRef<HTMLDivElement>(null);
 
    const initialNotifications = authUser?.notifications || []; 
    const userId = authUser?.id;
    
    const [notifications, setNotifications] = useState<LaravelNotification[]>(initialNotifications);
    
    useEffect(() => {
        if (!userId) return;

        window.Echo.private(`App.Models.User.${userId}`)
            .notification((notification: any) => { 
                
                console.log('¡Notificación recibida!', notification);
                const newNotif: LaravelNotification = {
                    id: notification.id,
                    type: notification.type,
                    read_at: null,
                    created_at: new Date().toISOString(),
                    data: {
                        message: notification.message,
                        paciente_id: notification.paciente_id,
                        paciente_nombre: notification.paciente_nombre,
                        meds_count: notification.meds_count,
                    }
                };

                setNotifications((prevNotifs: LaravelNotification[]) => [
                    newNotif, 
                    ...prevNotifs
                ]);
            });

        return () => {
            window.Echo.leave(`App.Models.User.${userId}`);
        };
    }, [userId]); 

    if (!authUser) {
        return null; 
    }

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
        <aside className="relative">
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
                        notifications.map((notif: LaravelNotification) => (
                            <li 
                            key={notif.id} 
                            className={`p-4 hover:bg-gray-50 ${!notif.read_at ? 'bg-blue-50' : ''}`}
                            >
                            <p className={`text-sm ${!notif.read_at ? 'font-semibold' : 'font-normal'}`}>
                                {notif.data.message} 
                            </p>
                            <span className="text-xs text-gray-500">
                                {formatTime(notif.created_at)} 
                            </span>
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
        </aside>
    );
};

export default NotificationPanel;