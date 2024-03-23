<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{route('home')}}">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">

        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        @if (isset($message) && !empty($message))
        <div class="p-3 border-2 border-rose-200 bg-rose-500 text-white font-semibold mb-4 rounded-lg">
            {{ $message }}
        </div>
        @endif

        <form method="POST" action="">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-0 w-full" type="email" name="email" :value="old('email')" required
                    autofocus />
            </div>


            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-0 w-full" type="password" name="password" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Login') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>