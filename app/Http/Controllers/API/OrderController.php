<?php

namespace App\Http\Controllers\API;

use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderTracker;
use App\Models\User;
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
            $cart = json_decode($request->get('cart'), true);
            foreach ($cart as $key => $value) {
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
            $address->payment_type = $request->get('payment_type');
            $address->save();
            $tracker = new OrderTracker();
            $tracker->order_id = $orderNo;
            $tracker->save();
            $user = User::find($request->get('user_id'));
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://g.payx.ph/payment_request',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array(
                    'x-public-key' => 'pk_45fb3c2682b9e78263bfa3a19ca82360',
                    'amount' => '1',
                    'description' => 'Food Payment',
                    'customername' => $user->fullname,
                    'customermobile' => $user->number,
                    'customeremail' => $user->email,
                    'webhooksuccessurl' => "http://admin.gdistrictofficial.com/api/payment/success/$orderNo",
                    'webhookfailurl' => "http://admin.gdistrictofficial.com/api/payment/fail/$orderNo",
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);
            if ($err) {
                return $err;
            } else {
                return json_decode($response, true);
            }

            DB::commit();
            return $this->sendResponse($response, 'Success.');
        } catch (\Exception$e) {
            Log::error($e);
            return $e;
            return $this->sendError("System error has occurred.");
        } catch (\Error$e) {
            return $e;
            Log::error($e);
            return $this->sendError("System error has occurred.");
        } catch (\Throwable$e) {
            return $e;
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
    public function paymentSuccess($id)
    {
        $address = OrderAddress::where("order_number", $id)->first();
        $address->is_paid = 1;
        $address->save();
    }
    public function paymentFailed($id)
    {
        $address = OrderAddress::where("order_number", $id)->first();
        $address->is_paid = 2;
        $address->save();
    }
}
