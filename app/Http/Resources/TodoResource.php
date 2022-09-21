<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
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
            'id' => $this->id,
            'body' => $this->body,
            'done' => $this->done,
            'created_at' => $this->created_at->diffForHumans(),
            'updated_at' => $this->when($this->updated_at > $this->created_at, $this->updated_at->diffForHumans()),
        ];
    }
}
