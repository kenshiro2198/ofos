<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderAddress;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        return [
            ["title" => "TOTAL ORDER", "value" => $this->totalOrder()],
            ["title" => "NEW ORDER", "value" => $this->totalNewOrder()],
            ["title" => "CONFIRMED ORDER", "value" => $this->totalConfirmedOrder()],
            ["title" => "FOOD BEING PREPARED", "value" => $this->totalPreparingOrder()],
            ["title" => "FOOD PICKUP", "value" => $this->totalPickupOrder()],
            ["title" => "TOTAL FOOD DELIVER", "value" => $this->totalDeliveredOrder()],
            ["title" => "CANCELLED ORDER", "value" => $this->totalCancelledOrder()],
            ["title" => "TOTAL REGISTERED USER", "value" => $this->totalUser()],
        ];
    }

    public function store(Request $request)
    {
        //
    }

    public function show(OrderAddress $position)
    {
        //
    }

    public function update(Request $request, OrderAddress $position)
    {
        //
    }

    public function destroy(OrderAddress $position)
    {
        //
    }
    public function totalOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->first();
        return $query->total;
    }
    public function totalNewOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->where('status', 1)->first();
        return $query->total;
    }
    public function totalConfirmedOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->where('status', 2)->first();
        return $query->total;
    }
    public function totalPreparingOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->where('status', 3)->first();
        return $query->total;
    }
    public function totalPickupOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->where('status', 4)->first();
        return $query->total;
    }
    public function totalDeliveredOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->where('status', 5)->first();
        return $query->total;
    }
    public function totalCancelledOrder()
    {
        $query = OrderAddress::selectRaw("count(*) as total")->where('status', 6)->first();
        return $query->total;
    }
    public function totalUser()
    {
        $query = User::selectRaw("count(*) as total")->where('type', 2)->first();
        return $query->total;
    }
}
