<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\OrderTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends APIBaseController
{
    public function order(Request $request)
    {
        try {
            DB::beginTransaction();
            $orderNo = mt_rand(100000000, 999999999);
            $query = new Order();
            $query->number = $orderNo;
            $query->user_id = $request->get('user_id');
            $query->item_id = $request->get('item_id');
            $query->quantity = $request->get('quantity');

            // $query->user_address_id = $request->get('user_address_id');
            $query->save();

            /* $item = new OrderItem();
            $item->order_id = $query->id;
            $item->user_id = $request->get('user_id');
            $item->food_id = $request->get('food_id');
            $item->qty = $request->get('qty');
            $item->save();
            $tracker = new OrderTracker();
            $tracker->order_id = $query->id;
            $tracker->status = 1;
            $tracker->save(); */
            DB::commit();
            return $this->sendResponse($query, 'Success.');
        } catch (\Exception$e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Error$e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Throwable$e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        }
    }
    public function trackOrder($id)
    {
        try {
            $query = OrderTracker::where("order_id", $id)->first();
            return $this->sendResponse($query, 'Success.');
        } catch (\Exception$e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Error$e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Throwable$e) {
            Log::error($e);
            return $this->sendError("System error has occurred.");
        }
    }
}
