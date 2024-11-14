<?php

namespace App\Livewire\Admin;
use App\Models\Deliverysched as ds;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Component;
use Carbon\Carbon;


class Dileverysched extends Component
{
    use  WithPagination;
    use Actions;
    use WithFileUploads;
    public $search, $status,$date, $guest_id ;
    public $edit_modal = false;
    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.admin.dileverysched',[
            'product' => ds::where('name', 'like', $search)->paginate(10),
        ]);

    }

    public function asss(){
        $this->resetPage();
    }

    public function editSchedule($id){
        $data = ds::where('id', $id)->first();

           if ($data) {

               $this->status= $data->status;
               $this->date= $data->dileverydate;
               $this->edit_modal=true;
               $this->guest_id = $data->id;
            }
    }

    public function update()
     {

         $data =ds::where('id', $this->guest_id)->first();

         $data->update([
            'status' => $this->status,
            'deliverydate' => Carbon::parse(trim($this->date))->toDateString(),
         ]);

         $this->notification()->success(
             $title = 'Status Update',
             $description = 'The status has been updated successfully'
         );
         $this->edit_modal = false;

     }
}
