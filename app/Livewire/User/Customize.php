<?php

namespace App\Livewire\User;
use Illuminate\Support\Facades\Auth;
use App\Models\customize as cuz;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;
use Livewire\Component;
class Customize extends Component
{
    use Actions;
    use WithFileUploads;
    public $material, $furnituretype, $photo, $comment;
    public function render()
    {
        return view('livewire.user.customize');
    }

    public function ordernow(){

        $this->validate([
            'material' =>'required',
            'furnituretype' =>'required',
            'photo' => 'required',


        ]);


        $photolike = $this->photo->store('photos', 'public');

        cuz::create([
            'user_id'=>auth::user()->id,
            'name'=>auth::user()->name,
            'address'=>auth::user()->address,
            'phonenumber'=>auth::user()->phonenumber,
            'material' => $this->material,
            'furnituretype' => $this->furnituretype,
            'photo'=>$photolike,
            'comment' => $this->comment
        ]);

        $this->notification()->success(
            $title = 'Customize saved!',
            $description = 'Your customize product was added successfully'
        );
        $this->reset([
            'material', 'furnituretype', 'photo', 'comment'
        ]);

    }
}
