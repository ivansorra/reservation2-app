<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r">
            <div class="p-4 font-bold">Sidebar</div>
            <ul class="list-none">
                <router-link to="/admin/membership" class="block p-2 text-gray-700 hover:bg-gray-200">
                    Membership
                </router-link>
                <router-link
                    to="/about"
                    class="block p-2 text-gray-700 hover:bg-gray-200"
                >Reservations</router-link>

                <li class="relative">
                    <button
                        @click="toggleDropdown"
                        class="flex justify-between items-center w-full p-2 text-left text-gray-700 hover:bg-gray-200 focus:outline-none"
                    >
                        Services
                        <svg
                            :class="dropdownOpen ? 'transform rotate-180' : ''"
                            class="w-4 h-4 transition-transform duration-200"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M7 10l5 5 5-5H7z"
                            />
                        </svg>
                    </button>
                    <ul
                        v-if="dropdownOpen"
                        class="bg-gray-100 border-l border-b border-r mt-1"
                    >
                        <router-link
                            to="/services/service1"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Service 1</router-link>
                        <router-link
                            to="/services/service2"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Service 2</router-link>
                        <router-link
                            to="/services/service3"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Service 3</router-link>
                    </ul>
                </li>

                <router-link
                    to="/contact"
                    class="block p-2 text-gray-700 hover:bg-gray-200"
                >Settings</router-link>
            </ul>

            <!-- Logout Button -->
            <div class="p-4">
                <button
                    @click="logout"
                    class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                >
                    Logout
                </button>
            </div>
        </div>

        <div class="flex-1 p-6">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "sidebarComponent",
    data() {
        return {
            dropdownOpen: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.dropdownOpen = !this.dropdownOpen;
        },
        logout() {
            console.log("Logging out...");
        },
    },
};
</script>
