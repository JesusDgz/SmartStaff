<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\TwilioService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AlertaController extends Controller
{
    protected TwilioService $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function enviarUbicacion(Request $request)
    {
        Log::info("datos de la app", $request->all());
        return 200;

        try {
            $request->validate([
                'type' => 'required|string',
                'event' => 'required|string',
                'location.lat' => 'required|numeric',
                'location.lng' => 'required|numeric',
            ]);

            $lat = $request->input('location.lat');
            $lng = $request->input('location.lng');

            // Usuario ficticio para pruebas
            $user = (object)[
                'name' => 'Juancho',
                'contactoEmergencia' => (object)[
                    'telefono' => '+5216251480821'
                ]
            ];

            $link = "https://maps.google.com/?q={$lat},{$lng}";
            $mensaje = "🚨 *{$user->name}* ha enviado una ubicación de emergencia.\n📍 Ubicación: $link\n🔔 Evento: {$request->event}";

            // Enviar por WhatsApp
            $this->twilio->enviarWhatsapp(+5216251480821, $mensaje);

            return response()->json(['message' => 'Ubicación enviada con éxito'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Datos inválidos',
                'detalle' => $e->validator->errors()
            ], 422);
        } catch (\Twilio\Exceptions\TwilioException $e) {
            return response()->json([
                'error' => 'Error con Twilio',
                'detalle' => $e->getMessage()
            ], 502);
        } catch (\Exception $e) {
            Log::error('Error al enviar ubicación real con Twilio:', ['exception' => $e]);

            return response()->json([
                'error' => 'Error inesperado',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }
}
