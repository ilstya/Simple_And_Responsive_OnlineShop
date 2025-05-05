<!-- resources/views/layouts/navigation.blade.php -->
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- …menu kiri… -->

    <!-- Settings Dropdown -->
    <div class="hidden sm:flex sm:items-center sm:ml-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <!-- tombol pemicu dropdown -->
            </x-slot>

            <x-slot name="content">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-dropdown-link
                        :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();"
                    >
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>

    <!-- …menu responsif… -->
</nav>
