export const formatDate = (dateString: string | Date): string => {
  if (!dateString) return "N/A";
  
  const date = new Date(dateString);
  
  return new Intl.DateTimeFormat('es-MX', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    hour12: true
  }).format(date);
};