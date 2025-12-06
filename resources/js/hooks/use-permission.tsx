import { usePage } from '@inertiajs/react';
import { PageProps } from '@/types';

export const usePermission = () => {
    const { props } = usePage<PageProps>();
    const user = props.auth.user;

    /**
     * Verifica si el usuario tiene un permiso específico o es admin.
     * @param permissionName 
     */
    const can = (permissionName: string): boolean => {
        const userRoles = user.roles || [];
        const userPermissions = user.permissions || [];

        // El rol 'admin' siempre tiene acceso total
        if (userRoles.includes('administrador')) {
            return true;
        }

        return userPermissions.includes(permissionName);
    };

    /**
     * Verifica si el usuario tiene AL MENOS UNO de los permisos listados.
     * @param permissionsArray Array de permisos
     */
    const canAny = (permissionsArray: string[]): boolean => {
        const userRoles = user.roles || [];
        if (userRoles.includes('administrador')) return true;
        
        const userPermissions = user.permissions || [];
        return permissionsArray.some(p => userPermissions.includes(p));
    };

    const userRoles = user.roles || [];
    const hasRole = (roleName: string) => {
        return userRoles.includes(roleName);
    };

    return { can, canAny, user, hasRole };
};