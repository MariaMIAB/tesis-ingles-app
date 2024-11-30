<?php

namespace App\Http\Controllers;

use App\Services\ElevenLabsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ElevenLabsController extends Controller
{
    protected $elevenLabsService;

    public function __construct(ElevenLabsService $elevenLabsService)
    {
        $this->elevenLabsService = $elevenLabsService;
    }

    public function textToSpeech(Request $request, $contentId)
    {
        $content = \App\Models\Content::find($contentId);

        if (!$content) {
            return response()->json(['error' => 'Contenido no encontrado'], 404);
        }

        try {
            $text = strip_tags($content->body);
            $audioContent = $this->elevenLabsService->textToSpeech($text);

            if (!$audioContent) {
                throw new Exception('No se pudo generar el audio.');
            }

            return response($audioContent, 200)
                ->header('Content-Type', 'audio/mpeg');
        } catch (Exception $e) {
            Log::error('Error en textToSpeech: ' . $e->getMessage(), [
                'contentId' => $contentId,
                'text' => $text ?? 'Texto no disponible'
            ]);

            return response()->json(['error' => 'Error al generar el audio'], 500);
        }
    }
}


