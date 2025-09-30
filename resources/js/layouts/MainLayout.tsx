import React from 'react';

type MainLayoutProps = {
    children: React.ReactNode;
    title: string;
  };

const MainLayout: React.FC<MainLayoutProps> = ({ children, title }) => {
    return (
        <div className="min-h-screen bg-gray-100">
        
        {/* <Navbar /> */}

        <main>
            <h1 className="text-3xl font-bold text-black">
                {title}
            </h1>
            {children}
        </main>
        
        {/* <Footer /> */}
        </div>
        
    );
};

export default MainLayout;