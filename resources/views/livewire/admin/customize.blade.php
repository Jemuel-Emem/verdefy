<div>


    <div class="flex gap-2 mt-2  p-4">
        <x-input label="" placeholder="Search..." wire:model="search" />
    <div>
        <x-button  label="Search " wire:click.prevent="asss" green />
    </div>

    </div>
    <div class="  mt-4  flex justify-center w-screen" >
        <table class=" text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 p-4 md:w-screen" >
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 ">
                <tr class="">
                    <th scope="col" class="px-6 py-3 mr-12">
                       Name
                     </th>

                     <th scope="col" class="px-6 py-3 mr-12">
                   Material
                      </th>
                    <th scope="col" class="px-6 py-3 mr-12">
                  Furniture Type
                    </th>
                    <th scope="col" class="px-6 py-3 mr-12">
                   Preffered Design
                    </th>
                    <th scope="col" class="px-6 py-3 mr-12">
                       Comment
                         </th>
                <th scope="col" class="px-6 py-3 text-center">
                       Action
                </th>

                </tr>
            </thead>
            <tbody style="width: 2000px;">
                 @foreach($product as $cot)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->name}}
                    </td>

                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white items-center">
                        {{ $cot->material }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->furnituretype }}
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        <img src="{{ asset(Storage::url($cot->photo)) }}" alt="Valid ID" class="w-20 h-16 rounded">
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{ $cot->comment }}
                    </td>


                    <td class="px-6 py-4 text-center ">
                      <span>
                        <button class="text-red-500 hover:text-red-600  w-32" wire:click="delete({{ $cot->id }})">Delete</button>
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


    <x-modal wire:model.defer="edit_modal">
        <x-card title="Modify Dilevery Schedule">
            <div class="space-y-3">
                <div class="flex gap-2">
                    <x-input label="Product Name" placeholder="" wire:model="deliveryschedule" required />
                  </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close"  />
                    <x-button class="bg-amber-900 hover:bg-amber-950 text-white" label="Set" wire:click="update" spinner="Set" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>



</div>
