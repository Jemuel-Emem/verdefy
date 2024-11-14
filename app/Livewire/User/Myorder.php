<?php

namespace App\Livewire\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Deliverysched as ds;
use WireUi\Traits\Actions;
use Livewire\Component;

class Myorder extends Component
{
    public $userOrders, $search;
 use Actions;
    public function mount()
    {
        $this->loadUserOrders();
    }
    public function render()
    {
        $search = '%' . $this->search . '%';
        return view('livewire.user.myorder', [
            'product' => ds::where('user_id', Auth::id())
                             ->where('name', 'like', $search)
                             ->paginate(10),
        ]);
    }

    private function loadUserOrders()
    {
        $user = Auth::user();
        $this->userOrders = ds::where('user_id', $user->id)->get();


    }

    public function delete($orderId)
    {
        // Your delete logic here
        // Example:
        ds::find($orderId)->delete();

        // Reload user orders after deletion
        $this->loadUserOrders();

        // Optional: show a success message or perform other actions
        $this->notification()->success('Order deleted successfully.');
    }
}
