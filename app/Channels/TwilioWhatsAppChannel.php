<?php

namespace App\Channels;

use Illuminate\Notifications\Notification; 
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioWhatsAppChannel
{
    public function send($notifiable, $notification)
    {
        if (!method_exists($notification, 'toWhatsApp')) {
            return;
        }

        $message = $notification->toWhatsApp($notifiable);
        
        $numeroUsuario = $notifiable->routeNotificationFor('twilio');

        if (!$numeroUsuario) {
            return;
        }

        $to = 'whatsapp:' . $numeroUsuario; 
        $from = config('services.twilio.whatsapp_from'); 
        $sid    = config('services.twilio.sid');
        $token  = config('services.twilio.token');

        $twilio = new Client($sid, $token);

        try {
            $twilio->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);
        } catch (\Exception $e) {
            Log::error('Error enviando WhatsApp Twilio: ' . $e->getMessage());
        }
    }
}