<?php

namespace App\Http\Resources;

use App\Models\Booking_status;
use App\Models\Room_category;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class BookingListResource extends JsonResource
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
            'status' => Booking_status::find($this->booking_status_id)->name ,
            'arr_date' => (new DateTime($this->arr_date))->format('d-m-Y'),
            'dep_date' => (new DateTime($this->dep_date))->format('d-m-Y'),
            'room_category' => Room_category::find($this->room_category_id)->name,
        ];
    }
}
