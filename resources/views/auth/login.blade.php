<style>
    img {
    width: 159px;
    border-radius: 14px;
}
</style>
<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            {{-- <x-jet-authentication-card-logo /> --}}
            <!-- <img src= "{{asset('images/lechef.jpg')}}"> -->
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-jet-label for="mobile_phone" value="{{ __('MObile phone') }}" />
                <x-jet-input id="number" class="block mt-1 w-full" type="tel" name="mobile_phone" :value="old('mobile_phone')" required autofocus />
            </div>
            <!-- <div>
                <x-jet-label for="password" value="{{ __('password') }}" />
                <x-jet-input id="number" class="block mt-1 w-full" type="password" name="mobile_phone" :value="old('password')" required autofocus />
            </div> -->

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                    {{ __('Register ?') }}
                </a>
                <x-jet-button class="ml-4">
                    {{ __('Log in') }}
                </x-jet-button>
                
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
