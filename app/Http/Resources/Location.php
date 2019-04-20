<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Location extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'beginn' => $this->beginn,
            'end' => $this->end,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
