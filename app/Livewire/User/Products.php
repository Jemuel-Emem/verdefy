<?php

namespace App\Livewire\User;
use App\Models\Products as pro;
use App\Models\Cart as carts;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Products extends Component
{
    use  WithPagination;
    use Actions;
    use WithFileUploads;

    public $search;
    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.user.products',[
            'product' => pro::where('productname', 'like', $search)->paginate(12),
        ]);

    }

    public function asss(){
        $this->resetPage();
    }

    public function back(){

    }

    public function add($id){
        $product = pro::find($id);

    if($product){
        $product = pro::find($id);

    if ($product) {
        // Check if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();

            carts::create([
                'user_id'      => $user->id, // Associate the cart entry with the user
                'productname'  => $product->productname,
                'productprice' => $product->productprice,
                'photo'        => $product->photo,
            ]);

            $this->resetPage();

            $this->dialog([
                'title'       => 'Added to cart',
                'description' => 'The product was added to cart',
                'icon'        => 'success',
            ]);
        } else {
            // Handle the case where the user is not authenticated (optional)
        }
    }
    }


       }
    }

