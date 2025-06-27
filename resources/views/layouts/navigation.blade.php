<div class="bg-gray-100 px-7 py-3 mx-2 md:px-10 md:mx-7">
    <div class="py-3 px-3 md:px-5 bg-white rounded-lg shadow-md flex justify-between items-center">
        <div class="flex items-center">
            <div class="text-sm md:text-base font-normal">
                @guest
                    Selamat datang, Guest <span class="waving-hand">👋</span>
                @endguest
                @auth
                    Hello <span class="font-medium">{{ auth()->user()->name }}</span> <span class="waving-hand">👋</span>
                @endauth
            </div>
        </div>
        <div>
            <ul class="flex items-center space-x-2 md:space-x-4">
                @guest
                    <li>
                        <a href="{{ route('login') }}"
                            class="text-xs md:text-sm text-gray-700 hover:bg-gray-100 px-3 py-2 rounded">Login</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                            class="text-xs md:text-sm text-gray-700 hover:bg-gray-100 px-3 py-2 rounded">Register</a>
                    </li>
                @endguest
                @auth
                    <li class="relative">
                        <button class="flex items-center p-0" id="userDropdown" data-dropdown-toggle="userDropdownMenu">
                            <div class="relative">
                                <img src="{{ asset('assets/img/avatars/free-user-icon-3296-thumb.png') }}" alt="User Avatar"
                                    class="w-8 h-8 md:w-10 md:h-10 rounded-full">
                                <span
                                    class="absolute bottom-0 right-0 block h-2 w-2 md:h-2.5 md:w-2.5 rounded-full bg-green-400 ring-2 ring-white"></span>
                            </div>
                        </button>
                        <div class="hidden absolute right-0 mt-2 w-48 md:w-56 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                            id="userDropdownMenu">
                            <div class="py-1">
                                <div class="px-3 md:px-4 py-2">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 mr-2 md:mr-3">
                                            <div class="relative">
                                                <img src="{{ asset('assets/img/avatars/free-user-icon-3296-thumb.png') }}"
                                                    alt="User Avatar" class="w-8 h-8 md:w-10 md:h-10 rounded-full">
                                                <span
                                                    class="absolute bottom-0 right-0 block h-2 w-2 md:h-2.5 md:w-2.5 rounded-full bg-green-400 ring-2 ring-white"></span>
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h6 class="text-xs md:text-sm font-medium text-gray-900 mb-0 truncate">
                                                {{ auth()->user()->name }}
                                            </h6>
                                            <small class="text-xs text-gray-500">{{ auth()->user()->role }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="border-t border-gray-100"></div>
                                <a class="flex items-center px-3 md:px-4 py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100"
                                    href="{{ route('profile.edit') }}">
                                    <i class="bx bx-user mr-2 text-sm"></i>
                                    <span>Profil Saya</span>
                                </a>
                                @if(auth()->user()->role == 'admin')
                                    <a class="flex items-center px-3 md:px-4 py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100"
                                        href="{{ route('admin.keluarga') }}">
                                        <i class="bx bx-group mr-2 text-sm"></i>
                                        <span>Data Keluarga</span>
                                    </a>
                                    <a class="flex items-center px-3 md:px-4 py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100"
                                        href="{{ route('admin.users') }}">
                                        <i class="bx bx-cog mr-2 text-sm"></i>
                                        <span>Data User</span>
                                    </a>
                                @elseif(auth()->user()->role == 'user')
                                    <a class="flex items-center px-3 md:px-4 py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100"
                                        href="{{ route('user.keluarga') }}">
                                        <i class="bx bx-group mr-2 text-sm"></i>
                                        <span>Data Keluarga</span>
                                    </a>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}" class="inline">
                                    @csrf
                                    <button type="submit"
                                        class="flex items-center w-full px-3 md:px-4 py-2 text-xs md:text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="bx bx-power-off mr-2 text-sm"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.getElementById('userDropdown');
        const dropdownMenu = document.getElementById('userDropdownMenu');

        if (dropdownButton && dropdownMenu) {
            dropdownButton.addEventListener('click', function (e) {
                e.preventDefault();
                dropdownMenu.classList.toggle('hidden');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // Close dropdown on window resize to prevent layout issues
            window.addEventListener('resize', function () {
                dropdownMenu.classList.add('hidden');
            });
        }
    });
</script>
<style>
    /* Logout button styling */
    .dropdown-menu button[type="submit"] {
        background: none;
        border: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
        font-family: inherit;
        font-size: inherit;
    }

    .dropdown-menu button[type="submit"]:hover {
        background-color: #f3f4f6;
    }
</style>