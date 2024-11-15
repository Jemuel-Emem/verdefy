<div>
    <div class="p-8">
      
        <div class="flex justify-center items-center mb-8">
            <label class="text-3xl font-black text-green-700 tracking-wide">MY ORDERS</label>
        </div>


        <div class="grid md:grid-cols-3 lg:grid-cols-3 gap-8">
            @foreach ($product as $order)

            <x-card class="shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out rounded-lg border border-gray-200 bg-gradient-to-b from-gray-50 to-gray-100 p-6">
                <div class="flex flex-col gap-4">

                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-700 text-xl">Order Details</span>
                        <i class="ri-calendar-schedule-line text-3xl text-green-600"></i>
                    </div>


                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-600">Name:</span>
                            <span class="text-gray-800">{{ $order->name }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-600">Address:</span>
                            <span class="text-gray-800">{{ $order->address }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-600">Total Fee:</span>
                            <span class="text-gray-800">{{ number_format($order->totalorder, 2) }} Php</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-600">Delivery Date:</span>
                            <span class="text-gray-800">{{ $order->deliverydate }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-semibold text-gray-600">Status:</span>
                            <span class="px-3 py-1 rounded-lg text-sm
                                @if($order->status == 'Pending') bg-orange-500 text-white
                                @elseif($order->status == 'Done') bg-green-600 text-white
                                @endif">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>


                    <div class="flex justify-between mt-6">
                        @if ($order->status == 'Done')
                        <div x-data="{ title: 'Are you sure you want to delete this order?' }">
                            <x-button
                                label="Delete"
                                danger
                                class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md transition-colors duration-300"
                                x-on:confirm="{
                                    title,
                                    icon: 'warning',
                                    method: 'delete',
                                    params: {{ $order->id }}
                                }"
                            />
                        </div>
                        @endif

                        <div class="flex justify-end mt-6">
                            <x-button
                                label="Comment"
                                class="bg-gray-800 hover:bg-blue-700 text-white px-5 py-2 rounded-md transition-colors duration-300"
                                wire:click="openCommentModal({{ $order->id }})"
                            />
                        </div>
                    </div>
                </div>
            </x-card>
            @endforeach
        </div>
    </div>


    <x-modal wire:model.defer="open_comment_modal">
        <x-card title="Leave a Comment">
            <div class="space-y-3">
                <div class="flex flex-col gap-4">

                    <x-select wire:model="rate" label="Rate (1-5)" :options="[1, 2, 3, 4, 5]" />


                    <x-textarea wire:model="comment" label="Your Comment" placeholder="Write your comment here..." class="w-full" required />
                </div>
            </div>

            <x-slot name="footer">
                <div class="flex justify-end gap-x-4">
                    <x-button flat label="Cancel" wire:click="closeCommentModal" />
                    <x-button class="bg-green-600 hover:bg-green-700 text-white" label="Submit" wire:click="submitComment" spinner="submitComment" />
                </div>
            </x-slot>
        </x-card>
    </x-modal>

    <script>
        document.addEventListener('livewire:load', () => {
            @this.on('openCommentModal', orderId => {

                @this.set('orderId', orderId);
            });
        });
    </script>

    <style>

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
</div>
