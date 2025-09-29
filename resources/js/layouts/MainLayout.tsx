import React from 'react';

type MainLayoutProps = {
  children: React.ReactNode;
};

const MainLayout: React.FC<MainLayoutProps> = ({ children }) => {
  return (
    <div className="min-h-screen bg-gray-100">
      
      {/* <Navbar /> */}

      <main>
        {children}
      </main>
      
      {/* <Footer /> */}
    </div>
    
  );
};

export default MainLayout;