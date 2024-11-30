<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Exception;
use Illuminate\Support\Facades\Log;

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

        try {
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

            $audioContent = $response->getBody()->getContents();

            if (empty($audioContent)) {
                throw new Exception('El contenido del audio está vacío.');
            }

            return $audioContent;
        } catch (RequestException $e) {
            Log::error('Error en la solicitud de ElevenLabs: ' . $e->getMessage());
            return null;
        } catch (Exception $e) {
            Log::error('Error general en ElevenLabsService: ' . $e->getMessage());
            return null;
        }
    }
}

