<template>
    <div class="pb-3 bg-white dark:bg-gray-900 flex items-center">
        <div class="relative mt-1">
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
    <div>
        <table
            class="w-full text-sm text-left text-gray-500 border border-black-sol dark:text-gray-400"
        >
            <thead
                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
            >
                <tr>
                    <th scope="col" class="px-6 py-3">User Name</th>
                    <th scope="col" class="px-6 py-3">Activity Name</th>
                    <th scope="col" class="px-6 py-3">Membership Type</th>
                    <th scope="col" class="px-6 py-3">Reservation Date</th>
                    <th scope="col" class="px-6 py-3">Location</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(activity, index) in activities.data"
                    :key="activity.id"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                >
                    <td class="px-6 py-4">{{ activity.user.name }}</td>
                    <td class="px-6 py-4">{{ activity.activity_name }}</td>
                    <td class="px-6 py-4">{{ activity.role.role_name.charAt(0).toUpperCase() + activity.role.role_name.slice(1) }}</td>
                    <td class="px-6 py-4">{{ formatDate(activity.travel.arrival_date) }} - {{ formatDate(activity.travel.return_date) }}</td>
                    <td class="px-6 py-4">{{ activity.location }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    name: "activityComponent",
    setup() {
        const activities = ref([]);

        const getAllTravelActivities = async () => {
            try {
                const response = await axios.get(
                    `${import.meta.env.VITE_APP_URL}/api/travel_activity/`
                );
                if (response.data?.data) {
                    console.log(response.data); // Debugging the response
                    activities.value = response.data.data; // Assuming the activities are under the 'data' key
                }
            } catch (e) {
                console.error("Error fetching activities:", e);
            }
        };

        const formatDate = (date) => {
            return new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',  // Numeric year
                month: 'long',     // Long month name (e.g., January)
                day: 'numeric',    // Numeric day (e.g., 1)
            });
        };

        onMounted(() => {
            getAllTravelActivities();
        });

        return {
            activities,
            formatDate
        };
    },
};
</script>
