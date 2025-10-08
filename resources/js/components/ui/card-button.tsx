import React from "react";
import { IconType } from "react-icons";

interface IconButtonCardProps {
icon: IconType;
text: string;
bgColor?: string; 
onClick?: () => void;
}

const IconButtonCard: React.FC<IconButtonCardProps> = ({
    icon: Icon,
    text,
    bgColor = "#1B1C38",
    onClick,
}) => {
    return (
        <button
        onClick={onClick}
        className="w-full flex items-center justify-between px-4 py-3 rounded-2xl shadow-md transition-all duration-200 hover:opacity-90 active:scale-[0.98] focus:outline-none hover:cursor-pointer"
        style={{ backgroundColor: bgColor }}
        >
        <div className="flex items-center gap-3">
            <Icon className="text-white text-xl" />
            <span className="text-white font-medium text-base md:text-lg">
            {text}
            </span>
        </div>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            className="h-5 w-5 text-white"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
            strokeWidth={2}
        >
            <path strokeLinecap="round" strokeLinejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        </button>
    );
};

export default IconButtonCard;
