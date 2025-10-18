import React from 'react';
import { Link } from '@inertiajs/react'; 
import { Toaster } from 'react-hot-toast';

type MainLayoutProps = {
  children: React.ReactNode;
  userName?: string;
  pageTitle?: string;
};

const HomeIcon = () => (
  <svg
    xmlns="http://www.w3.org/2000/svg"
    className="h-6 w-6"
    fill="none"
    viewBox="0 0 24 24"
    stroke="currentColor"
    strokeWidth={2}
  >
    <path strokeLinecap="round" strokeLinejoin="round" d="M3 12l9-9 9 9v9a3 3 0 01-3 3h-3a3 3 0 01-3-3v-6H6a3 3 0 00-3 3v3z" />
  </svg>
);

const MainLayout: React.FC<MainLayoutProps> = ({ children, userName, pageTitle }) => {

  return (
    <div className="min-h-screen bg-gray-100 flex flex-col md:flex-row">
      <Toaster position="top-right" reverseOrder={false} />
      {/* Sidebar (primero en DOM) */}
      <aside className="w-full md:w-20 bg-[#1B1C38] flex flex-row md:flex-col items-center justify-center md:justify-start py-4 md:py-6 shadow order-2 md:order-1 gap-2 md:gap-4">
        <Link
          href="/"
          className="flex flex-col items-center justify-center p-3 rounded-md text-white hover:bg-[#16172d] transition"
          title="Inicio"
        >
          <HomeIcon />
          <span className="text-xs mt-1 select-none hidden md:block">Inicio</span>
        </Link>
      </aside>

      {/* Contenido principal */}
      <div className="flex-1 flex flex-col order-1 md:order-2">
        {/* Header */}
        <header className="flex items-center gap-4 p-4 bg-white shadow">
         <img src="/images/flor.png" alt="Logo" className="h-10 w-auto" />
          {userName && <h1 className="text-2xl font-bold">Hola {userName}</h1>}
          <div>
          
        </div>
        </header>

        {/* Main */}
        <main className="p-6 flex-1 overflow-auto">
          {pageTitle && <h2 className="text-3xl mb-4 text-center font-extrabold">{pageTitle}</h2>}
          {children}
        </main>
      </div>
    </div>
  );

};

export default MainLayout;
