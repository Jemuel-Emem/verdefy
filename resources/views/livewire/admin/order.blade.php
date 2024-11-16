<div>
    <div>
        <div class="overflow-x-auto mt-4 flex justify-center w-screen p-4" id="printContent">
            <table class="text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 w-screen">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Order Id</th>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Phone Number</th>
                        <th scope="col" class="px-6 py-3">Address</th>
                        <th scope="col" class="px-6 py-3">Order List</th>
                        <th scope="col" class="px-6 py-3">Quantity</th>
                        <th scope="col" class="px-6 py-3">Total Order</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>

               <tbody>
                @foreach ($orders as $orderGroup)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">

                        <td class="px-6 py-4">{{ $orderGroup['order_id'] }}</td>
                        <td class="px-6 py-4">{{ $orderGroup['user']->name }}</td>
                        <td class="px-6 py-4">{{ $orderGroup['user']->phonenumber }}</td>
                        <td class="px-6 py-4">{{ $orderGroup['user']->address }}</td>


                        <td class="px-6 py-4">
                            <button wire:click="viewUserOrders({{ $orderGroup['user']->id }}, '{{ $orderGroup['order_id'] }}')" class="text-blue-500">View Orders</button>
                        </td>


                        <td class="px-6 py-4">{{ $orderGroup['quantity'] }}</td>
                        <td class="px-6 py-4">{{ $orderGroup['totalorder'] }}</td>


                        <td class="px-6 py-4">
                            <button wire:click="confirmOrder({{ $orderGroup['orders']->first()->id }})">Confirm</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>


            </table>

            <div>
                {{ $orders->links() }}
            </div>
        </div>
    </div>

    <x-modal wire:model.defer="openModal" max-width="lg">
        <x-card title="User Orders">
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse text-sm text-left text-gray-600">
                    <thead>
                        <tr class="border-b">
                            <th class="px-6 py-3 font-semibold text-gray-700">Product Name</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Quantity</th>
                            <th class="px-6 py-3 font-semibold text-gray-700">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userOrders as $order)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-6 py-3">{{ $order->product->productname ?? 'Product Not Found' }}</td>
                                <td class="px-6 py-3">{{ $order->quantity }}</td>
                                <td class="px-6 py-3">{{ $order->totalorder }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-button flat label="Close" wire:click="$set('openModal', false)" />
            </div>
        </x-slot>
    </x-modal>




    <div class="flex justify-end mr-12">
        <x-button secondary label="Print" class="w-64" id="printButton"/>
    </div>

    <script>
        function printPage() {
            var printContent = document.getElementById("printContent").innerHTML;
            var originalContent = document.body.innerHTML;

            var header = "<h1 style='text-align: center;'>REPORTS</h1>";
            printContent = header + printContent;

            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;
        }

        document.getElementById("printButton").addEventListener("click", printPage);
    </script>
</div>
