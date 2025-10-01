import React from 'react';
import MainLayout from '@/layouts/MainLayout';
import { usePage } from '@inertiajs/react';

const Create = () => {
  // Recuperamos la info enviada desde el backend (Inertia props)
  const { auth, title } = usePage().props as {
    auth: { user: { name: string } };
    title: string;
  };

  return (
    <div className="p-6 text-center">
      <h1 className="text-2xl font-bold">
        Hola {auth?.user?.name || 'Usuario'}
      </h1>
      <p className="text-lg text-gray-600 mt-2">{title}</p>
    </div>
  );
};

Create.layout = (page: React.ReactNode) => (
  <MainLayout children={page} />
);

export default Create;
