<?php

namespace App\Livewire\Admin;
use App\Models\Products as pro;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
class Products extends Component
{
    use  WithPagination;
    use Actions;
    use WithFileUploads;
    public $edit_modal = false;
    public $open_modal = false;
    public $currentPhoto;
    public $search,$guest_id, $photo, $productname, $productprice, $description, $stocks;
    public function render()
    {
        $search = '%' .$this->search. '%';
        return view('livewire.admin.products',[
            'product' => pro::where('productname', 'like', $search)->paginate(10),
        ]);

    }

    public function asss(){
        $this->resetPage();
    }
    public function back(){

    }
    public function add(){
        $this->open_modal=true;
    }
    public function submit(){
        sleep(2);

         $this->validate([
             'productname' => 'required',
             'productprice' => 'required',
             'description' => 'required',
             'stocks' => 'required',
             'photo' => 'required',
         ]);
     $photopath = $this->photo->store('photos', 'public');
      pro::create([
            'productname' => $this->productname,
            'productprice' => $this->productprice,
            'description' => $this->description,
            'stocks' => $this->stocks,
            'photo' => $photopath,

        ]);
        $this->notification()->success(
            $title = 'Product saved!',
            $description = 'The product was saved successfully'
        );

        $this->open_modal = false;
        $this->reset([
            'productname', 'productprice', 'description','stocks', 'photo'
        ]);
    }


    public function edit($id){
        $data = pro::where('id', $id)->first();


        if ($data) {

                    $this->productname = $data->productname;
                    $this->productprice = $data->productprice;
                    $this->description = $data->description;
                    $this->stocks = $data->stocks;

                    $this->currentPhoto = asset(Storage::url($data->photo));
                    $this->guest_id = $data->id;
                    $this->edit_modal = true;

                }
    }

    public function Update(){

        $data = pro::find($this->guest_id);

        $this->validate([
            'productname' => 'required',
            'productprice' => 'required',
            'description' => 'required',
            'stocks' => 'required',
        ]);

        if ($this->photo) {

            $photopath = $this->photo->store('photos', 'public');
            $data->update([
                'photo' => $photopath,
            ]);
        }

        $data->update([
            'productname' => $this->productname,
            'productprice' => $this->productprice,
            'description' => $this->description,
            'stocks' => $this->stocks,
        ]);

        $this->notification()->success(
            $title = 'Product Update!',
            $description = 'The product was updated successfully'
        );

        $this->edit_modal = false;

        $this->reset([
            'productname', 'productprice', 'description', 'stocks', 'photo', 'currentPhoto'
        ]);
    }

    public function delete($id){
        $product = pro::find($id);

    if ($product) {
        $product->delete();

        $this->notification()->success(
            $title = 'Product Deleted!',
            $description = 'The product was deleted successfully'
        );
    } else {
        $this->notification()->error(
            $title = 'Product Not Found!',
            $description = 'The product with the specified ID was not found'
        );
    }
    }
}
