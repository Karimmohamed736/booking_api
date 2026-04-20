<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'start_date' => $this->start_date,
            'available_seats' => $this->available_seats,
            'image' => $this->getMedia('main_image')->first()->getUrl(),
            // ->map(function ($media) {
            //     return $media->getUrl(); //get link of img
            // }),
            // 'category'=>$this->category,     // N+1 problem XXXXXXXXXXXX
            'category' => new CategoryResource($this->whenLoaded('category')),  //when i use ::with only
        ];
    }
}
