<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingListResource;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Booking_status;
use App\Models\Guest;
use App\Models\Room_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        return BookingListResource::collection(Booking::all());
    }

    public function store(BookingRequest $request)
    {
        $ng = count($request->guests); //количество гостей на заселение в заявке
        $max= Room_category::find($request->room_category_id)->guests; //Максимальное количество гостей в номере
        if ($ng > $max) {
            return response()->json([
                'errors' => 'Guests in the booking more than there are beds in the room'
            ],422);
        }

        $code = Str::random(7);
        Booking::create([
                'code' => $code,
                'booking_status_id' => 1,
            ] + $request->all());

        $booking = Booking::where('code', $code)->first();
        foreach ($request->guests as $value) {
            $validator = Validator::make($value, [
                'name' => 'required',
                'birthday' => 'required',
                'gender' => 'required',
                'document_type_id' => 'required',
                'document_number' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ],422);
            }

            Guest::create([
                    'booking_id' => $booking->id,
                ] + $value);
        }
        $guests = Guest::where('booking_id', $booking->id)->get();
        $booking->guests = $guests;

        return new BookingResource($booking);
    }

    public function show(Request $request){
        $booking = Booking::where('code', $request->code)->first();
        if ($booking) {
            $guests = Guest::where('booking_id', $booking->id)->get();
            $booking->guests = $guests;
            return new BookingResource($booking);
        }
        return [
            'error' => [
                'code' => 403,
                'message' => 'The code does not exist '
            ]
        ];
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:bookings,id',
            'booking_status_id' => 'required|exists:booking_statuses,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ],422);
        }

        $booking = Booking::find($id);
        $booking->update($request->all());
        $booking->save();
        return new BookingListResource($booking);

    }


}
