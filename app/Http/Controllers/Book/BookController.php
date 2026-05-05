<?php

namespace App\Http\Controllers\Book;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookingResource;
use App\Models\Book;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    private function notFound()
    {
        return response()->json([
            'success' => false,
            'message' => 'Event Not Found',
        ], 404);
    }

    //book event
    public function bookEvent(Request $request, $event_id)
    {
        $event = Event::find($event_id);
        //validation
        if (!$event) {
            return $this->notFound();
        }

        //prevent unique booking by same user for same event
        $booking = Book::where('user_id', Auth::id())->where('event_id', $event_id)->exists();
        if ($booking) {
            return response()->json([
                'success' => false,
                'message' => 'You have already booked this event.'
            ], 400);
        }

        //check if there are available seats (avoid negative)
        if ($event->available_seats <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'No available seats for this event.'
            ], 409);
        }

        $user = Auth::user();

        //prevent unique booking by same user for same event
        $book = Book::where('user_id', $user->id)->where('event_id', $event_id)->exists();
        if ($book) {
            return response()->json([
                'success' => false,
                'message' => 'You have already booked this event.'
            ], 400);
        }

        //create book
        $book = $event->books()->create([
            'user_id' => $user->id,
            'event_id' => $event_id,
            'status' => $request->status?? 'pending',
        ]);



        //decrease available seats in event
        $event->decrement('available_seats');

        return response()->json([
            'success' => true,
            'message' => 'Event Booked Successfully',
            'book' => new BookingResource($book),
        ], 201);
    }
}
