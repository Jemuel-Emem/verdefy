<x-app-layout>
    <div class="max-w-lg mx-auto mt-20 text-center">
        <h1 class="text-2xl font-bold">Verify Your Email Address</h1>
        <p class="mt-4">A verification link has been sent to your email address. Please check your inbox.</p>

        <form method="POST" action="{{ route('verification.send') }}" class="mt-6">
            @csrf
            <x-button>Resend Verification Email</x-button>
        </form>

        @if (session('message'))
            <p class="text-green-500 mt-4">{{ session('message') }}</p>
        @endif
    </div>
</x-app-layout>
