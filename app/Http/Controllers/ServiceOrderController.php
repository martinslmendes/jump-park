<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class ServiceOrderController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
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

    public function store(Request $request)
    {
        $dateFormat = 'Y-m-d H:i:s';
        $rules = [
            'vehiclePlate' => 'required|string',
            'entryDateTime' => 'required|date_format:' . $dateFormat,
            'exitDateTime' => 'required|date_format:' . $dateFormat,
            'priceType' => 'required|string',
            'price' => 'required|numeric'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_BAD_REQUEST);
        }

        $serviceOrder = new ServiceOrder();
        $user = User::findById($request->userId);
        $serviceOrder->user()->associate($user);
        $serviceOrder->vehiclePlate = $request->vehiclePlate;
        $serviceOrder->entryDateTime = \DateTime::createFromFormat($dateFormat, $request->entryDateTime);
        $serviceOrder->exitDateTime = \DateTime::createFromFormat($dateFormat, $request->exitDateTime);
        $serviceOrder->priceType = $request->priceType;
        $serviceOrder->price = $request->price;

        if($serviceOrder->save()){
            return response()->json(['message'=>'Data saved successfully']);
        }
    }


}
