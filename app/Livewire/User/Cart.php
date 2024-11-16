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

    public $open_modal = false;
    public $selectedProducts = [];
    public $selectedProductList = [];
    public $search, $totalPrice;
    public $quantities = [];
    public  $order_id;

    public function mount()
    {
        $user = auth()->user();
        if ($user) {
            $cartItems = carts::where('user_id', $user->id)->get();
            foreach ($cartItems as $cartItem) {
                $this->quantities[$cartItem->product_id] = $cartItem->quantity;
            }
        }
    }

    protected $rules = [
        'agree' => 'accepted',
    ];

    public function render()
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userCarts = carts::where('user_id', $user->id)
                          ->with('product')
                          ->paginate(12);

        return view('livewire.user.cart', [
            'carts' => $userCarts,
            'totalcart' => $userCarts->count(),
        ]);
    }

    public function calculateTotalPrice()
    {
        $totalPrice = 0;
        $this->selectedProductList = [];

        // Fetch cart items for the authenticated user with their related product details
        $cartItems = carts::where('user_id', auth()->id())
                          ->with('product')
                          ->get();

        // Loop through the cart items and check if they are selected
        foreach ($cartItems as $cartItem) {
            // Check if the product is selected
            if (isset($this->selectedProducts[$cartItem->id]) && $this->selectedProducts[$cartItem->id]) {
                // Add product price multiplied by quantity to the total price
                $totalPrice += $cartItem->product->productprice * $this->quantities[$cartItem->id];


                $this->selectedProductList[] = [
                    'productname' => $cartItem->product->productname,
                    'productprice' => $cartItem->product->productprice,
                    'quantity' => $this->quantities[$cartItem->id],
                    'photo' => $cartItem->product->photo,
                ];
            }
        }


        $this->totalPrice = $totalPrice;


        if (!empty($this->selectedProductList)) {
            $this->open_modal = true;
        } else {
            $this->dialog()->show([
                'title' => 'No Products Selected',
                'description' => 'Please select products before viewing the summary.',
                'icon' => 'warning',
            ]);
        }
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


            $this->dialog()->show([
                'title'       => 'Item Deleted',
                'description' => 'The product has been successfully removed from your cart.',
                'icon'        => 'success'
            ]);


            $this->resetPage();
            $this->mount();
        } else {

            $this->dialog()->show([
                'title'       => 'Error',
                'description' => 'Item not found. Please try again.',
                'icon'        => 'error'
            ]);
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

    public function ordernow()
    {
        $user = auth()->user();

        if (!$user) {
            $this->dialog()->show([
                'title' => 'Error',
                'description' => 'User not authenticated',
                'icon' => 'error'
            ]);
            return;
        }

        // Check if `order_id` is already set, if not generate a new one.
        if (!$this->order_id) {
            $this->order_id = uniqid('order_');  // Generate a unique order_id
        }

        // Get the selected products
        $selectedProductList = $this->getSelectedProducts();

        // Loop through the selected products and create orders
        foreach ($selectedProductList as $cartItem) {
            if ($cartItem && isset($this->quantities[$cartItem->id])) {
                // Create an order for each selected product
                order::create([
                    'user_id' => $user->id,
                    'product_id' => $cartItem->product->id,
                    'totalorder' => $cartItem->product->productprice * $this->quantities[$cartItem->id],
                    'quantity' => $this->quantities[$cartItem->id],
                    'order_id' => $this->order_id, // Use the same order_id for all items
                ]);
            } else {
                $this->dialog()->show([
                    'title' => 'Error',
                    'description' => 'Product not found in cart',
                    'icon' => 'error'
                ]);
            }
        }

        // After order creation, delete selected products from the cart
        $this->deleteSelectedProducts();
        $this->resetSelectedProducts();
        $this->resetTotalPrice();

        // Show success dialog
        $this->dialog()->show([
            'title' => 'Order Successful',
            'description' => 'Your order was successfully processed!',
            'icon' => 'success'
        ]);

        // Close the modal after the order
        $this->open_modal = false;
    }



    protected function getSelectedProducts()
    {
        $selectedProductList = [];

        foreach ($this->selectedProducts as $cartId => $isSelected) {
            if ($isSelected) {
                $cartItem = carts::where('id', $cartId)
                                 ->where('user_id', auth()->id())
                                 ->with('product')
                                 ->first();

                if ($cartItem && $cartItem->product) {
                    $selectedProductList[] = $cartItem;
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
    foreach ($this->selectedProducts as $cartId => $isSelected) {
        if ($isSelected) {
            carts::where('id', $cartId)->where('user_id', auth()->id())->delete();
        }
    }
}


}
