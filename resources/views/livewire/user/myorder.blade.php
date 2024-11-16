<div class="p-12 min-h-screen  text-gray-100">

    <div class="flex justify-center items-center mb-12">
        <h1 class="text-4xl font-black text-green-500 tracking-wide">MY ORDERS</h1>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
        @foreach ($orders as $order)
        <x-card class="shadow-xl hover:shadow-2xl transition-shadow duration-300 ease-in-out rounded-lg bg-gradient-to-b from-green-900 to-green-800 border border-green-700">
            <div class="p-6 flex flex-col gap-6">

                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold text-green-500">Order Details</h2>
                    <i class="ri-calendar-schedule-line text-4xl text-green-400"></i>
                </div>

                <div class="grid gap-3 text-gray-200">
                    <div><strong>Order ID:</strong> {{ $order['order_id'] }}</div>
                    <div><strong>Name:</strong> {{ $order['user']->name }}</div>
                    <div><strong>Address:</strong> {{ $order['user']->address }}</div>
                    <div><strong>Total Fee:</strong> <span class="text-yellow-400 font-semibold">₱{{ number_format($order['totalAmount'], 2) }}</span></div>
                    <div><strong>Delivery Date:</strong> {{ $order['deliverydate'] ?? 'Pending' }}</div>


                    <div>
                        <strong>Status:</strong>
                        <span class="px-3 py-1 rounded-lg text-sm {{
                            $order['status'] == 'To Deliver' ? 'bg-orange-500 text-white' :
                            ($order['status'] == 'Delivered' ? 'bg-green-500 text-white' : 'bg-gray-600 text-white') }}">
                            {{ $order['status'] }}
                        </span>
                    </div>
                </div>


                @if ($order['status'] == 'Done')
                <div class="flex justify-end mt-6" x-data="{ title: 'Are you sure you want to delete this order?' }">
                    <x-button label="Delete"
                              danger
                              x-on:confirm="{ title, icon: 'warning', method: 'delete', params: {{ $order['order_id'] }} }"
                              class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-md transition duration-300" />
                </div>
                @endif
            </div>
        </x-card>
        @endforeach
    </div>

    @if($orders->isEmpty())
    <div class="text-center mt-16">
        <h3 class="text-3xl text-gray-400">No orders found.</h3>
        <p class="text-gray-500 mt-4">You haven't placed any orders yet.</p>
    </div>
    @endif
</div>
