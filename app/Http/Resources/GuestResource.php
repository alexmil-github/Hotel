<?php

namespace App\Http\Resources;

use App\Models\Document_types;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class GuestResource extends JsonResource
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
            'name' => $this->name,
            'surname' => $this->surname,
            'patronymic' => $this->patronymic,
            'birthday' => (new DateTime($this->birthday))->format('d-m-Y'),
            'gender' => $this->gender,
            'document_type' => Document_types::find($this->document_type_id)->name,
            'document_number' => $this->document_number,
            'booking_id' => $this->booking_id,
        ];
    }
}
