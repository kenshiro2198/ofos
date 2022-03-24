<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderTracker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends APIBaseController
{
    public function order(Request $request)
    {
        try {
            DB::beginTransaction();
            $orderNo = mt_rand(100000000, 999999999);
            foreach ($request->get('cart') as $key => $value) {
                $query = new Order();
                $query->number = $orderNo;
                $query->user_id = $request->get('user_id');
                $query->item_id = $value['id'];
                $query->quantity = $value['qty'];
                $query->save();
            }
            $address = new OrderAddress();
            $address->user_id = $request->get('user_id');
            $address->order_number = $orderNo;
            $address->no = $request->get('no');
            $address->street = $request->get('street');
            $address->area = $request->get('area');
            $address->city = $request->get('city');
            $address->longitude = $request->get('longitude');
            $address->latitude = $request->get('latitude');
            $address->save();
            $tracker = new OrderTracker();
            $tracker->order_id = $orderNo;
            $tracker->save();
            DB::commit();
            return $this->sendResponse($orderNo, 'Success.');
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
