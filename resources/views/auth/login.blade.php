<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label class="text-sm font-medium" for="email">E-mail</label>
            <input id="email" label="Email" name="email" class="w-full border rounded border-zinc-400 p-1"/>
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label class="text-sm font-medium" for="password">Password</label>
            <input id="password" type="password" label="Password" name="password" class="w-full border rounded border-zinc-400 p-1"/>
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="link" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <button class="btn btn-primary ml-3">
                {{ __('Log in') }}
            </button>
        </div>
    </form>
</x-guest-layout>
