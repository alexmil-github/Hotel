<?php

namespace App\Http\Controllers;


use App\Http\Requests\PriceRequest;
use App\Http\Resources\PriceResource;
use App\Models\Booking;
use App\Models\Price;
use App\Models\Room_category;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Collection;

class PriceController extends Controller
{

    public function index()
    {
        $prices = Price::all()->reverse();
    }

    public function store(PriceRequest $request)
    {
        $start_date = new DateTime($request->start_date);
        $code = Room_category::find($request->room_category_id)->code . '-' . $start_date->format('d-m-Y');
        if (Price::where('code', $code)->count() > 0) {
            return response()->json([
                'error' => [
                    'code' => 403,
                    'message' => 'The code ' . $code . ' already exist '
                ]
            ], 403);
        } else {
            $price = Price::create([
                    'code' => $code,
                ] + $request->all());
            return new PriceResource($price);
        }


//        return response()->json([
//            'data' => [
//                'id' => $price->id,
//                'code' => $code,
//            ]
//        ])->setStatusCode(201, 'Created');
    }

    public function showPrices(Request $request)
    {
        $request->merge(['id' => $request->route('id')]);
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:room_categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }

        $category = Room_category::find($request->id);
        return PriceResource::collection(Price::where('room_category_id', $category->id)->get());
    }

    public function update(Request  $request, $id)
    {
        $request->merge(['id' => $id]);
        $validator = Validator::make($request->all(), [
            'value' => 'required|integer',
            'id' => 'required|integer|exists:prices,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }

        $price = Price::find($id);
        $price->update($request->all());
        return new PriceResource($price);
    }

    public function destroy($id)
    {
        $price = Price::find($id);
        $price->delete();
    }

    public function calculation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'arr_date' => 'date_format:"Y-m-d"|required|after:yesterday',
            'dep_date' => 'date_format:"Y-m-d"|required|after:arr_date',
            'room_category_id' => 'required|exists:room_categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $k = 0;
        $startDate = new DateTime($request->arr_date);
        $endDate = new DateTime($request->dep_date);

        $date = clone $startDate;
        while ($date < $endDate) {
            $pr = Price::where([
                ['room_category_id', '=', $request->room_category_id],
                ['start_date', '<=', $date]
            ])->orderBy('start_date', 'desc')->first();

            $booking = Booking::where([
                ['room_category_id', '=', $request->room_category_id],
                ['arr_date', '<=', $date],
                ['dep_date', '>', $date]
            ])->get();

            $available_rooms = Room_category::find($request->room_category_id)->number_of_apartments - $booking->count();

            $days[$k] = [
                'date' => $date->format('d-m-Y'),
                'room_category' => Room_category::find($request->room_category_id)->name,
                'code' => Room_category::find($request->room_category_id)->code,
                'value' => $pr->value,
                'available_rooms' => $available_rooms,
            ];
            $date->modify('+1 day');
            $k++;
        }
        return response()->json([
            'data' => $days
        ]);
    }
}


