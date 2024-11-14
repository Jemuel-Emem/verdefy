<?php

namespace App\Livewire\User;

use App\Models\Cart as carts;
use App\Models\User;
use App\Models\Order as order;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class Cart extends Component
{
    use WithPagination;
    use Actions;
    use WithFileUploads;
    public $agree = false;
    public $open_modal = false;
    public $selectedProducts = [];
    public $selectedProductList = [];
    public $search, $totalPrice;
    public $quantities = [];

    public function mount()
    {
        $this->updatedSelectedProducts();
        $products = carts::all();
        foreach ($products as $product) {
            $this->quantities[$product->id] = 1;
        }
    }
    protected $rules = [
        'agree' => 'accepted',
    ];

    public function render()
    {
        $user = auth()->user();

    // Ensure a user is authenticated
    if (!$user) {
        return redirect()->route('login');
    }

    $totalcart = $this->getTotalCart();
    $userCarts = carts::where('user_id', $user->id)
                      ->where('productname', 'like', '%' . $this->search . '%')
                      ->paginate(12);

    return view('livewire.user.cart', [
        'product' => $userCarts,
        'totalcart' => $totalcart,
        'agree' => $this->agree,
    ]);
    }
    public function toggleAgree()
    {
        $this->validateOnly('agree');
    }
    public function getTotalCart()
    {
        $total = carts::count();

        return $total;
    }

    public function add($productId)
    {
        $this->selectedProducts[$productId] = !$this->selectedProducts[$productId];
    }

    public function back()
    {
        // Handle back action if needed
    }

    public function calculateTotalPrice()
    {
        $this->open_modal = false;
        $totalPrice = 0;

        // Clear the selected product list
        $this->selectedProductList = [];

        $products = carts::all();

        foreach ($this->selectedProducts as $productId => $isSelected) {
            if ($isSelected) {
                $product = $products->find($productId);

                // Ensure the product with the given ID exists
                if ($product) {
                    $totalPrice += $product->productprice * $this->quantities[$productId];
                    $this->open_modal = true;
                    $this->selectedProductList[] = $product;
                }
            }
        }

        $this->totalPrice = $totalPrice; // Update total price property

        return $totalPrice;
    }

    public function updatedSelectedProducts()
    {
        $this->calculateTotalPrice();
    }

    public function delete($id)
    {
        $cartItem = carts::find($id);
        if ($cartItem) {
            $cartItem->delete();

            $this->dialog([
                'title' => 'Deleted from cart',
                'description' => 'The product was removed from the cart',
                'icon' => 'error'
            ]);

            $this->resetPage();
        }
    }

    public function addQuantity($productId)
    {
        $this->quantities[$productId]++;
        $this->calculateTotalPrice();
    }

    public function decreaseQuantity($productId)
    {
        $this->quantities[$productId] = max(1, $this->quantities[$productId] - 1);
        $this->calculateTotalPrice();
    }

    public function ordernow(){
//         $this->validate();
//      $selectedProductList = $this->getSelectedProducts();
//     $totalPrice = $this->calculateTotalPrice($selectedProductList);

//     Order::create([
//         'user_id'=> auth()->user()->id,
//         'name' => auth()->user()->name,
//         'address' => auth()->user()->address,
//         'phonenumber' => auth()->user()->phonenumber,
//         'productlist' => json_encode($selectedProductList, JSON_UNESCAPED_UNICODE),
//         'totalorder' => $totalPrice,
//     ]);

//     $this->deleteSelectedProducts();
//     $this->resetSelectedProducts();
//     $this->resetTotalPrice();
//     $this->dialog()->show([
//         'title'       => 'Order ',
//         'description' => 'Your order was successfully process',
//         'icon'        => 'success'
//     ]);
//    $this->open_modal=false;

$this->validate();
    $selectedProductList = $this->getSelectedProducts();
    $totalPrice = $this->calculateTotalPrice($selectedProductList);

    Order::create([
        'user_id'=> auth()->user()->id,
        'name' => auth()->user()->name,
        'address' => auth()->user()->address,
        'phonenumber' => auth()->user()->phonenumber,
        'productlist' => implode(', ', $selectedProductList),
        'totalorder' => $totalPrice,
    ]);

    $this->deleteSelectedProducts();
    $this->resetSelectedProducts();
    $this->resetTotalPrice();
    $this->dialog()->show([
        'title'       => 'Order ',
        'description' => 'Your order was successfully processed',
        'icon'        => 'success'
    ]);
    $this->open_modal = false;
    }
    protected function getSelectedProducts()
    {
        $selectedProductList = [];

        foreach ($this->selectedProducts as $productId => $isSelected) {
            if ($isSelected) {
                $product = carts::find($productId);
                if ($product) {
                    $selectedProductList[] = $product->productname;
                }
            }
        }

        return $selectedProductList;
    }

protected function resetSelectedProducts()
{
    $this->selectedProducts = [];
}

protected function resetTotalPrice()
{
    $this->totalPrice = 0;
}

protected function deleteSelectedProducts()
{
    foreach ($this->selectedProducts as $productId => $isSelected) {
        if ($isSelected) {
            carts::find($productId)->delete();
        }
    }
}

}
