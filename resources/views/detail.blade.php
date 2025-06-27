<x-app-layout>
    <div class="bg-gray-100 px-7 mx-2 md:px-10 md:mx-7">
        <div class="bg-white shadow-md rounded-lg p-6 mb-3">
            <ul class="flex text-sm font-medium text-center text-gray-500 dark:text-gray-400">
                <li class="flex-1">
                    <a href="#"
                        class="block w-full px-4 py-2 text-base md:text-md rounded-lg bg-blue-600 text-white flex items-center justify-center"
                        aria-current="page">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-person-fill md:hidden" viewBox="0 0 16 16">
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg>
                        <span class="hidden md:inline">Anggota Keluarga</span>
                    </a>
                </li>
                <li class="flex-1 ml-2">
                    <a href="#"
                        class="block w-full px-4 py-2 text-base md:text-md rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-diagram-3 md:hidden" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M6 3.5A1.5 1.5 0 0 1 7.5 2h1A1.5 1.5 0 0 1 10 3.5v1A1.5 1.5 0 0 1 8.5 6v1H14a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H8.5v1a1.5 1.5 0 0 1-1.5 1.5h-1A1.5 1.5 0 0 1 4 11.5v-1A1.5 1.5 0 0 1 5.5 9H2a.5.5 0 0 1-.5-.5v-1A.5.5 0 0 1 2 7h3.5A1.5 1.5 0 0 1 7 5.5v-1zM4.5 4a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1zM6 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1A.5.5 0 0 0 7 8H6z" />
                        </svg>
                        <span class="hidden md:inline">Pohon Keluarga</span>
                    </a>
                </li>
                <li class="flex-1 ml-2">
                    <a href="#"
                        class="block w-full px-4 py-2 text-base md:text-md rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-link-45deg md:hidden" viewBox="0 0 16 16">
                            <path
                                d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                            <path
                                d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                        </svg>
                        <span class="hidden md:inline">Hubungan keluarga</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 mb-3">
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center">
                Tambah
            </button>
            <div class="mt-3">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                            aria-selected="true">Home</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                            data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                            aria-selected="false">Profile</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                            data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane"
                            aria-selected="false">Contact</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="disabled-tab" data-bs-toggle="tab"
                            data-bs-target="#disabled-tab-pane" type="button" role="tab"
                            aria-controls="disabled-tab-pane" aria-selected="false" disabled>Disabled</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                        tabindex="0">Tab 1</div>
                    <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                        tabindex="0">Tab 2</div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>