import { loadStripe } from '@stripe/stripe-js';
const publicKey = import.meta.env.VITE_STRIPE_KEY;

if (!publicKey) {
  console.error("¡Cuidado! No se encontró la clave VITE_STRIPE_KEY en el .env");
}

export const stripePromise = loadStripe(publicKey);