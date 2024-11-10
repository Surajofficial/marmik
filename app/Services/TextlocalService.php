<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TextlocalService
{
    protected $apiKey;
    protected $sender;

    public function __construct($apiKey = null, $sender = null)
    {
        $this->apiKey = urlencode($apiKey ?: config('textlocal.api_key'));
        $this->sender = urlencode($sender ?: config('textlocal.sender'));
    }

    public function sendSms($numbers, $message)
    {
        $url = 'https://api.textlocal.in/send/';

        $response = Http::asForm()->post($url, [
            'apikey' => $this->apiKey,
            'numbers' => $numbers,
            'message' => $message,
            'sender' => $this->sender,
        ]);

        return $response->json();
    }
}
