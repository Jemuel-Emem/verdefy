<div>

    <div class="" >
        <div class="flex gap-2 mt-2 p-4">
            <x-input label="" placeholder="Search..." wire:model="search" />
        <div>
            <x-button  label="Search " wire:click.prevent="asss" green />
        </div>

        </div>
        <div id="printContent" class=" overflow-x-auto mt-4  flex justify-center w-screen p-4" >
            <table class=" text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 w-screen p-4" >
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
                    <tr class="">
                        <th scope="col" class="px-6 py-3 mr-12">
                           Name
                         </th>
                         <th scope="col" class="px-6 py-3 mr-12">
                         Address
                          </th>
                          <th scope="col" class="px-6 py-3 mr-12">
                        Phonenumber
                          </th>
                         <th scope="col" class="px-6 py-3 mr-12">
                           Email
                          </th>

                    </tr>
                </thead>
                <tbody style="width: 2000px;">
                     @foreach($product as $cot)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $cot->name}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $cot->address}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $cot->phonenumber}}
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white items-center">
                            {{ $cot->email }}
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
        <div class="flex justify-end mr-12">
            <x-button secondary label="Print" class="w-64" id="printButton"/>
        </div>

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

                    <x-textarea wire:model="description" label="Product Description" placeholder=".." class="w-80" required/>
                  </div>
                  <div class="flex gap-2">

                    <x-textarea wire:model="stocks" label="Stocks" placeholder=".." class="w-80" required/>
                  </div>


                  <div class="flex gap-2">
                    <input type="file" wire:model="photo" accept="image/*" required>
                  </div>



                </div>

                <x-slot name="footer">
                    <div class="flex justify-end gap-x-4">
                        <x-button flat label="Cancel" x-on:click="close"  wire:click="back"/>
                        <x-button class="bg-amber-900 hover:bg-amber-950 text-white" label="Submit" wire:click="submit" spinner="submit" />
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
