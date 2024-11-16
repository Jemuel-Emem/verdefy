<?php

namespace App\Livewire\Admin;

use App\Models\Order as Orders;
use App\Models\Products;
use App\Models\Deliverysched as DS;
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

    public function render()
{

    $search = '%' . $this->search . '%';


    $orders = Orders::with('user', 'product')
                    ->where('order_id', 'like', $search)
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










    public function confirmOrder($orderId)
    {
        // Process order confirmation
        $order = Orders::find($orderId);

        if ($order) {
            // Create a new delivery schedule entry
            DS::create([
                'user_id'      => $order->user_id,
                'name'         => $order->name,
                'address'      => $order->address,
                'phonenumber'  => $order->phonenumber,
                'productlist'  => $order->productlist,
                'totalorder'   => $order->totalorder,
            ]);

            // Update the stock and total sold for the product
            $product = Products::find($order->product_id);
            if ($product) {
                $product->update([
                    'total_sold' => $product->total_sold + $order->quantity,
                    'stock'      => $product->stock - $order->quantity,
                ]);
            } else {
                dd("Product not found for Order ID: $orderId, Product ID: {$order->product_id}");
            }

            $this->dialog()->show([
                'title' => 'Order Confirmed',
                'description' => 'The order has been successfully confirmed and processed.',
                'icon' => 'success',
            ]);
        } else {
            $this->dialog()->show([
                'title' => 'Error',
                'description' => 'Order not found.',
                'icon' => 'error',
            ]);
        }
    }

    public function autoSearch()
    {
        $this->resetPage();
    }
}

