<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'arr_date' => 'date_format:"Y-m-d"|required|after:yesterday',
            'dep_date' => 'date_format:"Y-m-d"|required|after:arr_date',
            'room_category_id' => 'required|exists:room_categories,id',
            'email' => 'required|email',
            'phone' => 'required',
            'city' => 'required',
            'guests' => 'required|array',
        ];
    }
}
