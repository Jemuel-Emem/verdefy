<div>

<div class="" >
    <div class="flex gap-2 mt-2 p-4">
        <x-input label="" placeholder="Search..." wire:model="search" />
    <div>
        <x-button  label="Search " wire:click.prevent="asss" green />
    </div>

    <button class="bg-green-500 text-white hover:bg-green-600 w-36 rounded"  wire:click="add">Add Product </button>
    </div>
    <div class="relative overflow-x-auto mt-4  flex justify-center w-screen" id="printContent" >
        <table class=" text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 w-screen p-4">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr class="">
                    <th scope="col" class="px-6 py-3 mr-12">
                       Product Name
                     </th>
                     <th scope="col" class="px-6 py-3 mr-12">
                        Product Price
                      </th>
                    <th scope="col" class="px-6 py-3 mr-12">
                      Description
                    </th>
                    <th scope="col" class="px-6 py-3 mr-12">
                       Stocks
                      </th>
                    <th scope="col" class="px-6 py-3 mr-12">
                       Photo
                     </th>
                     <th scope="col" class="px-6 py-3 mr-12">
                        Action
                      </th>


                </tr>
            </thead>
            <tbody style="width: 1000px;">
                 @foreach($product as $cot)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->productname}}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->productprice }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->description }}
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->stocks }}
                    </td>
                    <td class="px-6 py-4">
                         <img src="{{ asset(Storage::url($cot->photo)) }}" alt="Valid ID" class="w-20 h-16 rounded">
                    </td>

                    <td class="px-6 py-4 ">
                      <span class="flex gap-4">
                        <x-button positive  wire:click="edit({{ $cot->id }})" label="Edit" />
                        <div x-data="{ title: 'Sure Delete?' }">
                            <x-button label="Delete" negative
                                x-on:confirm="{
                                    title,
                                    icon: 'warning',
                                    method: 'delete',
                                    params: {{ $cot->id }}
                                }"
                            />
                        </div>
                    </span>
                    </td>


                </tr>


            @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3">
                        <div class="mt-4">
                            {{ $product->links() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- <div class="flex justify-end mr-12">
        <x-button secondary label="Print" class="w-64" id="printButton"/>
    </div> --}}
</div>

    <x-modal wire:model.defer="open_modal">
        <x-card title="Add Product">
            <div class="space-y-3">
                <div class="flex gap-2">
                    <x-input label="Product Name" placeholder="" wire:model="productname" required />
                  </div>
              <div class="flex gap-2">
                <x-input label="Product Price" placeholder="" wire:model="productprice" required/>
              </div>

              <div class="flex gap-2">
                <x-input label="Stocks" placeholder="" wire:model="stocks" required/>
              </div>
              <div class="flex gap-2">
                <x-textarea wire:model="description" label="Product Description" placeholder=".." class="" style="width: 630px;" required/>
              </div>

              <div class="flex gap-2">

                <input type="file" wire:model="photo" accept="image/*" required>
              </div>



            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close"  wire:click="back"/>
                    <x-button class="bg-green-500 hover:bg-green-600 text-white" label="Submit" wire:click="submit" spinner="submit" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>


    <x-modal wire:model.defer="edit_modal">
        <x-card title="Update Product">
            <div class="space-y-3">
                <div class="flex gap-2">
                    <x-input label="Product Name" placeholder="" wire:model="productname" required />
                  </div>
              <div class="flex gap-2">
                <x-input label="Product Price" placeholder="" wire:model="productprice" required/>
              </div>

              <div class="flex gap-2">
                <x-input label="Stocks" placeholder="" wire:model="stocks" required/>
              </div>
              <div class="flex gap-2">
                <x-textarea wire:model="description" label="Product Description" placeholder=".." class="" style="width: 630px;" required/>
              </div>



             <div>
            @if($currentPhoto)
             <div class="mt-2">
             <img src="{{ $currentPhoto }}" alt="Current Photo" class="w-80 h-32 rounded">
             </div>
             @endif
           </div>
              <div class="flex gap-2">
                <input type="file" wire:model="photo" accept="image/*" required>
              </div>

            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />
                    <x-button class="bg-amber-900 hover:bg-amber-950 text-white" label="Update" wire:click="Update"  />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <script>
        function printPage() {
         var printContent = document.getElementById("printContent").innerHTML;
         var originalContent = document.body.innerHTML;


         var header = "<h1 style='text-align: center;'>REPORTS</h1>";
         printContent = header + printContent;

         document.body.innerHTML = printContent;
         window.print();
         document.body.innerHTML = originalContent;
     }

         document.getElementById("printButton").addEventListener("click", printPage);
     </script>

<style>
@media print {
    body > *:not(#printContent) {
        display: none !important;
    }
}
</style>
</div>
