import React from 'react';

export type TabItem = {
    id: string | number;
    label: string;
};

type Props = {
    tabs: TabItem[];                    
    activeTab: string | number;         
    onTabChange: (id: any) => void;     
    className?: string;                 
};

export const TabNavigation = ({ 
    tabs, 
    activeTab, 
    onTabChange, 
    className = "mb-6 mt-12" 
}: Props) => {
    return (
        <nav className={className}>
            <div className="border-b border-gray-200">
                <div className="flex flex-nowrap overflow-x-auto -mb-px scrollbar-hide gap-x-6 pb-px" aria-label="Tabs">
                    {tabs.map((tab) => {
                        const isActive = activeTab === tab.id;
                        
                        return (
                            <button
                                key={tab.id}
                                type="button"
                                onClick={() => onTabChange(tab.id)}
                                className={`
                                    whitespace-nowrap py-3 px-1 border-b-2 font-medium text-sm transition-colors duration-150
                                    ${isActive
                                        ? 'border-blue-500 text-blue-600'
                                        : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'
                                    }
                                `}
                                aria-current={isActive ? 'page' : undefined}
                            >
                                {tab.label}
                            </button>
                        );
                    })}
                </div>
            </div>
        </nav>
    );
};

export default TabNavigation;