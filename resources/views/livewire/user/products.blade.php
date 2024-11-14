<div class=" text-gray-100 p-8">

    <div class="flex justify-center items-center gap-4 mb-8">
        <div class="flex items-center gap-2">

            <x-input class="w-full md:w-80" placeholder="Search products..." wire:model="search" />


            <x-button
                label="Search"
                wire:click.prevent="asss"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition-colors duration-300"
            />
        </div>
    </div>



    <div class="flex justify-center">
        <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10">
            @foreach($product as $cot)
            <x-card class="w-full max-w-xs bg-green-800 border border-green-700 shadow-lg rounded-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">


                <div class="relative flex justify-center items-center overflow-hidden rounded-t-lg">
                    <img src="{{ asset(Storage::url($cot->photo)) }}" alt="{{ $cot->productname }}" class="w-full h-48 object-cover rounded-t-lg hover:scale-110 transition-transform duration-500 ease-in-out">
                </div>


                <div class="p-6">
                    <h3 class="text-2xl font-bold text-center mb-4">{{ $cot->productname }}</h3>
                    <div class="mt-2 text-sm text-gray-200">
                        <span class="font-semibold">Description:</span>
                        <p class="text-gray-300 mt-2 leading-relaxed">{{ $cot->description }}</p>
                    </div>
                </div>


                <x-slot name="footer">
                    <div class="flex justify-between items-center p-4 bg-green-700 rounded-b-lg">
                        <span class="text-yellow-300 font-semibold text-lg">{{ $cot->productprice }} Php</span>
                        <x-button label="Add to Cart" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-300" wire:click="add({{ $cot->id }})"/>
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
