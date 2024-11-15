<?php

namespace App\Livewire\User;

use App\Models\Comments; // Import Comments model
use App\Models\Deliverysched as ds;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use WireUi\Traits\Actions;

class Myorder extends Component
{
    public $userOrders, $search, $open_comment_modal = false, $orderId, $comment, $rate = 1; // Added $rate property

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

    public function openCommentModal($orderId)
    {
        $this->orderId = $orderId;
        $this->open_comment_modal = true;
        $this->comment = ''; // Reset the comment field
        $this->rate = 1; // Reset the rating to 1
    }

    public function closeCommentModal()
    {
        $this->open_comment_modal = false;
        $this->comment = '';
        $this->rate = 1; // Reset the rating to 1
    }

    public function submitComment()
    {

        Comments::create([
            'order_id' => $this->orderId,
            'user_id' => Auth::id(),
            'comment' => $this->comment,
            'rate' => $this->rate,
        ]);

        // Show success notification
        $this->notification()->success('Comment and rating submitted successfully.');

        // Close the modal
        $this->closeCommentModal();
    }

    public function delete($orderId)
    {
        ds::find($orderId)->delete();
        $this->loadUserOrders();
        $this->notification()->success('Order deleted successfully.');
    }
}
