<div class="p-12 min-h-screen  text-gray-100">

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-4xl font-extrabold text-green-500">Your Cart</h1>
        <x-button label="View Summary" wire:click="calculateTotalPrice" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg" />
    </div>


    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10 bg-blue">
        @foreach($carts as $cot)
        <x-card class="w-full bg-gradient-to-b from-green-900 to-green-800 border border-green-700 shadow-xl rounded-lg hover:shadow-2xl">
            <div class="relative overflow-hidden rounded-t-lg">
                <img src="{{ asset(Storage::url($cot->product->photo)) }}" alt="{{ $cot->product->productname }}" class="w-full h-48 object-cover hover:scale-110 transition-transform duration-500">
            </div>

            <div class="p-6">
                <h3 class="text-2xl font-bold text-green-500 text-center">{{ $cot->product->productname }}</h3>
                <div class="text-yellow-500 font-semibold text-lg mt-2 text-center">₱{{ number_format($cot->product->productprice, 2) }}</div>
                <div class="mt-4">
                    <x-inputs.number wire:model="quantities.{{ $cot->id }}" label="Quantity" class="w-full  text-black" min="1" />
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-between items-center mt-4 p-4 bg-green-700 rounded-b-lg">

                    <div x-data="{ title: 'Are you sure you want to delete this item?' }">
                        <x-button label="Delete" danger x-on:confirm="{ title, icon: 'warning', method: 'delete', params: {{ $cot->id }} }" class="bg-red-600 hover:bg-red-700 text-white" />
                    </div>


                    <div class="flex items-center">
                        <x-checkbox id="checkbox_{{ $cot->id }}" wire:model="selectedProducts.{{ $cot->id }}" class="mr-2" />
                        <label for="checkbox_{{ $cot->id }}" class="text-gray-300">Select</label>
                    </div>
                </div>
            </x-slot>
        </x-card>
        @endforeach
    </div>

    <div class="mt-12 flex justify-center">
        {{ $carts->links() }}
    </div>

    <x-modal wire:model.defer="open_modal">
        <x-card title="Your Order Summary" class="bg-gray-900 text-white">
            @if(count($selectedProductList) > 0)
                <h2 class="text-2xl font-bold text-gray-100 mb-6">Order List</h2>
                <ul class="space-y-4">
                    @foreach($selectedProductList as $product)
                    <li class="flex items-center space-x-4">
                        <img src="{{ asset('storage/' . $product['photo']) }}" alt="{{ $product['productname'] }}" class="w-20 h-20 object-cover rounded">
                        <div class="text-gray-300">
                            <span>{{ $product['productname'] }} - </span>
                            <span class="text-green-500 font-semibold">₱{{ number_format($product['productprice'], 2) }}</span>
                            <span>x {{ $product['quantity'] }}</span>
                        </div>
                    </li>
                    @endforeach
                </ul>
            @else
                <p class="text-center text-gray-400">No products selected.</p>
            @endif


            <div class="mt-8 text-center">
                <p class="text-3xl font-bold text-green-500">Total Price: ₱{{ number_format($totalPrice, 2) }}</p>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end mt-6 gap-x-4">
                    <x-button flat label="Cancel" wire:click="$set('open_modal', false)" class="bg-gray-600 hover:bg-gray-700 text-white" />
                    <x-button wire:click="ordernow" class="bg-teal-500 hover:bg-teal-600 text-white px-6 py-2 rounded-lg transition duration-300">
                        Place Order
                    </x-button>
                </div>
            </x-slot>
        </x-card>
    </x-modal>
</div>
