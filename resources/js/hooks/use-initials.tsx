import { useCallback } from 'react';

type UserName = {
    nombre?: string;
};

export function useInitials() {
    return useCallback((user: UserName): string => {
        // Tomamos solo el nombre
        const nombre = user?.nombre?.trim() ?? '';

        if (!nombre) return '';

        return nombre.charAt(0).toUpperCase();
    }, []);
}
