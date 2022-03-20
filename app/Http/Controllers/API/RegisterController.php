<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class RegisterController extends APIBaseController
{
    public function register(Request $request)
    {
        try {
            $user = User::where('email', '=', $request->email)->get();
            // return $user;
            if (count($user) < 1) {
                $query = new User();
                $query->firstname = $request->get('firstname');
                $query->lastname = $request->get('lastname');
                $query->email = $request->get('email');
                $query->username = $request->get('username');
                $query->password = Hash::make($request->get('password'));
                $query->number = $request->get('number');
                $query->type = 2;
                $query->save();
                return $this->sendResponse($query, 'Success.');
            }
            return $this->sendError('Email Already Exists', -2);
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
