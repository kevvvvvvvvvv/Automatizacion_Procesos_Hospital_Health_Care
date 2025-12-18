import React from 'react';
import { Elements } from '@stripe/react-stripe-js';
import { stripePromise } from '../../lib/stripe'; 
import PaymentForm from './payment-form'; 

const CheckoutPage = () => {
  return (
    <div className="p-4">
      <h1>Finalizar Compra</h1>
      <Elements stripe={stripePromise}>
        <PaymentForm />
      </Elements>
    </div>
  );
};

export default CheckoutPage;