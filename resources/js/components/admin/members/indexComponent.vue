<template>
    <div>
        <button class="btn btn-primary">Add New Member</button>
        <div class="mt-4 relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="pb-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative mt-1">
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
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input
                                    id="checkbox-all-search"
                                    type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">Membership Number</th>
                        <!-- <th scope="col" class="px-6 py-3">Name</th> -->
                        <!-- <th scope="col" class="px-6 py-3">Address</th>
                        <th scope="col" class="px-6 py-3">Birth Date</th>
                        <th scope="col" class="px-6 py-3">Arrival Date</th>
                        <th scope="col" class="px-6 py-3">Return/Departure Date</th> -->
                        <th scope="col" class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(res, index) in members"
                        :key="index"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                />
                                <label class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ res.membership_no }}</td>
                        <!-- <td class="px-6 py-4">{{ res.name }}</td> -->
                        <!-- <td class="px-6 py-4">{{ res.address }}</td>
                        <td class="px-6 py-4">{{ res.birthDate }}</td>
                        <td class="px-6 py-4">{{ res.arrivalDate }}</td>
                        <td class="px-6 py-4">{{ res.returnDate }}</td> -->
                        <td class="px-6 py-4">{{ res.status }}</td>
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
    setup() {
        const members = ref([]); // Make members reactive to store fetched data

        const fetchMembers = async () => {
            try {
                const response = await axios.get("http://localhost:8000/api/members");

                if (response.data && response.data.data && response.data.data.data[0]) {
                    members.value.push(...response.data.data.data);
                    console.log("Fetched members data:", members.value);
                } else {
                    console.log("No members found.");
                }
            } catch (error) {
                console.error("Error fetching members data:", error);
            }
        };

        onMounted(() => {
            fetchMembers();
        });

        return {
            members,
        };
    },
};
</script>
