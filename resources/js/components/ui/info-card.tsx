import React from 'react';

interface InfoCardProps {
  title: string;
  children: React.ReactNode;
  className?: string;
}

const InfoCard: React.FC<InfoCardProps> = ({ title, children, className = '' }) => {
  return (
    <div className={`mt-6 p-6 bg-white rounded-lg shadow-md ${className}`}>
      <h2 className="text-xl font-semibold border-b pb-2 mb-4">{title}</h2>
      {children}
    </div>
  );
};

export default InfoCard;