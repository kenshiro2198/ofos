<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderTracker;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = OrderAddress::query();
        if ($request->status) {
            $query = $query->where("status", $request->status);
        }
        $columns = [
            'number',
        ];
        $this->applySearch($query, $request, $columns);
        return $this->applyPagination($query, $request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $query = new Order();
        $query->name = $request->name;
        $query->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $oa = OrderAddress::where("order_number", $id)->first();
        $user = User::find($oa->id);
        $order = Order::where("number", $id)->with('item')->get();
        $ot = OrderTracker::where("order_id", $id)->get();
        return [
            "user_details" => [
                "orNumber" => $id,
                "firstname" => $user->firstname,
                "lastname" => $user->lastname,
                "email" => $user->email,
                "number" => $user->number,
                "no" => $oa->no,
                "street" => $oa->street,
                "area" => $oa->area,
                "landmark" => $oa->landmark,
                "city" => $oa->city,
                "orderDate" => $oa->order_time,
                "status" => $oa->status,
            ],
            "order_details" => $order,
            "trackingHistory" => $ot,
        ];

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $order->name = $request->name;
        $order->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return response()->json(true);
    }
    public function items(Request $request)
    {
        $query = Order::with('items');
        return $query->get();
    }

}
