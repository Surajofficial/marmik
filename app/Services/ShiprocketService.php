<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class ShiprocketService
{
    protected $client;
    protected $baseUrl;
    protected $email;      // Shiprocket account email
    protected $password;   // Shiprocket account password

    public function __construct()
    {
        // Initialize Guzzle Client
        $this->client = new Client([
            'verify' => false  // Disable SSL verification if needed
        ]);

        // Base URL for Shiprocket API
        $this->baseUrl = 'https://apiv2.shiprocket.in/v1/external/';

        // Fetch credentials from .env or configure them here
        $this->email = env('SHIPROCKET_EMAIL', 'ranjanamishra39@gmail.com');
        $this->password = env('SHIPROCKET_PASSWORD', 'Mishra@12');
    }

    // Function to get the Shiprocket API token
    public function getToken()
    {
        try {
            $response = $this->client->post($this->baseUrl . 'auth/login', [
                'json' => [
                    'email' => $this->email,
                    'password' => $this->password,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]);

            // Log and decode response
            $body = json_decode($response->getBody(), true);
            Log::info('Token Response: ', $body);

            if (isset($body['token'])) {
                return $body['token'];
            } else {
                throw new \Exception('Token not found in the response.');
            }
        } catch (\Exception $e) {
            Log::error('Error fetching token: ' . $e->getMessage());
            return null;
        }
    }

    // Function to track an order
    public function trackOrder($awb)
    {
        // Fetch the token
        $token = $this->getToken();

        if (!$token) {
            return ['error' => 'Failed to fetch token'];
        }

        try {
            $response = $this->client->get($this->baseUrl . "courier/track/awb/$awb", [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ],
            ]);

            // Log and return response
            $body = json_decode($response->getBody(), true);
            Log::info('Track Order Response: ', $body);
            return $body;
        } catch (\Exception $e) {
            Log::error('Error tracking order: ' . $e->getMessage());
            return ['error' => 'Failed to track order'];
        }
    }

    // Function to create an order
    public function createOrder($orderData)
    {
        // Fetch the token
        $token = $this->getToken();

        if (!$token) {
            return ['error' => 'Failed to fetch token'];
        }

        try {
            $response = $this->client->post($this->baseUrl . 'orders/create/adhoc', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $orderData,
            ]);

            // Log and return response
            $body = json_decode($response->getBody(), true);
            Log::info('Create Order Response: ', $body);
            return $body;
        } catch (\Exception $e) {
            Log::error('Error creating order: ' . $e->getMessage());
            return ['error' => 'Failed to create order'];
        }
    }
}

