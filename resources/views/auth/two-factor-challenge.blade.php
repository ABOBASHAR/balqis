<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        Enter the authentication code from your authenticator application.
    </div>

    <form method="POST" action="{{ route('two-factor.login') }}">
        @csrf

        <div>
            <x-input-label for="code" value="Authentication code" />
            <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" inputmode="numeric"
                autocomplete="one-time-code" autofocus />
            <x-input-error :messages="$errors->get('code')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="recovery_code" value="Recovery code" />
            <x-text-input id="recovery_code" class="block mt-1 w-full" type="text" name="recovery_code"
                autocomplete="one-time-code" />
            <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
