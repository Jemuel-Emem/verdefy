<div class="text-gray-100 p-8">
    <div class="flex justify-center items-center gap-4 mb-8">
        <div class="flex items-center gap-2 p-4">
            <x-input class="w-full md:w-80" placeholder="Search products..." wire:model="search" style="width: 300px;" />
            <x-button label="Search" wire:click.prevent="asss" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md" />
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-10">
        @foreach($product as $cot)
        <x-card class="w-full max-w-xs bg-gradient-to-b from-green-900 to-green-800 border border-green-700 shadow-xl rounded-lg hover:shadow-2xl">
            <div class="relative overflow-hidden rounded-t-lg">
                <img src="{{ asset(Storage::url($cot->photo)) }}" alt="{{ $cot->productname }}" class="w-full h-56 object-cover hover:scale-110 transition-transform duration-500">
            </div>

            <div class="p-6">
                <h3 class="text-2xl font-bold text-green-500 text-center">{{ $cot->productname }}</h3>
                <p class="text-gray-400 mt-2">{{ Str::limit($cot->description, 80, '...') }}</p>
                <span class="text-yellow-500 font-semibold text-lg">{{ number_format($cot->productprice, 2) }} Php</span>
            </div>

            <div class="mt-4 flex justify-between items-center p-4 bg-green-700 rounded-b-lg">
                <x-button label="Add to Cart" class="bg-green-600 hover:bg-green-700 text-white" wire:click="add({{ $cot->id }})" />
                <x-button label="View Comments" class="bg-gray-800 hover:bg-green-700 text-white" wire:click="showComments({{ $cot->id }})" />
            </div>
        </x-card>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8 flex justify-center">
        {{ $product->links() }}
    </div>

   <!-- Comments Modal -->
<x-modal wire:model.defer="showCommentsModal">
    <x-card title="Comments for {{ $selectedProduct ? $selectedProduct->productname : '' }}">
        @if ($comments)
            <div class="space-y-4">
                @foreach($comments as $comment)
                    <div class="bg-gray-700 p-4 rounded-md">
                        <div class="flex justify-between">
                            <span class="text-yellow-500">{{ $comment->user->name }}</span>
                            <span class="text-gray-400 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-300 mt-2">{{ $comment->comment }}</p>
                        <p class="text-yellow-300 mt-1">Rating: {{ $comment->rate }} / 5</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-300">No comments found.</p>
        @endif

        <!-- Leave a Comment Form -->
        @auth
        <div class="mt-6">
            <x-card title="Leave a Comment">
                <div class="space-y-3">
                    <x-select wire:model="rate" label="Rate (1-5)" :options="[1, 2, 3, 4, 5]" />
                    <x-textarea
                        wire:model="comment"
                        label="Your Comment"
                        placeholder="Write your comment here..."
                        class="w-full"
                        required
                    />
                </div>
                <x-slot name="footer">
                    <x-button flat label="Cancel" wire:click="$set('showCommentsModal', false)" />
                    <x-button class="bg-green-600 hover:bg-green-700 text-white" label="Submit" wire:click="submitComment" />
                </x-slot>
            </x-card>
        </div>
        @endauth

        @guest
        <p class="text-gray-400 mt-4">Please log in to leave a comment.</p>
        @endguest
    </x-card>

    <x-slot name="footer">
        <x-button flat label="Close" wire:click="$set('showCommentsModal', false)" />
    </x-slot>
</x-modal>

</div>
