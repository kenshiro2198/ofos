<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SpaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function __invoke()
    {
        if (!request()->expectsJson()) {
            return view('main');
        } else {
            return abort(404);
        }
    }

}
