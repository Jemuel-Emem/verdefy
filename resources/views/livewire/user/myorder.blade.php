<div class="p-8">
    <!-- Title Section -->
    <div class="flex justify-center items-center mb-8">
        <label class="text-3xl font-black text-green-700 tracking-wide">MY ORDERS</label>
    </div>

    <!-- Orders List -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($product as $order)
        <!-- Order Card -->
        <x-card class="shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out rounded-lg border border-gray-200 bg-gradient-to-b from-gray-50 to-gray-100 p-6">
            <div class="flex flex-col gap-4">
                <!-- Icon -->
                <div class="flex justify-between items-center">
                    <span class="font-bold text-gray-700 text-xl">Order Details</span>
                    <i class="ri-calendar-schedule-line text-3xl text-green-600"></i>
                </div>

                <!-- Order Information -->
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

                <!-- Action Buttons -->
                @if ($order->status == 'Done')
                <div class="flex justify-end mt-6">
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
                </div>
                @endif
            </div>
        </x-card>
        @endforeach
    </div>
</div>
