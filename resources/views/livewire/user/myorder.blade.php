<!-- resources/views/livewire/user/myorder.blade.php -->

<div class="p-12">
    <label for="" class="text-yellow-900 text-2xl font-black">MY ORDER</label>

    @foreach ($product as $order)
    <div class="mt-4">
        <x-card>
            <div class="flex md:flex-row flex-col justify-around md:gap-6 gap-4 p-2 relative">
                <span class="font-bold">Name:</span>
                <span class="rounded-xl p-1 text-sm">{{ $order->name }}</span>
                <span class="font-bold">Address:</span>
                <span class="rounded-xl p-1 text-sm">{{ $order->address }}</span>
                <span class="font-bold">Total Fee:</span>
                <span class="rounded-xl p-1 text-sm">{{ $order->totalorder }}</span>
                <span class="font-bold">Delivery Date:</span>
                <span class="rounded-xl p-1 text-sm">{{ $order->deliverydate }}</span>
                <span class="font-bold">Status:</span>
                @if ($order->status == 'Pending')
                <span class="rounded-xl p-2 text-sm bg-orange-600 text-white md:text-start text-center">{{ $order->status }}</span>
                @elseif ($order->status == 'Done')
                <span class="rounded-xl p-2 text-sm bg-green-600 text-white md:text-start text-center">{{ $order->status }}</span>
                @endif
                <i class="ri-calendar-schedule-line md:text-4xl text-8xl absolute right-2 md:top-0 top-16 text-green-500"></i>
            </div>
            @if ($order->status == 'Pending')
            <span>.</span>
            @elseif ($order->status == 'Done')
            <div class="flex justify-end">
                <div x-data="{ title: 'Sure Delete?' }">
                    <x-button label="Delete" danger x-on:confirm="{
                        title,
                        icon: 'warning',
                        method: 'delete',
                        params: {{ $order->id }}
                    }" />
                </div>
            </div>
            @endif
        </x-card>
    </div>
    @endforeach
</div>
