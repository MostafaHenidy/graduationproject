<?php

namespace App\Http\Resources\Place;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title' => $this->title,
            'address' => $this->address,
            'body' => $this->body,
            'info' => $this->info,
            'cover_image' => $this->cover_image,
            'created_at'=> $this->created_at->diffForHumans(),
        ];
    }
}
