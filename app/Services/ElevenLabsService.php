<?php

namespace App\Services;

use GuzzleHttp\Client;

class ElevenLabsService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('ELEVENLABS_API_KEY');
    }

    public function textToSpeech($text, $voiceId = 'Xb7hH8MSUJpSbSDYk0k2')
    {
        $url = "https://api.elevenlabs.io/v1/text-to-speech/{$voiceId}";
        $response = $this->client->post($url, [
            'headers' => [
                'Content-Type' => 'application/json',
                'xi-api-key' => $this->apiKey,
                'Accept' => 'audio/mpeg',
            ],
            'json' => [
                'text' => $text,
                'model_id' => 'eleven_monolingual_v1',
                'voice_settings' => [
                    'stability' => 0.5,
                    'similarity_boost' => 0.5,
                ],
            ],
        ]);

        return $response->getBody()->getContents();
    }
}
