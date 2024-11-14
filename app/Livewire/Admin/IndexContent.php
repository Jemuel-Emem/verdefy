<?php

namespace App\Livewire\Admin;
use App\Models\User as user;
use App\Models\Products as products;
use App\Models\Deliverysched as deliverysched;
use App\Models\Order as order;
use App\Models\customize as customize;
use Illuminate\Console\Scheduling\Schedule;
use Livewire\Component;

class IndexContent extends Component
{

    public $totalCustomers, $totalproducts, $totalschedule, $totalorders, $totalcustomize;

    public function mount()
    {
        $this->loadTotal();
    }
    public function render()
    {
        return view('livewire.admin.index-content');
    }

    private function loadTotal()
    {

        $this->totalCustomers = user::count();
        $this->totalproducts= products::count();
        $this->totalcustomize =customize::count();
        $this->totalorders = order::count();
        $this->totalschedule = deliverysched::count();
    }
}
