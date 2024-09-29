<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client as GuzzleClient;

class OpenAIController extends Controller
{
    protected $client;

    public function __construct()
    {
        $apiKey = env('OPENAI_API_KEY');
        $this->client = new GuzzleClient([
            'verify' => false, //  Désactiver la vérification SSL
        ]);
    }

    public function API_barkalalGPT(Request $request)
    {
        $userMessage = $request->input('message');
    
        // Envoyer la requête à OpenAI
        $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $userMessage],
                ],
            ],
        ]);

        $responseBody = json_decode($response->getBody(), true);
        return response()->json($responseBody['choices'][0]['message']['content']);
    }
}
