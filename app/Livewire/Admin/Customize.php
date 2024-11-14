<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\customize as cuz;
use WireUi\Traits\Actions;
class Customize extends Component
{
    use Actions;
   public  $search;
    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.admin.customize',[
            'product' => cuz::where('material', 'like', $search)->paginate(10),
        ]);

    }

    public function delete($id){
        $data = cuz::find($id);

        $data->delete();
        $this->notification()->success(
            $title = 'Cuztomize Deleted!',
            $description = 'The cuztomize was deleted successfully'
        );
    }
}
