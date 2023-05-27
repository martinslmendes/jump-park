<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceOrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $vehiclePlate = $request->filled('vehiclePlate') ? $request->input('vehiclePlate') : '';
        $page = $request->filled('page') ? $request->input('page') : 1;
        $limit = ($request->filled('limit') and ($request->input('limit') <= 5)) ? $request->input('limit') : 5;

        $query = ServiceOrder::where('vehiclePlate', 'LIKE', '%' . $vehiclePlate . '%')
            ->leftJoin('users', 'users.id', '=', 'service_orders.userId')
            ->take($limit);

        if ($page > 0) {
            $query->skip(($page - 1) * $limit);
        }

        return response()->json($query->get([
            'service_orders.*',
            'users.name'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

}
