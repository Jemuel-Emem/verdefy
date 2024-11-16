<?php

namespace App\Livewire\User;

use App\Models\Cart as Carts;
use App\Models\Products as Pro;
use App\Models\Comments;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination, Actions;

    public $selectedProduct;
    public $comments = [];
    public $showCommentsModal = false;
    public $open_comment_modal = false;
    public $search;
    public $showModal = false;


    public $rate;
    public $comment;

    public function render()
    {
        $search = '%' . $this->search . '%';
        $products = Pro::where('productname', 'like', $search)->paginate(12);

        return view('livewire.user.products', [
            'product' => $products,
        ]);
    }


    public function showComments($productId)
    {
        $product = Pro::find($productId);

        if ($product) {
            $this->selectedProduct = $product;


            $this->comments = Comments::where('order_id', $productId)
                ->with('user')
                ->latest()
                ->get();

            $this->showCommentsModal = true;
        }
    }


    public function asss()
    {
        $this->resetPage();
    }


    public function add($id)
    {
        $product = Pro::find($id);

        if ($product && auth()->check()) {
            $user = auth()->user();

            Carts::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);

            $this->resetPage();

            $this->dialog([
                'title' => 'Added to cart',
                'description' => 'The product was added to the cart',
                'icon' => 'success',
            ]);
        }
    }


    public function submitComment()
    {
        if (auth()->check() && $this->selectedProduct) {
            $user = auth()->user();

          
            $this->validate([
                'rate' => 'required|integer|min:1|max:5',
                'comment' => 'required|string|max:255',
            ]);

            Comments::create([
                'user_id' => $user->id,
                'product_id' => $this->selectedProduct->id,
                'rate' => $this->rate,
                'comment' => $this->comment,
                'order_id' => $this->selectedProduct->id, // Assuming order_id is same as product_id
            ]);

            // Reset fields and close the modal
            $this->reset(['rate', 'comment']);
            $this->showCommentsModal = true;
            $this->loadComments($this->selectedProduct->id);

            $this->dialog([
                'title' => 'Thank you!',
                'description' => 'Your review has been submitted.',
                'icon' => 'success',
            ]);
        } else {
            $this->dialog([
                'title' => 'Login Required',
                'description' => 'Please log in to leave a comment.',
                'icon' => 'warning',
            ]);
        }
    }

    // Method to refresh comments after submission
    private function loadComments($productId)
    {
        $this->comments = Comments::where('order_id', $productId)
            ->with('user')
            ->latest()
            ->get();
    }
}
