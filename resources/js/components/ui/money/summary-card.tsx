import { useState } from "react";
import { Eye, EyeOff } from "lucide-react";
import { formatCurrency } from "@/utils/formatter-money";

interface SummaryCardProps {
    label: string;
    amount: string | number;
    theme?: 'default' | 'success' | 'danger' | 'highlight';
    mostrarValor?: boolean
}


export const SummaryCard = ({ 
    label, 
    amount, 
    theme = 'default' ,
    mostrarValor = true,
}: SummaryCardProps) => {
    const themes = {
        default: "bg-white border-gray-100 text-gray-500 value-gray-800",
        success: "bg-white border-green-50 text-green-600 value-gray-800",
        danger: "bg-white border-red-50 text-red-600 value-gray-800",
        highlight: "bg-blue-50 border-blue-100 ring-1 ring-blue-500 ring-opacity-50 text-blue-700 uppercase tracking-wider value-blue-900"
    };

    const currentTheme = themes[theme];
    const isHighlight = theme === 'highlight';
    const [mostrarDinero, setMostrarDinero] = useState(mostrarValor); 

    return (
        <div className={`p-5 rounded-xl shadow-sm border ${currentTheme.split(' ')[0]} ${currentTheme.split(' ')[1]} ${isHighlight ? currentTheme.split(' ')[2] + ' ' + currentTheme.split(' ')[3] + ' ' + currentTheme.split(' ')[4] : ''}`}>
            <p className={`text-sm ${isHighlight ? 'font-bold' : 'font-medium'} ${themes[theme].match(/text-[a-z]+-\d+/)?.[0]}`}>
                {label}
            </p>

            <div className="flex items-center justify-between mt-1 gap-2">
                <p className={`${isHighlight ? 'text-3xl font-black' : 'text-2xl font-bold'} ${themes[theme].match(/value-([a-z]+-\d+)/)?.[1] ? `text-${themes[theme].match(/value-([a-z]+-\d+)/)?.[1]}` : 'text-gray-800'}`}>
                    {mostrarDinero ? `${formatCurrency(amount)}` : '••••••'}
                </p>

                <button
                    onClick={() => setMostrarDinero(!mostrarDinero)}
                    className={`transition-colors duration-200 p-1 rounded-md hover:bg-black/5 ${
                        mostrarDinero 
                            ? 'text-blue-600' 
                            : 'text-gray-400' 
                    }`}
                >   {mostrarDinero ?
                        (<Eye size={20} />) :
                        (<EyeOff size={20}/>)
                    }
                </button>
            </div>
        </div>
    );
};