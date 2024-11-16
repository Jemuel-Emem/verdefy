<?php

namespace App\Livewire\User;

use App\Models\Products as pro;
use App\Models\comments as Rate;
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

        $search = '%' .$this->search. '%';

        $product = pro::withAvg('comments', 'rate')
                      ->where('productname', 'like', $search)
                      ->paginate(3);


        foreach ($product as $cot) {

            $cot->recommendation = $this->getRecommendationBasedOnRate($cot->comments_avg_rate);
        }

        return view('livewire.user.index-content', [
            'product' => $product,
        ]);
    }


    public function getRecommendationBasedOnRate($rate)
    {

        if ($rate >= 4.5) {
            return 'Highly Recommended';
        } elseif ($rate >= 3.5) {
            return 'Recommended';
        } else {
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
                    'user_id'      => $user->id,
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

            }
        }
    }
}
