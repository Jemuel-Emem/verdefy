<?php

namespace App\Livewire\User;

use App\Models\Products as pro;
use App\Models\comments as Rate;
use App\Models\soldproduct;
use App\Models\Cart as carts;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class IndexContent extends Component
{
    use Actions;
    use WithPagination;

    public $search;

    public function render()
    {
        $search = '%' . $this->search . '%';

        // Fetch products with related sold products and comments data
        $products = pro::with('soldproducts', 'comments')  // Load sold products and comments data
                      ->where('productname', 'like', $search)
                      ->paginate(3);

        // Loop through each product
        foreach ($products as $cot) {

            // Calculate the average rate from the comments table
            $averageRate = $this->getAverageRate($cot->id);

            // Calculate the total sold quantity from the soldproduct table
            $totalSold = $this->getTotalSold($cot->id);

            // Add recommendation based on rate and total sold
            $cot->recommendation = $this->getRecommendationBasedOnRate($averageRate, $totalSold);

            // Set the calculated average rate and total sold on the product
            $cot->comments_avg_rate = $averageRate;  // This will make it available in the view
            $cot->total_sold = $totalSold;  // This will make total sold available in the view
        }

        // Filter products that are Highly Recommended
        $highlyRecommendedProducts = $products->getCollection()->filter(function($cot) {
            return $cot->recommendation === 'Highly Recommended';
        });

        // Manually paginate the filtered collection
        $highlyRecommendedProducts = new \Illuminate\Pagination\LengthAwarePaginator(
            $highlyRecommendedProducts,
            $products->total(),
            $products->perPage(),
            $products->currentPage(),
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        return view('livewire.user.index-content', [
            'product' => $highlyRecommendedProducts,
        ]);
    }


    public function getAverageRate($productId)
    {

        $averageRate = Rate::where('order_id', $productId)->avg('rate');
        return $averageRate;
    }

        public function getTotalSold($productId)
    {

        $totalSold = soldproduct::where('product_id', $productId)->sum('total_sold');
        return $totalSold;
    }


    public function getRecommendationBasedOnRate($rate, $totalSold)
    {

        if ($rate >= 4.5 && $totalSold >= 100) {
            return 'Highly Recommended';
        }


        elseif ($rate >= 3.5 && $totalSold >= 50) {
            return 'Recommended';
        }


        else {
            return 'Less Recommended';
        }
    }

    public function add($id)
    {
        $product = pro::find($id);

        if ($product) {
            if (auth()->check()) {
                $user = auth()->user();


                carts::create([
                    'user_id'     => $user->id,
                    'product_id'   => $product->id,
                ]);

                $this->resetPage();

                $this->dialog([
                    'title'       => 'Added to cart',
                    'description' => 'The product was added to cart',
                    'icon'        => 'success',
                ]);
            }
        }
    }
}
