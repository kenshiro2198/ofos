<?php

namespace App\Http\Controllers\API;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AddressController extends APIBaseController
{
    public function index($id)
    {
        try {
            $user = UserAddress::where('user_id', $id)->get();

            return $this->sendResponse($user, 'Success.');
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
    public function store(Request $request)
    {
        try {
            $query = new UserAddress();
            $query->user_id = $request->get('user_id');
            $query->name = $request->get('name');
            $query->address = $request->get('address');
            $query->remarks = $request->get('remarks');
            $query->longitude = $request->get('longitude');
            $query->latitude = $request->get('latitude');
            $query->save();

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
