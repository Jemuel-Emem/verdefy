<div>
    <div class="p-8">

        <div class="flex justify-center items-center mb-8">
            <label class="text-3xl font-black text-green-700 tracking-wide">MY ORDERS</label>
        </div>


        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($orders as $order)
                <x-card class="shadow-lg hover:shadow-2xl transition-shadow duration-300 ease-in-out rounded-lg border border-gray-200 bg-gradient-to-b from-gray-50 to-gray-100 p-6">
                    <div class="flex flex-col gap-4">

                        <div class="flex justify-between items-center">
                            <span class="font-bold text-gray-700 text-xl">Order Details</span>
                            <i class="ri-calendar-schedule-line text-3xl text-green-600"></i>
                        </div>


                        <div class="grid grid-cols-1 gap-4">
                            <div><strong>Order ID:</strong> {{ $order['order_id'] }}</div>
                            <div><strong>Name:</strong> {{ $order['user']->name }}</div>
                            <div><strong>Address:</strong> {{ $order['user']->address }}</div>
                            <div><strong>Total Fee:</strong> {{ number_format($order['totalAmount'], 2) }} Php</div>
                            <div><strong>Delivery Date:</strong> {{ $order['deliverydate'] ?? 'Pending' }}</div>
                            <div>
                                <strong>Status:</strong>
                                <span class="px-3 py-1 rounded-lg text-sm {{
                                    $order['status'] == 'To Deliver' ? 'bg-orange-500 text-white' :
                                    ($order['status'] == 'Delivered' ? 'bg-green-600 text-white' : 'bg-gray-500 text-white') }}">
                                    {{ $order['status'] }}
                                </span>
                            </div>
                        </div>


                        @if ($order['status'] == 'Done')
                        <div class="flex justify-end mt-4" x-data="{ title: 'Are you sure you want to delete this order?' }">
                            <x-button
                                label="Delete"
                                danger
                                x-on:confirm="{ title, icon: 'warning', method: 'delete', params: {{ $order['order_id'] }} }"
                            />
                        </div>
                        @endif
                    </div>
                </x-card>
            @endforeach
        </div>
    </div>
</div>
