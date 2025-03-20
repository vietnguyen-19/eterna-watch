<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $data = Order::with('user', 'orderItems')->latest('id')->get();
       
    //     return view('admin.order.index', [
    //         'data' => $data,
    //     ]);
    // }

    public function index(Request $request)
{
    $status = $request->query('status');

    $query = Order::with('user', 'orderItems')->latest('id');

    if ($status) {
        $query->where('status', $status);
    }

    $data = $query->get();

    return view('admin.order.index', [
        'data' => $data,
        'filterStatus' => $status
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
