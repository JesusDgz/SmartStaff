<?php

namespace App\Http\Services;

use Twilio\Rest\Client;

class TwilioService
{
    protected Client $twilio;

    public function __construct()
    {
        $this->twilio = new Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
    }

    public function enviarWhatsapp($to, $mensaje): void
    {
        $this->twilio->messages->create(
            'whatsapp:' . $to,
            [
                'from' => 'whatsapp:' . config('services.twilio.from'),
                'body' => $mensaje,
            ]
        );
    }

    // O si usas un template (opcional)
    public function enviarWhatsappConTemplate($to, $contentSid, array $variables): void
    {
        $this->twilio->messages->create(
            'whatsapp:' . $to,
            [
                'from' => 'whatsapp:' . config('services.twilio.from'),
                'contentSid' => $contentSid,
                'contentVariables' => json_encode($variables),
            ]
        );
    }
}
