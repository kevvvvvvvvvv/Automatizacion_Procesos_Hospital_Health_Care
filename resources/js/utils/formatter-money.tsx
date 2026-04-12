/**
 * Formatea un número o string a moneda mexicana (MXN).
 * Ejemplo: 1500.5 -> 1,500.50
 */
export const formatMoney = (amount: number | string | undefined): string => {
    return Number(amount || 0).toLocaleString('es-MX', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
};

export const formatCurrency = (amount: number | string | undefined): string => {
    return `$${formatMoney(amount)}`;
};