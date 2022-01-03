<?php

namespace App\Http\Resources;

use App\Models\Room_category;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class PriceResource extends JsonResource
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
            'code' => $this->code,
            'room_category' => Room_category::find($this->room_category_id)->name,
            'value' => $this->value,
            'start_date' => (new DateTime($this->start_date))->format('d-m-Y'),
        ];
    }
}
