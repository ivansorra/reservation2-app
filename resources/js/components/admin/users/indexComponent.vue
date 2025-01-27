<template>
    <div>
        <button class="btn btn-primary">Add New Member</button>
        <div class="mt-4 relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="pb-4 bg-white dark:bg-gray-900 flex items-center">
                <div class="relative ml-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Arrival Date -->
                        <div class="w-full flex items-center gap-2">
                            <!-- Label -->
                            <label for="dateFrom" class="whitespace-nowrap font-medium text-gray-700">
                                Date From:
                            </label>
                            <input
                                id="dateFrom"
                                type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 flex-1"
                                v-model="dateFrom"
                                required
                            />
                        </div>

                        <!-- Departure Date -->
                        <div class="w-full flex items-center gap-2">
                            <!-- Label -->
                            <label for="dateTo" class="whitespace-nowrap font-medium text-gray-700">
                                Date To:
                            </label>
                            <input
                                id="dateTo"
                                type="date"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 flex-1"
                                v-model="dateTo"
                                required
                            />
                        </div>
                    </div>
                </div>

                <div class="relative ml-3">
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg
                            class="w-4 h-4 text-gray-500 dark:text-gray-400"
                            aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 20 20"
                        >
                            <path
                                stroke="currentColor"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                            />
                        </svg>
                    </div>
                    <input
                        type="text"
                        id="table-search"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for items"
                    />
                </div>

                <div class="relative ml-4">
                    <button
                        @click="toggleSorting"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button"
                    >
                        <span class="sr-only"></span>
                        Sort By
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>

                    <div
                        v-if="isSortingOpen"
                        class="absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                    >
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Latest</a>
                        </div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Oldest</a>
                        </div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Ascending</a>
                        </div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Descending</a>
                        </div>
                    </div>
                </div>
                <div class="relative ml-3">
                    <button
                        @click="toggleDropdown"
                        class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                        type="button"
                    >
                        <span class="sr-only">Action button</span>
                        Export Data
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>

                    <div
                        v-if="isDropdownOpen"
                        class="absolute z-10 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600"
                    >
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export as PDF</a>
                        </div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export as XLSX</a>
                        </div>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Export as Email</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <!-- Table Head -->
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Complete Name</th>
                        <th scope="col" class="px-6 py-3">Email Address</th>
                        <th scope="col" class="px-6 py-3">Birth Date</th>
                        <th scope="col" class="px-6 py-3">Arrival Date</th>
                        <th scope="col" class="px-6 py-3">Departure Date</th>
                        <th scope="col" class="px-6 py-3">QR Code</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    <tr
                        v-for="(res, index) in users"
                        :key="index"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <!-- <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <label class="sr-only">checkbox</label>
                            </div>
                        </td> -->

                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{  res.user_info.name }}
                        </td>
                        <td class="px-6 py-4">{{ res.user_info.email_address }}</td>
                        <td class="px-6 py-4">{{ new Date(res.user_info.birthdate).toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" })}}</td>
                        <td class="px-6 py-4">{{ Array.isArray(res.travel_info) ? res.travel_info.map(flight => flight.arrival_date).join("") : null }}</td>
                        <td class="px-6 py-4">{{ Array.isArray(res.travel_info) ? res.travel_info.map(flight => flight.return_date).join("") : null }}</td>
                        <td class="px-6 py-4">
                            <img v-bind:src="res.qr_url" alt="">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    name: "indexComponent",
    data() {
        return {
            isDropdownOpen: false,
            isSortingOpen: false,
        };
    },
    methods: {
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        toggleSorting() {
            this.isSortingOpen = !this.isSortingOpen;
        }
    },
    setup() {
        const users = ref([]);
        const fetchUsersQr = async () => {
            try {
                const response = await axios.get(`${import.meta.env.VITE_APP_URL}/api/qr`);

                if (response.data && response.data.data && response.data.data.data[0]) {
                    console.log('response', response.data.data.data)
                    // users.value.push(...response.data.data.data);
                    users.value = response.data.data.data.map(user => ({
                        qr_url: user.qr_url,
                        user_info: typeof user.qr_content === "string" ? JSON.parse(user.qr_content) : user.qr_content,
                        travel_info: Array.isArray(user.travel) ? user.travel.map(travel => travel) : []
                    }));
                    console.log("Fetched users qr code data:", users.value);
                } else {
                    console.log("No users qr code found.");
                }
            } catch (error) {
                console.error("Error fetching users:", error);
            }
        }

        onMounted(() => {
            fetchUsersQr();
        });

        return {
            users
        }
    },
};
</script>
