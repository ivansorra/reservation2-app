<template>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r">
            <div class="flex justify-center mt-4">
                <img v-bind:src="'../images/balesin_logo.png'" class="rounded-t-lg h-40 w-64" alt="Balesin Logo" />
            </div>
            <!-- <div class="p-2 font-bold text-center">Balesin Island Club QR Admin</div> -->
            <ul class="list-none">
                <li class="relative">
                    <button
                        @click="toggleMembersDropdown"
                        class="flex justify-between items-center w-full p-2 text-left text-gray-700 hover:bg-gray-200 focus:outline-none"
                    >
                        Membership
                        <svg
                            :class="membershipdropdownOpen ? 'transform rotate-180' : ''"
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
                        v-if="membershipdropdownOpen"
                        class="bg-gray-100 border-l border-b border-r mt-1"
                    >
                        <router-link
                            to="/admin/membership"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Manage Members</router-link>
                        <router-link
                            to="/admin/roles"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Manage Roles</router-link>
                    </ul>
                </li>

                <li class="relative">
                    <button
                        @click="toggleReservationsDropdown"
                        class="flex justify-between items-center w-full p-2 text-left text-gray-700 hover:bg-gray-200 focus:outline-none"
                    >
                        Reservations
                        <svg
                            :class="reservationDropdownOpen ? 'transform rotate-180' : ''"
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
                        v-if="reservationDropdownOpen"
                        class="bg-gray-100 border-l border-b border-r mt-1"
                    >
                        <router-link
                            to="/admin/membership"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Manage Reservations</router-link>
                        <router-link
                            to="/admin/travel_logs"
                            class="block p-2 text-gray-700 hover:bg-gray-200"
                        >Manage Activity</router-link>
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
            membershipdropdownOpen: false,
            reservationDropdownOpen: false,
        };
    },
    methods: {
        toggleMembersDropdown() {
            this.membershipdropdownOpen = !this.membershipdropdownOpen;
        },
        toggleReservationsDropdown() {
            this.reservationDropdownOpen = !this.reservationDropdownOpen;
        },
        logout() {
            console.log("Logging out...");
        },
    },
};
</script>
