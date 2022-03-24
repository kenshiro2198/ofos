<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Item::with('category');
        $columns = [
            'name',
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
        $query = new Item();
        $query->name = $request->name;
        $query->category_id = $request->category;
        if (!empty($request->image) && $this->isBase64($request->image)) {
            $query->image = $this->uploadImage($request->image, 'images', $request->name);
        } else {
            return "error";
        }
        $query->description = $request->description;
        $query->qty = $request->qty;
        $query->price = $request->price;
        $query->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return $item->load('category');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $item->name = $request->name;
        $item->category_id = $request->category;
        if (!empty($request->image) && $this->isBase64($request->image)) {
            $item->image = $this->uploadImage($request->image, 'images', $item->id, $request->name);
        }
        $item->description = $request->description;
        $item->qty = $request->qty;
        $item->price = $request->price;
        $item->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->json(true);
    }
}
