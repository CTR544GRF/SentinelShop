<?php

namespace App\Services;

use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class TwilioService
{
    protected $twilio;

    public function __construct()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $this->twilio = new Client($sid, $token);
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