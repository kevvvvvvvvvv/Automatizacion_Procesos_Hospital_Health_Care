export const ActionButton = ({ onClick, children, className }: any) => (
    <button 
        onClick={onClick}
        className={`px-4 py-2 rounded-lg text-sm transition-colors shadow-sm flex items-center ${className}`}
    >
        {children}
    </button>
);