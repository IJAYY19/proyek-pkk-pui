<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatAIController extends Controller
{
    /**
     * Handle incoming chat messages and return an AI response using Google Gemini.
     */
    public function handleChat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $userMessage = $request->message;
        $apiKey = env('GEMINI_API_KEY');

        // If API key is present, use Google Gemini 1.5 Flash
        if (!empty($apiKey)) {
            try {
                $systemInstruction = "You are ThoBot, a sweet, warm, and friendly bakery assistant for Tho Cookies. "
                    . "Format your response in simple HTML (using <br>, <strong>, etc.) and DO NOT use markdown. "
                    . "Here is the knowledge base you must strictly follow: "
                    . "1. Menu & Prices: Classic Choco Rp 25.450, Susu Matcha Rp 28.000, Red Velvet Rp 26.300, Vanilla Cream Rp 26.300. "
                    . "2. Store Hours: Open everyday 10:00 - 22:00 WIB. "
                    . "3. Location: Ruko Premium Boulevard Blok C-10. "
                    . "4. Reheating Instructions: Microwave 15-20 seconds or Oven at 175°C for 3-5 minutes. "
                    . "If the user asks something outside of this knowledge base, answer politely and casually while maintaining your sweet bakery helper persona. "
                    . "Be concise and adorable.";

                $response = Http::withHeaders([
                    'Content-Type' => 'application/json',
                ])->withOptions([
                    'verify' => false,
                ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key=' . $apiKey, [
                    'systemInstruction' => [
                        'parts' => [
                            ['text' => $systemInstruction]
                        ]
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $userMessage]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 300,
                    ]
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                        return response()->json([
                            'reply' => $data['candidates'][0]['content']['parts'][0]['text']
                        ]);
                    }
                } else {
                    Log::error('Gemini API Error: ' . $response->body());
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }

        // ==========================================
        // SMART NATURAL-LANGUAGE MATCHING LOGIC (FALLBACK)
        // ==========================================
        $messageLower = Str::lower($userMessage);
        
        if (Str::contains($messageLower, ['buka', 'jam', 'operasional', 'tutup'])) {
            $reply = "Tho Cookies buka setiap hari dari pukul 10.00 hingga 22.00 WIB.";
        } 
        elseif (Str::contains($messageLower, ['alamat', 'lokasi', 'tempat', 'dimana'])) {
            $reply = "Kami berlokasi di Ruko Premium Boulevard Blok C-10.";
        } 
        elseif (Str::contains($messageLower, ['harga', 'menu', 'pilihan'])) {
            $reply = "Berikut adalah daftar menu spesial kami: <br>
            🍪 <strong>Classic Choco:</strong> Rp 25.450 <br>
            🍰 <strong>Red Velvet:</strong> Rp 26.300 <br>
            🍦 <strong>Vanilla Cream:</strong> Rp 26.300 <br>
            🥛 <strong>Susu Matcha:</strong> Rp 28.000";
        } 
        else {
            $reply = "Halo yang manis! 🐰 Saya ThoBot.<br>
            Coba tanyakan tentang <strong>Menu, Jam Buka,</strong> atau <strong>Lokasi</strong> kami.<br>
            Atau, Anda juga bisa langsung <a href='https://wa.me/628123456789' target='_blank' style='color:var(--honey-orange);font-weight:bold;'>Chat WhatsApp CS kami</a>.";
        }

        // Simulate network delay for realistic typing effect in local fallback
        usleep(800000); // 0.8 second delay

        return response()->json([
            'reply' => $reply
        ]);
    }
}
