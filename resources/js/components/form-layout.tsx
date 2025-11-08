// src/components/ui/FormLayout.tsx
import React from 'react';

type FormLayoutProps = {
    title: string;
    onSubmit: (e: React.FormEvent) => void;
    children: React.ReactNode;
    actions: React.ReactNode;
};

const FormLayout: React.FC<FormLayoutProps> = ({ title, onSubmit, children, actions }) => {
    return (
        <div className="p-1 md:p-8">
            <div className="flex justify-between items-center mb-6">
                <h1 className="flex-1 text-center text-3xl font-bold text-black">
                {title} 
                </h1>
            </div>

            <form 
                onSubmit={onSubmit}
                className="bg-white rounded-lg shadow p-6 max-w-4xl mx-auto"
            >
                {children}
                <div className="flex justify-end space-x-4 pt-4">
                {actions}
                </div>
            </form>
        </div>
    );
};

export default FormLayout;