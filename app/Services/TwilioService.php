<?php

namespace App\Services;

use Twilio\Rest\Client;
use Twilio\Http\GuzzleClient as TwilioGuzzleClient;
use GuzzleHttp\Client as GuzzleHttpClient;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');

        // Crear una instancia de GuzzleHttp\Client
        $guzzleHttpClient = new GuzzleHttpClient([
            // Configura las opciones necesarias para GuzzleHttpClient
        ]);

        // Crear una instancia de Twilio\Http\GuzzleClient usando el GuzzleHttpClient
        $twilioHttpClient = new TwilioGuzzleClient($guzzleHttpClient);

        // Crear la instancia de Twilio\Rest\Client
        $this->twilio = new Client($sid, $token);

        // Establecer el cliente HTTP personalizado
        $this->twilio->setHttpClient($twilioHttpClient);
    }

    public function sendSms($to, $message)
    {
        $from = config('services.twilio.from');

        // Agregar logging para depuración
        Log::info('Twilio From: ' . $from);
        Log::info('Twilio To: ' . $to);
        Log::info('Twilio Message: ' . $message);

        try {
            $this->twilio->messages->create($to, [
                'from' => $from,
                'body' => $message
            ]);
        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
            throw $e;
        }
    }
}