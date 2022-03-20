<?php

namespace App\Http\Controllers\API;

use App\Models\UserAddress;
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
}
