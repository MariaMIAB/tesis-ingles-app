<?php

namespace App\Http\Controllers;

use App\Services\ElevenLabsService;
use Illuminate\Http\Request;

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

        $text = strip_tags($content->body);
        $audioContent = $this->elevenLabsService->textToSpeech($text);

        return response($audioContent, 200)
            ->header('Content-Type', 'audio/mpeg');
    }
}
