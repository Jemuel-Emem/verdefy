<?php

namespace App\Livewire\Admin;

use App\Models\Order as Orders;
use App\Models\Products;
use App\Models\soldproduct;
use App\Models\User;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Livewire\Component;

class Order extends Component
{
    use WithPagination, Actions, WithFileUploads;

    public $search;
    public $userOrders = [];
    public $selectedUserId = null;
    public $openModal = false;

//     public function render()
// {

//     $search = '%' . $this->search . '%';


//     $orders = Orders::with('user', 'product')
//                     ->where('order_id', 'like', $search)
//                     ->get();

//     $groupedOrders = $orders->groupBy('order_id');


//     $aggregatedOrders = $groupedOrders->map(function ($group) {
//         return [
//             'order_id'   => $group->first()->order_id,
//             'user'       => $group->first()->user,
//             'quantity'   => $group->sum('quantity'),
//             'totalorder' => $group->sum('totalorder'),
//             'orders'     => $group,
//         ];
//     });


//     $perPage = 10;
//     $page = Paginator::resolveCurrentPage();
//     $currentPageResults = $aggregatedOrders->slice(($page - 1) * $perPage, $perPage)->all();


//     $paginatedOrders = new LengthAwarePaginator(
//         $currentPageResults,
//         $aggregatedOrders->count(),
//         $perPage,
//         $page,
//         ['path' => Paginator::resolveCurrentPath()]
//     );


//     return view('livewire.admin.order', [
//         'orders' => $paginatedOrders,
//     ]);
// }


public function render()
{
    $search = '%' . $this->search . '%';


    $orders = Orders::with('user', 'product')
                    ->where('order_id', 'like', $search)
                    ->whereDoesntHave('deliverySchedule')
                    ->get();


    $groupedOrders = $orders->groupBy('order_id');

    $aggregatedOrders = $groupedOrders->map(function ($group) {
        return [
            'order_id'   => $group->first()->order_id,
            'user'       => $group->first()->user,
            'quantity'   => $group->sum('quantity'),
            'totalorder' => $group->sum('totalorder'),
            'orders'     => $group,
        ];
    });


    $perPage = 10;
    $page = Paginator::resolveCurrentPage();
    $currentPageResults = $aggregatedOrders->slice(($page - 1) * $perPage, $perPage)->all();

    $paginatedOrders = new LengthAwarePaginator(
        $currentPageResults,
        $aggregatedOrders->count(),
        $perPage,
        $page,
        ['path' => Paginator::resolveCurrentPath()]
    );

    return view('livewire.admin.order', [
        'orders' => $paginatedOrders,
    ]);
}



    public function viewUserOrders($userId, $orderId)
    {
        $this->selectedUserId = $userId;


        $this->userOrders = Orders::where('user_id', $userId)
                                   ->where('order_id', $orderId)
                                   ->with('product')
                                   ->get();


        $this->openModal = true;
    }

    // public function confirmOrder($orderId)
    // {

    //     $order = Orders::with('user', 'product')->find($orderId);

    //     if ($order) {

    //         $existingSchedule = DS::where('order_id', $order->order_id)->first();

    //         if (!$existingSchedule) {

    //             DS::create([
    //                 'user_id'      => $order->user_id,
    //                 'order_id'     => $order->order_id,
    //                 'product_id'   => $order->product_id,
    //                 'deliverydate' => now()->addDays(3),
    //                 'status'       => 'To Deliver',
    //             ]);
    //         }


    //         $product = Products::find($order->product_id);
    //         if ($product) {
    //             $product->update([
    //                 'total_sold' => $product->total_sold + $order->quantity,
    //                 'stock'      => $product->stock - $order->quantity,
    //             ]);
    //         } else {
    //             dd("Product not found for Order ID: $orderId, Product ID: {$order->product_id}");
    //         }


    //         $this->dialog()->show([
    //             'title' => 'Order Confirmed',
    //             'description' => 'The order has been successfully confirmed and a delivery schedule created.',
    //             'icon' => 'success',
    //         ]);
    //     } else {

    //         $this->dialog()->show([
    //             'title' => 'Error',
    //             'description' => 'Order not found.',
    //             'icon' => 'error',
    //         ]);
    //     }
    // }
    // public function confirmOrder($orderId)
    // {
    //     // Fetch the order with its user and associated products
    //     $order = Orders::with('user', 'product')->where('order_id', $orderId)->get();

    //     if ($order->isNotEmpty()) {
    //         // Check if a delivery schedule already exists for this order
    //         $existingSchedule = DS::where('order_id', $orderId)->first();

    //         if (!$existingSchedule) {
    //             // Loop through all the products for this order
    //             foreach ($order as $item) {
    //                 // Create a new delivery schedule entry for each product in the order
    //                 DS::create([
    //                     'user_id'      => $item->user_id,
    //                     'order_id'     => $item->order_id,
    //                     'product_id'   => $item->product_id,  // Save the product_id for each product in the order
    //                     'deliverydate' => now()->addDays(3),   // Set the delivery date
    //                     'status'       => 'To Deliver',        // Set the initial status
    //                 ]);

    //                 // Update the stock and total sold for each product
    //                 $product = Products::find($item->product_id);
    //                 if ($product) {
    //                     $product->update([
    //                         'total_sold' => $product->total_sold + $item->quantity,
    //                         'stock'      => $product->stock - $item->quantity,
    //                     ]);
    //                 }
    //             }

    //             $this->dialog()->show([
    //                 'title' => 'Order Confirmed',
    //                 'description' => 'The order has been successfully confirmed and a delivery schedule created.',
    //                 'icon' => 'success',
    //             ]);
    //         } else {
    //             $this->dialog()->show([
    //                 'title' => 'Error',
    //                 'description' => 'This order has already been confirmed.',
    //                 'icon' => 'error',
    //             ]);
    //         }
    //     } else {
    //         $this->dialog()->show([
    //             'title' => 'Error',
    //             'description' => 'Order not found.',
    //             'icon' => 'error',
    //         ]);
    //     }
    // }

    // public function confirmOrder($orderId)
    // {

    //     $orders = Orders::where('order_id', $orderId)->get();


    //     if ($orders->isEmpty()) {
    //         $this->dialog()->show([
    //             'title' => 'Error',
    //             'description' => 'Order not found.',
    //             'icon' => 'error',
    //         ]);
    //         return;
    //     }

    //     foreach ($orders as $order) {

    //         if ($order->status !== 'Pending') {
    //             $this->dialog()->show([
    //                 'title' => 'Error',
    //                 'description' => 'This order has already been confirmed or processed.',
    //                 'icon' => 'error',
    //             ]);
    //             return;
    //         }


    //         $order->status = 'To Deliver';
    //         $order->deliverydate = now()->addDays(3);
    //         $order->save();


    //         $product = $order->product;
    //         if ($product) {
    //             $product->update([
    //                 'total_sold' => $product->total_sold + $order->quantity,
    //                 'stock' => $product->stock - $order->quantity,
    //             ]);
    //         }
    //     }


    //     $this->dialog()->show([
    //         'title' => 'Order Confirmed',
    //         'description' => 'The order has been successfully confirmed and a delivery schedule set.',
    //         'icon' => 'success',
    //     ]);
    // }


    public function confirmOrder($orderId)
    {
        // Fetch orders with the given order_id
        $orders = Orders::where('order_id', $orderId)->get();

        // Check if any orders were found
        if ($orders->isEmpty()) {
            $this->dialog()->show([
                'title' => 'Error',
                'description' => 'Order not found.',
                'icon' => 'error',
            ]);
            return;
        }

        foreach ($orders as $order) {

            if ($order->status !== 'Pending') {
                $this->dialog()->show([
                    'title' => 'Error',
                    'description' => 'This order has already been confirmed or processed.',
                    'icon' => 'error',
                ]);
                return;
            }


            $order->status = 'To Deliver';
            $order->deliverydate = now()->addDays(3);
            $order->save();


            $product = $order->product;
            if ($product) {

                $product->update([
                    'total_sold' => $product->total_sold + $order->quantity,
                    'stock'      => $product->stock - $order->quantity,
                ]);


                \App\Models\SoldProduct::create([
                    'user_id'    => $order->user_id,
                    'product_id' => $order->product_id,
                    'quantity'   => $order->quantity,
                    'total_sold' => $order->quantity,
                    'order_id'   => $order->order_id,
                ]);
            }
        }


        $this->dialog()->show([
            'title' => 'Order Confirmed',
            'description' => 'The order has been successfully confirmed and a delivery schedule set.',
            'icon' => 'success',
        ]);
    }

    public function markAsDelivered($orderId)
    {


        $order = Orders::where('order_id', $orderId)->first();

        if ($order) {

            $order->status = 'Delivered';
            $order->save();


            session()->flash('message', 'Order marked as Delivered.');
        } else {

            session()->flash('error', 'Order not found.');
        }
    }


    public function autoSearch()
    {
        $this->resetPage();
    }
}

