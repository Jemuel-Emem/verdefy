<?php

namespace App\Livewire\User;

use App\Models\Comments;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Myorder extends Component
{
    public $userOrders, $search, $open_comment_modal = false, $orderId, $comment, $rate = 1;

    use Actions;

    public function mount()
    {
        $this->loadUserOrders();
    }

    public function render()
    {
        $search = '%' . $this->search . '%';

        // Fetch orders for the current user with eager loading
        $orders = Order::with(['product', 'user'])
            ->where('user_id', Auth::id())
            ->whereHas('product', function ($query) use ($search) {
                $query->where('productname', 'like', $search);
            })
            ->get();

        // Group orders by `order_id`
        $groupedOrders = $orders->groupBy('order_id')->map(function ($group) {
            // Calculate total amount for orders with the same `order_id`
            $totalAmount = $group->sum('totalorder');
            // Return consolidated data
            return [
                'order_id' => $group[0]->order_id,
                'user' => $group[0]->user,
                'deliverydate' => $group[0]->deliverydate,
                'status' => $group[0]->status,
                'totalAmount' => $totalAmount,
                'products' => $group,
            ];
        });

        return view('livewire.user.myorder', [
            'orders' => $groupedOrders,
        ]);
    }


    private function loadUserOrders()
    {
        $this->userOrders = Order::where('user_id', Auth::id())->get();
    }

    public function openCommentModal($orderId)
    {
        $this->orderId = $orderId;
        $this->open_comment_modal = true;
        $this->comment = '';
        $this->rate = 1;
    }


public function closeCommentModal()
{
    $this->open_comment_modal = false;
    $this->comment = '';
    $this->rate = 1;
}

public function submitComment()
{

    Comments::create([
        'order_id' => $this->orderId,
        'user_id' => Auth::id(),
        'comment' => $this->comment,
        'rate' => $this->rate,
    ]);

    $this->notification()->success('Comment and rating submitted successfully.');
    $this->closeCommentModal();
}

    public function delete($orderId)
    {
        $order = Order::find($orderId);
        if ($order && $order->user_id === Auth::id()) {
            $order->delete();
            $this->loadUserOrders();
            $this->notification()->success('Order deleted successfully.');
        }
    }
}
