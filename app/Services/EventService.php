<?php

namespace App\Services;

use App\Models\Event;



class EventService
{

    public function index()
    {
        return Event::all();
    }

    public function allWithCategory()
    {
       return Event::with('category')->get();  //Eager Loading
    }

    public function create(array $data)
    {
        return Event::create($data);
    }


    public function show($id)
    {
        return Event::find($id);
    }

    public function showWithCategory($id)
    {
        return Event::with('category')->find($id);
    }

    public function update(Event $event,array $data)
    {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event)
    {
        return $event->delete();
    }
}
