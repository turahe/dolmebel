<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Contracts\OrderRepositoryInterface;
use Illuminate\Http\Request;

class OrderController
{
    public function __construct(private OrderRepositoryInterface $orderRepository) {}

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function index(Request $request)
    {

        $orders = $this->orderRepository->getUserOrders($request->input('limit', 12));

        return view('orders.index', ['orders' => $orders]);
    }

    public function show(string $code): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
    {

        $order = $this->orderRepository->getCodeOrder($code);

        return view('orders.show', ['order' => $order]);
    }
}
