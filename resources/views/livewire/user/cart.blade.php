<div class="p-12 h-screen">
    <div class="grid md:grid-cols-1 grid-col-1 gap-4 relative">
       <div class="flex justify-end">

        <button wire:click="calculateTotalPrice"><span class="text-right underline text-green-500 hover:text-green-600">View Summary</span></button>
       </div>
        @foreach($product as $cot)
            <x-card title="{{ $cot->productname }}" class="w-80 text-amber-700 ">
                <div class="">
                    <img src="{{ asset(Storage::url($cot->photo)) }}" alt="Valid ID" class="ml-12 w-52 h-32 rounded">
                    <x-inputs.number wire:model="quantities.{{ $cot->id }}" label="Item Quantity" />
                     <a href="{{ route('terms') }}" class="text-green-500 underline">Terms and Condition</a>
                </div>


                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <label for="" class="text-amber-700">{{ $cot->productprice }} Php</label>
                        <div>
                            <div x-data="{ title: 'Sure Delete?' }">
                                <x-button label="Delete" danger
                                    x-on:confirm="{
                                        title,
                                        icon: 'warning',
                                        method: 'delete',
                                        params: {{ $cot->id }}
                                    }"
                                />
                            </div>

                        </div>
                    </div>
                    <x-checkbox id="checkbox_{{ $cot->id }}" wire:model="selectedProducts.{{ $cot->id }}" />

                    </x-slot>
            </x-card>
        @endforeach

    </div>



    <x-modal wire:model.defer="open_modal">
        <x-card title="Your Order" class="relative">
        @if(count($selectedProductList) > 0)
        <h2 class="text-xl font-bold">Order List:</h2>
        <ul >
        @foreach($selectedProductList as $selectedProduct)
        <img class="w-60 h-28 rounded" src="{{ asset('storage/' . $selectedProduct->photo) }}" alt="{{ $selectedProduct->productname }}" >
            <li>{{ $selectedProduct->productname }} - <span class="text-red-700">Php{{ $selectedProduct->productprice }}</span>
               </li>

        @endforeach
       </ul>
       @else
        <p>No products selected.</p>
        @endif

            <x-checkbox id="left-label" class=" font-serif" label="Please check this checkbox if you already read the terms and condition" wire:model="agree" wire:click="toggleAgree" />
            <div class="space-y-3 ">
                <p class="md:text-2xl text-xl text-yellow-800">Total Price: {{ $totalPrice }} Php</p>
            </div>
            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" x-on:click="close" />

                    <x-button class="bg-amber-900 hover:bg-amber-950 text-white" label="Place Order" wire:click="ordernow" />

                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>

</div>
