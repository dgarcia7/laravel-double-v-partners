<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StatusOrderRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Providers\WsNodeServiceProvider as WebSocket;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'List of orders',
            'data' => OrderResource::collection(Order::where('status', '!=', 'deleted')->get())
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'account_id' => $request->account_id,
            'product' => $request->product,
            'quantity' => $request->quantity,
            'value' => $request->value,
            'total' => ($request->quantity * $request->value)
        ]);

        $resource = new OrderResource($order);
        $message = "Order created successfully";

        $client = new WebSocket();
        $client->ws(['data' => $resource, 'message' => $message]);

        return response()->json([
            'message' => $message,
            'data' => $resource
        ]);
    }

    public function show(Order $order)
    {
        return response()->json([
            'message' => 'Order detail',
            'data' => new OrderResource($order)
        ]);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->all());
        return response()->json([
            'message' => 'Order updated successfully',
            'data' => new OrderResource($order)
        ]);
    }

    public function destroy(Order $order)
    {
        $order->update(['status' => 'deleted']);
        return response()->json(['message' => 'Order deleted successfully']);
    }

    public function status(StatusOrderRequest $request, Order $order)
    {
        $order->update(['status' => $request->status]);

        $resource = new OrderResource($order);
        $message = 'Order #' . $order->id . ': Status updated to ' . $order->status;

        $client = new WebSocket();
        $client->ws(['data' => $resource, 'message' => $message]);

        return response()->json([
            'message' => $message,
            'data' => $resource
        ]);
    }
}
