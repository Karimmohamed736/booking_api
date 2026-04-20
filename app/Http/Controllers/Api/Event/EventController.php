<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Http\Services\EventService;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    protected $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = $this->eventService->index();

        return response()->json([
            'success' => true,
            'events' => EventResource::collection($events)
        ], 200);
    }

    public function allWithCategory()
    {
        $events = $this->eventService->allWithCategory();

        return response()->json([
            'success' => true,
            'events' => EventResource::collection($events)
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EventRequest $request)
    {
        //validation and create (service layer)
        $event = $this->eventService->create($request->validated());
        $event->addMedia($request->file('image'))->toMediaCollection('main_image');


        return response()->json([
            'success' => true,
            'message' => 'Event Created Successfully'
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $event = $this->eventService->show($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'event' => new EventResource($event),
        ]);
    }

    public function showWithCategory($id)
    {
        $event = $this->eventService->showWithCategory($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event Not Found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'event' => new EventResource($event),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }
}
