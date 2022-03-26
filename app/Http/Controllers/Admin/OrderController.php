<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderTracker;
use App\Models\User;
use DB;
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
        $status = [$request->status];
        if (is_array($request->status)) {
            $status = $request->status;
        }
        if ($request->status) {
            $query = $query->whereIn("status", $status);
        }
        if ($request->from && $request->to) {
            $query = $query->whereDate("order_time", ">=", $request->from)
                ->whereDate("order_time", "<=", $request->to);
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
        $user = User::find($oa->user_id);
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
        $order->deleted_at = date('Y-m-d H:i:s');
        $order->save();
        $order->delete();

        return response()->json(true);
    }
    public function items(Request $request)
    {
        $query = Order::with('items');
        return $query->get();
    }

    public function orderCount(Request $request)
    {
        $query = OrderAddress::selectRaw("
            month(order_time) as lMonth,
            year(order_time) as lYear,
            count(id) as totalOrder,
            count(if((status=1),0,null)) as totalUnconfirmedOrder,
            count(if((status=2),0,null)) as totalConfirmedOrder,
            count(if((status=3),0,null)) as totalBeingPreparedOrder,
            count(if((status=4),0,null)) as totalPickupOrder,
            count(if((status=5),0,null)) as totalDeliveredOrder,
            count(if((status=6),0,null)) as totalCancelledOrder
        ")
            ->whereDate("order_time", ">=", $request->from)
            ->whereDate("order_time", "<=", $request->to)
            ->groupBy('lMonth', 'lYear');
        return $query->get();
    }
    public function salesReport(Request $request)
    {
        if ($request->type == 1) {

            $query = DB::select(DB::raw(
                "SELECT
            YEAR(order_addresses.order_time) AS lYear,
            SUM(items.price * orders.quantity) AS totalItemPrice
            FROM orders
            JOIN order_addresses ON order_addresses.order_number = orders.number
            JOIN items ON items.id = orders.item_id
            WHERE YEAR(order_addresses.order_time) BETWEEN '$request->from' AND '$request->to'
            AND order_addresses.status = 5
            GROUP BY lYear
            "
            ));
            return $query;

        } else {
            $query = DB::select(DB::raw(
                "SELECT MONTH(order_addresses.order_time) AS lMonth,
            YEAR(order_addresses.order_time) AS lYear,
            SUM(items.price * orders.quantity) AS totalItemPrice
            FROM orders
            JOIN order_addresses ON order_addresses.order_number = orders.number
            JOIN items ON items.id = orders.item_id
            WHERE DATE(order_addresses.order_time) BETWEEN '$request->from' AND '$request->to'
            AND order_addresses.status = 5
            GROUP BY lMonth, lYear
            "
            ));
            return $query;
        }
    }

    public function updateStatus(Request $request)
    {
        $query = new OrderTracker();
        $query->order_id = $request->order_id;
        $query->remark = $request->remark;
        $query->status = $request->status;
        $query->save();
    }

}
