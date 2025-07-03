<?php
namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function event()
    {
        $events = Event::active()
            ->upcoming()
            ->orderBy('start_date')
            ->get();

        return view('event.event', compact('events'));
    }

    public function show(Event $event)
    {
        return view('event.event', compact('events'));
    }

    public function register(Request $request, Event $event): JsonResponse
    {
        if ($event->is_full) {
            return response()->json([
                'success' => false,
                'message' => 'Event sudah penuh!'
            ], 400);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'emergency_contact' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid: ' . $validator->errors()->first()
            ], 400);
        }

        // Check if email already registered for this event
        $existingRegistrations = $event->getRegistrations();
        foreach ($existingRegistrations as $registration) {
            if ($registration['email'] === $request->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Email sudah terdaftar untuk event ini!'
                ], 400);
            }
        }

        $registered = $event->addRegistration($request->only([
            'name', 'email', 'phone', 'address', 'birth_date', 
            'gender', 'emergency_contact', 'notes'
        ]));

        if ($registered) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil mendaftar untuk event!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Gagal mendaftar. Event mungkin sudah penuh.'
        ], 400);
    }
}