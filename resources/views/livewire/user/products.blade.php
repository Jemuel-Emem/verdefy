<div class=" text-gray-100 p-8">

    <div class="flex justify-center items-center gap-4 mb-8">
        <div class="flex items-center gap-2 p-4">

            <x-input class="w-full md:w-80" placeholder="Search products..." wire:model="search" style="width: 300px;"/>


            <x-button
                label="Search"
                wire:click.prevent="asss"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition-colors duration-300"
            />
        </div>
    </div>


    <div class="flex justify-center mt-6">
        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10">
            @foreach($product as $cot)
            <x-card class="w-full max-w-xs bg-gradient-to-b from-green-900 to-green-800 border border-green-700 shadow-xl rounded-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">


                <div class="relative overflow-hidden rounded-t-lg">
                    <img src="{{ asset(Storage::url($cot->photo)) }}" alt="{{ $cot->productname }}"
                        class="w-full h-56 object-cover rounded-t-lg hover:scale-110 transition-transform duration-500 ease-in-out">
                </div>


                <div class="p-6">
                    <h3 class="text-2xl font-bold text-green-500 text-center mb-3">{{ $cot->productname }}</h3>
                    <div class="mt-3 text-sm text-gray-400 leading-relaxed">
                        <span class="font-semibold ">Description</span>
                        <p class="text-gray-400 mt-2">{{ Str::limit($cot->description, 80, '...') }}</p>
                    </div>
                </div>


                <x-slot name="footer">
                    <div class="flex justify-between items-center p-4 bg-green-700 rounded-b-lg">
                        <span class="text-yellow-500 font-semibold text-lg">{{ number_format($cot->productprice, 2) }} Php</span>
                        <x-button
                            label="Add to Cart"
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md transition-transform duration-300 hover:scale-110"
                            wire:click="add({{ $cot->id }})"
                        />
                    </div>
                </x-slot>
            </x-card>
            @endforeach
        </div>
    </div>


    <div class="mt-8 flex justify-center">
        <div class=" p-2 rounded-md">
            {{ $product->links() }}
        </div>
    </div>
</div>
