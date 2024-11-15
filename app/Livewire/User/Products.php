<?php

namespace App\Livewire\User;

use App\Models\Products as pro;
use App\Models\comments;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;

class Products extends Component
{
    use WithPagination;
    use Actions;

    public $selectedProduct;
    public $comments = [];
    public $showCommentsModal = false;
    public $search;
    public $showModal = false;

    public function render()
    {
        $search = '%' . $this->search . '%';


        $products = pro::where('productname', 'like', $search)
                       ->paginate(12);


        $products->load(['comments' => function($query) {

            $query->with('user')->latest();
        }]);

        return view('livewire.user.products', [
            'product' => $products,
        ]);
    }


    public function showComments($productId)
    {

        $product = pro::find($productId);

        if ($product) {
            $this->selectedProduct = $product;
            $this->comments = $product->comments()->with('user')->latest()->get();
            $this->showCommentsModal = true;
    }
}

    public function asss(){
        $this->resetPage();
    }

    public function add($id)
    {
        // Add to cart logic
    }
}

