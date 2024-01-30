<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            
            @if (Route::has('login'))
            <div class="sm:fixed w-full justify-between sm:top-0 sm:right-0 flex p-6 z-10 border-b-[1px]">
                <div class="flex gap-4">
                

                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
            <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
            
            </div>
                    @auth
                    <div class="flex gap-4 text-white">
                        <p >Xin chào, {{ Auth::user()->name }}</p>
                        <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <a href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </a>
                        </form>
                        </div>
                    @else
                        <div>
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

@if (Route::has('register'))
    <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
@endif
                        </div>
                    @endauth
                </div>
            @endif