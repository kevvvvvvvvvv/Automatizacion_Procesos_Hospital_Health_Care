import React, { HTMLAttributes } from 'react';

export default function AppLogoIcon(props: HTMLAttributes<HTMLDivElement>) {
    return (
        <div {...props}>
            <img 
                src="/images/Logo_HC_1.png" 
                alt="Logo" 
                className="block dark:hidden h-full w-full" 
            />
            <img 
                src="/images/Logo_HC_1.png" 
                alt="Logo" 
                className="hidden dark:block h-full w-full" 
            />
        </div>
    );
}