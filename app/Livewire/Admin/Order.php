<?php

namespace App\Livewire\Admin;
use App\Models\Order as orders;
use App\Models\Deliverysched as ds;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;

class Order extends Component
{
    use  WithPagination;
    use Actions;
    use WithFileUploads;
    public $search;
    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.admin.order',[
            'product' => orders::where('name', 'like', $search)->paginate(10),
        ]);

    }
    public function confirmOrder($orderId)
    {
        $order = orders::find($orderId);
         if($order){

            if (auth()->check()) {
                ds::create([
                    'user_id'      => $order->user_id,
                    'name'         => $order->name,
                    'address'      => $order->address,
                    'phonenumber'  => $order->phonenumber,
                    'productlist'  => $order->productlist,
                    'totalorder'   => $order->totalorder,
                ]);

                $order->delete();


            } else {

            }
        }
    }

    public function autoSearch()
    {
        $this->resetPage();
    }

    }



