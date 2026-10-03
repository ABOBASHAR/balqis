<x-guest-layout>
    <div x-data="{ recovery: {{ $errors->has('recovery_code') ? 'true' : 'false' }} }" class="-mx-6 -my-4 overflow-hidden sm:rounded-lg">
        <div class="relative overflow-hidden bg-slate-900 px-6 py-8 text-white sm:px-10">
            <div class="absolute -right-16 -top-20 h-48 w-48 rounded-full bg-cyan-400/20 blur-3xl"></div>
            <div class="absolute -bottom-24 left-16 h-40 w-40 rounded-full bg-indigo-400/20 blur-3xl"></div>

            <div class="relative flex items-start gap-4">
                <div
                    class="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-white/10 ring-1 ring-white/20">
                    <svg class="h-6 w-6 text-cyan-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V7a4.5 4.5 0 0 0-9 0v3.5m-1.5 0h12a1.5 1.5 0 0 1 1.5 1.5v7A1.5 1.5 0 0 1 18 20.5H6A1.5 1.5 0 0 1 4.5 19v-7A1.5 1.5 0 0 1 6 10.5Z" />
                        <path stroke-linecap="round" d="M12 14v2" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-cyan-300">Secure sign in</p>
                    <h1 class="mt-2 text-2xl font-semibold tracking-tight">Two-step verification</h1>
                    <p class="mt-2 max-w-sm text-sm leading-6 text-slate-300">One more step keeps your account
                        protected.</p>
                </div>
            </div>
        </div>

        <div class="bg-white px-6 py-7 sm:px-10 sm:py-8">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-900">Verify your identity</h2>
                <p class="mt-1 text-sm leading-6 text-slate-500"
                    x-text="recovery ? 'Use one of your saved recovery codes.' : 'Enter the 6-digit code from your authenticator app.'">
                </p>
            </div>

            <form method="POST" action="{{ route('two-factor.login') }}" class="space-y-5">
                @csrf

                <div x-show="!recovery" x-cloak>
                    <x-input-label for="code" value="Authentication code" class="mb-2 text-sm text-slate-700" />
                    <x-text-input id="code"
                        class="block w-full rounded-xl border-slate-200 px-4 py-3 text-center text-lg tracking-[0.35em] shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        type="text" name="code" inputmode="numeric" autocomplete="one-time-code" autofocus
                        placeholder="000000" maxlength="6" />
                    <x-input-error :messages="$errors->get('code')" class="mt-2" />
                </div>

                <div x-show="recovery" x-cloak>
                    <x-input-label for="recovery_code" value="Recovery code" class="mb-2 text-sm text-slate-700" />
                    <x-text-input id="recovery_code"
                        class="block w-full rounded-xl border-slate-200 px-4 py-3 shadow-sm focus:border-cyan-500 focus:ring-cyan-500"
                        type="text" name="recovery_code" autocomplete="one-time-code"
                        placeholder="Enter your recovery code" />
                    <x-input-error :messages="$errors->get('recovery_code')" class="mt-2" />
                </div>

                <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-cyan-500 focus:ring-offset-2">
                    {{ __('Log in') }}
                    <svg class="ms-2 h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </button>
            </form>

            <button type="button" @click=" recovery = !recovery "
                class="mt-5 w-full text-center text-sm font-medium text-cyan-700 transition hover:text-cyan-900 focus:outline-none focus:underline">
                <span x-text="recovery ? 'Use authenticator code instead' : 'Use a recovery code instead'"></span>
            </button>
        </div>
    </div>
</x-guest-layout>
