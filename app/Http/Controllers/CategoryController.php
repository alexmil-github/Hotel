<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoriesResource;
use App\Models\Booking;
use App\Models\Room_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Room_category::all();
        return CategoriesResource::collection($categories);
    }
    public function show(Request $request) {
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
        $category['service_icons'] = $category->service_icons;
        return response()->json(["data" => $category]);
    }
}
