<div class="w-full mx-auto p-4 bg-gray-50 shadow-md rounded-lg">

    <div class="flex justify-end mb-6">
        <input
            type="text"
            wire:model.debounce.300ms="search"
            placeholder="Search by name or order ID..."
            class="input input-bordered w-full max-w-sm border border-gray-300 focus:ring focus:ring-blue-300 rounded-lg px-4 py-2 shadow-sm"
        />

        <button wire:click="asss" class="bg-green-500 text-white ml-4 w-32 p-2 rounded-sm hover:bg-green-600">Search</button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Order ID</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">User Name</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Phone Number</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Address</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Delivery Date</th>
                    <th class="px-6 py-3 text-left text-gray-700 font-semibold">Status</th>
                    <th class="px-6 py-3 text-center text-gray-700 font-semibold">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($schedules as $schedule)
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-gray-900">{{ $schedule->order->order_id ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $schedule->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $schedule->user->phonenumber ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $schedule->user->address ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-gray-900">{{ $schedule->deliverydate }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm
                                {{ $schedule->status == 'To Deliver' ? 'bg-yellow-200 text-yellow-800' : 'bg-green-200 text-green-800' }}">
                                {{ $schedule->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($schedule->status === 'To Deliver')
                                <button
                                    wire:click="markAsDelivered({{ $schedule->id }})"
                                    class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-sm transition-colors"
                                >
                                    Delivered
                                </button>
                            @else
                                <button
                                    class="bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed"
                                    disabled
                                >
                                    Completed
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-gray-500">
                            No schedules found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $schedules->links('pagination::tailwind') }}
    </div>
</div>
