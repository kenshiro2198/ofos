<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class LoginController extends APIBaseController
{
    public function login(Request $request)
    {
        try {
            $user = User::where('email', $request->get('email'))->first();
            if ($user) {
                $auth = Hash::check($request->get('password'), $user->password);

                if ($auth) {
                    $user->rollApiKey();
                    $csrf_token = $user->rollCsrfKey();
                    $user = User::where('email', $request->get('email'))->where('type', 2);
                    $currentPath = Route::getFacadeRoot()->current()->uri();
                    if ($currentPath == 'api/login') {
                        $user = $user->selectRaw('id,firstname,lastname,number,email,api_token,csrf_token')->first()->toArray();
                    }

                    return $this->sendResponse($user, 'Success.', $csrf_token);
                }
            }
            return $this->sendError('Invalid login credentials.', -2); // Invalid Email Address or Password
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
