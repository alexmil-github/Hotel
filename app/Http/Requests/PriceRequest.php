<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceRequest extends ApiRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'date_format:"Y-m-d"|required|after:yesterday',
            'room_category_id' => 'required|exists:room_categories,id',
            'value' => 'required|integer',
            'code' => 'unique'
        ];
    }
}
