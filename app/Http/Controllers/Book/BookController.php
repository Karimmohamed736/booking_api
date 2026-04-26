<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Models\Book;
use App\Models\Event;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function bookEvent(BookRequest $request, $eventId)
    {
        $event = Event::find($eventId);
        //validation
        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event Not Found',
            ], 404);
        }

        $request->validated();

        //prevent unique booking by same user for same event
        $booking = Book::where('user_id', $request->user_id)->where('event_id', $eventId)->exists();
        if ($booking) {
            return response()->json([
                'success' => false,
                'message' => 'You have already booked this event.'
            ], 400);
        }

        if ($event->available_seats <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No available seats for this event.'
            ], 200);
        }

        //create book
        $book = $event->books()->create([
            'user_id' => $request->user_id,
            'status' => $request->status
        ]);



        //decrease available seats in event
        $event->decrement('available_seats');

        return response()->json([
            'success' => true,
            'message' => 'Event Booked Successfully',
            'book' => $book
        ], 201);
    }
}
