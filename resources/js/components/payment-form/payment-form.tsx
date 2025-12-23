import React, { useState, FormEvent } from 'react';
import { CardElement, useStripe, useElements } from '@stripe/react-stripe-js';
import axios from 'axios'; 
import { Lock } from 'lucide-react';

interface PaymentFormProps {
    reservacione: number;
    monto: number;
}

const PaymentForm = ({ reservacione, monto }: PaymentFormProps) => {
    const stripe = useStripe();
    const elements = useElements();
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (event: FormEvent) => {
        event.preventDefault();

        if (!stripe || !elements) return;

        setLoading(true);
        setError(null);

        const cardElement = elements.getElement(CardElement);
        if (!cardElement) return;

        const { error: stripeError, paymentMethod } = await stripe.createPaymentMethod({
            type: 'card',
            card: cardElement,
        });

        if (stripeError) {
            setError(stripeError.message || 'Error desconocido');
            setLoading(false);
        } else {
            try {
                const response = await axios.post(`/reservaciones/${reservacione}/pagar`,
                    {
                        payment_method: paymentMethod.id
                    },
                    {
                        withCredentials: true,
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json' 
                        }
                    }
                );

                console.log('Pago exitoso:', response.data);
                window.location.reload(); 
                
            } catch (err: any) {
                console.error(err);
                setError(err.response?.data?.message || 'Falló el cobro en el servidor.');
            } finally {
                setLoading(false);
            }
        }
    };

    return (
        <form onSubmit={handleSubmit} className="space-y-4">
            <div className="p-3 border border-gray-200 rounded-xl bg-white">
                <CardElement options={{
                    style: {
                        base: {
                            fontSize: '16px',
                            color: '#424770',
                            '::placeholder': { color: '#aab7c4' },
                        },
                    },
                }} />
            </div>

            {error && <div className="text-red-500 text-xs font-bold">{error}</div>}

            <button 
                type="submit" 
                disabled={!stripe || loading}
                className="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2 disabled:opacity-50"
            >
                <Lock size={14} />
                {loading ? 'Procesando...' : `Pagar $${monto} MXN`}
            </button>
        </form>
    );
};

export default PaymentForm;