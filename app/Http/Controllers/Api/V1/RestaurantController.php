<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Restaurant;
use DB;
use App\Helpers\CustomLog;

class RestaurantController extends Controller
{
    /**
     * @get List of restaurants
     * @return response
     */
    public function list()
    {
        // when using type table
        // $restaurantList = Restaurant::with('type')->get();

        $restaurantList = Restaurant::all();

        return response()->json($restaurantList,200);
    }
    
    /**
     * @get restaurant with $id
     * @return response
     */
    public function getRestaurant($id)
    {
        // when using type table
        // $restaurant = Restaurant::where('id', $id)->with('type')->first();

        $restaurant = Restaurant::where('id', $id)->first();

        return response()->json($restaurant, 200);
    }

    /**
     * @param Request $request
     * @return response
     */
    public function createRestaurant(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            // 'type_id' => 'required',
            'opening_hour' => 'required',
            'closing_hour' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $restaurant = Restaurant::create($request->all());
            CustomLog::info("Create New Restaurant ID ".$restaurant->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => [
                    'status' => 500,
                    'message' => $e->getMessage(),
                ]
            ], 500);
        }

        return response()->json([ 'data' => [ 'Restaurant ID' => $restaurant->id ] ], 200);
    }

    /**
     * @param Request $request, $id
     * @return RestaurantResource
     */
    public function updateRestaurant(Request $request, $id)
    {   
        $restaurant = Restaurant::findOrFail($id);

        DB::beginTransaction();
        try {
            $restaurant->update($request->all());
            CustomLog::info("Update Restaurant ID ".$restaurant->id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => [
                    'status' => 500,
                    'message' => $e->getMessage(),
                ]
            ], 500);
        }

        return response()->json([ 'data' => [ 'Restaurant ID' => $id ] ], 200);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function deleteRestaurant($id)
    {
        $restaurant = Restaurant::findOrFail($id);

        DB::beginTransaction();
        try {
            $restaurant->delete();
            CustomLog::info("Delete ".$id);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => [
                    'status' => 500,
                    'message' => $e->getMessage(),
                ]
            ], 500);
        }

        return response()->json();
    }
}
