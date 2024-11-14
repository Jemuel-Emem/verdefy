<?php

namespace App\Livewire\Admin;
use App\Models\User as u;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
class Customers extends Component
{
    use  WithPagination;
    use Actions;
    use WithFileUploads;
    public $search;
    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.admin.customers',[
            'product' => u::where('name', 'like', $search)->paginate(10),
        ]);

    }

    public  function asss(){
        $this->resetPage();
    }
}
