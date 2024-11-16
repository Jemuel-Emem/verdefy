<div class="relative">
    <div class="flex justify-around">
        <img src="{{ asset('images/bgcos.jpg') }}" alt="Background" class="w-10/12 h-80 rounded-md blur-sm">
    </div>

    <div class="flex justify-center absolute top-2 right-4 left-4">
        <span class="bg-green-900 p-4 rounded-xl text-white mt-12 text-4xl font-bold tracking-wide text-center" style="font-family: Arial, Helvetica, sans-serif;">
            "WELCOME TO VERDEFY ONLINE ORDERING SYSTEM"
        </span>
    </div>

    <div class="mt-24 mb-8 text-center">
        <h2 class="text-3xl font-bold text-green-900 border-b-4 border-green-700 inline-block pb-2">Recommended Products</h2>
    </div>

    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10 p-8">
        @foreach($product as $cot)
        <x-card class="w-full max-w-xs mx-auto bg-green-950 border border-green-800 shadow-lg rounded-lg hover:shadow-2xl transform hover:scale-105 transition-all duration-300 ease-in-out">
            <div class="relative flex justify-center items-center overflow-hidden rounded-t-lg">
                <img src="{{ asset(Storage::url($cot->photo)) }}" alt="{{ $cot->productname }}" class="w-full h-48 object-cover rounded-t-lg hover:scale-110 transition-transform duration-500 ease-in-out">
            </div>

            <div class="p-6 text-gray-100">
                <h3 class="text-2xl font-bold text-white text-center mb-4">{{ $cot->productname }}</h3>

                <div class="text-sm">
                    <span class="font-semibold">Description:</span>
                    <p class="text-gray-300 mt-2 leading-relaxed">{{ $cot->description }}</p>
                </div>

                <div class="mt-3">
                    <span class="font-semibold text-yellow-300">
                        Rating: {{ number_format($cot->comments_avg_rate, 1) }} / 5
                    </span>

                    <p class="text-green-300">{{ $cot->recommendation }}
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-between items-center p-4 bg-green-900 rounded-b-lg">
                    <span class="text-yellow-300 font-semibold text-lg">{{ $cot->productprice }} Php</span>
                    <x-button label="Add to Cart" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors duration-300" wire:click="add({{ $cot->id }})"/>
                </div>
            </x-slot>
        </x-card>
        @endforeach
    </div>
</div>
