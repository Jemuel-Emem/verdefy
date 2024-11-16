<div class="p-12 min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-700">Your Cart</h1>
        <button wire:click="calculateTotalPrice"
                class="text-blue-600 hover:text-blue-700 underline">
            View Summary
        </button>
    </div>

    <!-- Products Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($carts as $cot)
        <x-card title="{{ $cot->product->productname }}" class="text-blue-800 shadow-lg rounded-lg border border-gray-200">
            <!-- Product Image and Quantity -->
            <div class="flex flex-col items-center">
                <img src="{{ asset(Storage::url($cot->product->photo)) }}"
                     alt="Product Image"
                     class="w-full h-48 object-cover rounded mb-4 shadow-md">
                <x-inputs.number wire:model="quantities.{{ $cot->id }}"
                                 label="Item Quantity"
                                 class="w-3/4" />
            </div>


            <x-slot name="footer">
                <div class="flex justify-between items-center mt-4">
                    <span class="text-lg text-yellow-500 font-semibold">{{ $cot->product->productprice }} Php</span>
                    <div x-data="{ title: 'Sure Delete?' }">
                        <x-button label="Delete" danger
                        x-on:confirm="{
                            title: 'Are you sure?',
                            icon: 'warning',
                            method: 'delete',
                            params: {{ $cot->id }}
                        }"
                        class="ml-4 bg-red-500 hover:bg-red-600 text-white" />

                    </div>
                </div>
                <div class="mt-4 flex items-center">
                    <x-checkbox id="checkbox_{{ $cot->id }}"
                                wire:model="selectedProducts.{{ $cot->id }}"
                                class="mr-2" />
                    <label for="checkbox_{{ $cot->id }}" class="text-gray-600">Select Product</label>
                </div>
            </x-slot>
        </x-card>
        @endforeach
    </div>

  <!-- Order Summary Modal -->
<x-modal wire:model.defer="open_modal">
    <x-card title="Your Order Summary" class="relative shadow-lg bg-white rounded-lg">
        @if(count($selectedProductList) > 0)
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Order List</h2>
            <ul class="space-y-4">
                @foreach($selectedProductList as $product)
                    <li class="flex items-center">
                        <img src="{{ asset('storage/' . $product['photo']) }}"
                             alt="{{ $product['productname'] }}"
                             class="w-20 h-20 object-cover rounded mr-4">
                        <span class="text-gray-700">
                            {{ $product['productname'] }} -
                            <span class="text-teal-600 font-semibold">Php {{ $product['productprice'] }}</span>
                            x {{ $product['quantity'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-center text-gray-500">No products selected.</p>
        @endif

        <div class="mt-6 space-y-3">
            <div class="text-center">
                <p class="text-2xl font-bold text-blue-800">Total Price: {{ $totalPrice }} Php</p>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4 mt-6">
                <x-button flat label="Cancel" x-on:click="close"
                          class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg" />
                <x-button wire:click="ordernow"
                          class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-lg transition duration-300">
                    Place Order
                </x-button>
            </div>
        </x-slot>
    </x-card>
</x-modal>

</div>
