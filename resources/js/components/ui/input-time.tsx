import React, { useMemo } from 'react';
import InputText from '@/components/ui/input-text';

interface Props {
    label: string;
    value: string;
    onChange: (value: string) => void;
    error?: string;
    id?: string;
}


const pad = (numStr: string | number) => {
    return String(numStr).padStart(2, '0');
}

const InputTimeHHMMSS: React.FC<Props> = ({ label, value, onChange, error, id }) => {

    const [hours, minutes, seconds] = useMemo(() => {
        const validValue = value || '00:00:00';
        const parts = validValue.split(':');
        return [
            pad(parts[0] || '00'),
            pad(parts[1] || '00'),
            pad(parts[2] || '00'),
        ];
    }, [value]);


    const handleChange = (part: 'h' | 'm' | 's', newValue: string) => {
        let [h, m, s] = [hours, minutes, seconds];
        let numVal = parseInt(newValue, 10);

        if (isNaN(numVal)) numVal = 0; 

        if (part === 'h') {
            if (numVal > 99) numVal = 99; 
            if (numVal < 0) numVal = 0;
            h = pad(numVal);
        } else if (part === 'm') {
            if (numVal > 59) numVal = 59;
            if (numVal < 0) numVal = 0;
            m = pad(numVal);
        } else if (part === 's') {
            if (numVal > 59) numVal = 59;
            if (numVal < 0) numVal = 0;
            s = pad(numVal);
        }

        onChange(`${h}:${m}:${s}`);
    };

    return (
        <fieldset className="col-span-full">
            <label className="block text-sm font-medium text-gray-700">
                {label}
            </label>
            <div className="mt-1 grid grid-cols-3 gap-2 max-w-xs">
                <InputText
                    id={id ? `${id}-h` : 'time-h'}
                    name={id ? `${id}-h` : 'time-h'}
                    label="Horas"
                    type="number"
                    value={hours}
                    onChange={(e) => handleChange('h', e.target.value)}
                />

                <InputText
                    id={id ? `${id}-m` : 'time-m'}
                    name={id ? `${id}-m` : 'time-m'}
                    label="Minutos"
                    type="number"
                    value={minutes}
                    onChange={(e) => handleChange('m', e.target.value)}
                />

                <InputText
                    id={id ? `${id}-s` : 'time-s'}
                    name={id ? `${id}-s` : 'time-s'}
                    label="Segundos"
                    type="number"
                    value={seconds}
                    onChange={(e) => handleChange('s', e.target.value)}
                />
            </div>

            {error && (
                <p className="mt-2 text-sm text-red-600">{error}</p>
            )}
        </fieldset>
    );
};

export default InputTimeHHMMSS;