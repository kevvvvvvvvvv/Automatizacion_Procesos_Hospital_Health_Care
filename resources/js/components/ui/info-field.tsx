import React from 'react';

interface InfoFieldProps {
  label: string;
  value: React.ReactNode; 
  className?: string;
}

const InfoField: React.FC<InfoFieldProps> = ({ label, value, className = '' }) => {
  return (
    <div className={className}>
      <p className="text-sm text-gray-500">{label}</p>
      {typeof value === 'string' ? 
        <p className="text-lg text-black">{value || 'No registrado'}</p> : 
        value
      }
    </div>
  );
};

export default InfoField;