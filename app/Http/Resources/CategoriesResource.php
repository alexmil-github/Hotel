<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'code' =>$this->code,
            'name' => $this->name,
            'number_of_apartments' => $this->number_of_apartments,
            'guests' => $this->guests,
            'square' => $this->square,
            'number_of_rooms' => $this->number_of_rooms,
            'description' => $this->description,
        ];
    }
}
