<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioWhatsAppService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function sendMessage($recipientNumber, $message)
    {

        $formattedRecipient = 'whatsapp:' . $recipientNumber;
        
        try {
            return $this->client->messages->create(
                $formattedRecipient,
                [
                    'from' => config('services.twilio.whatsapp_from'),
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            \Log::error("Error enviando WhatsApp: " . $e->getMessage());
            return null;
        }
    }
}