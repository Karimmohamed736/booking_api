<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use App\Models\Event;



class EventService
{

    public function index()
    {
        return Cache::remember('events', 60, function(){
            return Event::Available()->get();
        });
    }

    public function allWithCategory()
    {
        return Cache::remember('events_with_category', 60, function(){
            return Event::with('category')->get(); //Eager Loading
        });
    }

    public function create(array $data)
    {
        $event = Event::create($data);
        $this->clearCache();
        return $event;
    }


    public function show($id)
    {
        return Cache::remember("event_{$id}", 60, function() use ($id) {
            return Event::find($id);
        });
    }

    public function showWithCategory($id)
    {
        return Cache::remember("event_with_category_{$id}", 60, function() use ($id) {
            return Event::with('category')->find($id);
        });
    }

    public function update(Event $event,array $data)
    {
        $event->update($data);
        $this->clearCache($event->id);
        return $event;
    }

    public function delete(Event $event)
    {
        $result =  $event->delete();
        $this->clearCache($event->id);
        return $result;
    }

    private function clearCache($id = null)
    {
        Cache::forget('events');
        Cache::forget('events_with_category');
        if ($id) {
            Cache::forget("event_{$id}");
            Cache::forget("event_with_category_{$id}");
        }
    }
}
