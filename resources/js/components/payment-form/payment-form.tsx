import React, { useState, FormEvent } from 'react';
import { CardElement, useStripe, useElements } from '@stripe/react-stripe-js';
import axios from 'axios'; 

const PaymentForm = () => {
    const stripe = useStripe();
    const elements = useElements();
    const [error, setError] = useState<string | null>(null);
    const [loading, setLoading] = useState(false);

    const handleSubmit = async (event: FormEvent) => {
        event.preventDefault();

        if (!stripe || !elements) {
        return;
        }

        setLoading(true);

        const cardElement = elements.getElement(CardElement);
        
        if (!cardElement) return;

        const { error, paymentMethod } = await stripe.createPaymentMethod({
        type: 'card',
        card: cardElement,
        });

        if (error) {
        setError(error.message || 'Error desconocido');
        setLoading(false);
        } else {
        try {
            const { id } = paymentMethod;
            
            const response = await axios.post('http://127.0.0.1:8000/api/purchase', 
                {
                    payment_method: id,
                    amount: 100 
                },
                {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json' 
                    }
                }
            );

            console.log('Pago exitoso:', response.data);
            alert('¡Pago realizado con éxito!');
        } catch (err) {
            console.error(err);
            setError('Falló el cobro en el servidor.');
        }
        
        setLoading(false);
        }
    };

  return (
        <form onSubmit={handleSubmit} className="max-w-md mx-auto p-4 border rounded shadow">
        <div className="mb-4">
            <label className="block text-gray-700 text-sm font-bold mb-2">
            Datos de la Tarjeta
            </label>
            <div className="p-3 border rounded bg-white">
            <CardElement options={{
                style: {
                base: {
                    fontSize: '16px',
                    color: '#424770',
                    '::placeholder': {
                    color: '#aab7c4',
                    },
                },
                },
            }} />
            </div>
        </div>

        {error && <div className="text-red-500 text-sm mb-4">{error}</div>}

        <button 
            type="submit" 
            disabled={!stripe || loading}
            className="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
        >
            {loading ? 'Procesando...' : 'Pagar $100 MXN'}
        </button>
        </form>
    );
};

export default PaymentForm;