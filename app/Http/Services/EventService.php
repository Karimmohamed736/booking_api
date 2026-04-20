<?php

namespace App\Http\Services;

use App\Models\Event;



class EventService
{

    public function index()
    {
        $events = Event::get();
        return $events;
    }

    public function allWithCategory()
    {
        $events = Event::with('category')->get();  //Eager Loading
        return $events;
    }

    public function create($data)
    {
        $event = Event::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'location' => $data['location'],
            'start_date' => $data['start_date'],
            'available_seats' => $data['available_seats'],
            'category_id' => $data['category_id'],
        ]);

        return $event;
    }


    public function show($id)
    {
        $event = Event::find($id);
        return $event;
    }

    public function showWithCategory($id)
    {
        $event = Event::with('category')->find($id);
        return $event;
    }
}
