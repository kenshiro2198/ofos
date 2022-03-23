<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function me()
    {
        return User::find(Auth::id());
    }

    public function index(Request $request)
    {
        $query = User::orderBy('id', 'desc')->where('type', $request->type);
        /* Search */
        $this->applySearch($query, $request);
        /* Pagination */
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
        $user = new User();
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->type = $request->type;
        $user->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return User::where('id', $id)->where('type', $request->type)->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        if (isset($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(true);
    }

    public function unique(Request $request)
    {
        $model = "App\Models\\" . $request->model;
        $field = $request->field;
        $value = $request->value;
        $except = $request->except;
        $type = $request->type;

        $builder = $model::where($field, $value)->where('type', $type);
        if (isset($request->id)) {
            $builder->where('id', '!=', $request->id);
        }
        if ($except) {
            $builder->where($field, '!=', $except);
        }

        return response()->json(!$builder->exists());
    }
}
