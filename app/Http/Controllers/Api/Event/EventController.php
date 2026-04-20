<?php

namespace App\Http\Controllers\Api\Event;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\EventService;

class EventController extends Controller
{

    protected $eventService;
    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }

    private function notFound()
    {
        return response()->json([
            'success' => false,
            'message' => 'Event Not Found',
        ], 404);
    }

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
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'event' => new EventResource($event),
        ],200);
    }

    public function showWithCategory($id)
    {
        $event = $this->eventService->showWithCategory($id);

        if (!$event) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'event' => new EventResource($event),
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        $this->eventService->update($event, $request->validated());
        return response()->json([
            'success' => true,
            'message' => 'Event Updated Successfully'
        ], 200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Event $event)
    {

        $this->eventService->delete($event);
        return response()->json([
            'success' => true,
            'message' => 'Event Deleted Successfully'
        ], 200);
    }
}
