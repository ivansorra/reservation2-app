<template>
    <!-- Modal Overlay -->
    <div class="fixed inset-0 bg-gray-800 bg-opacity-50 z-50 flex items-center justify-center">
        <!-- Modal Container -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg w-96">
            <!-- Modal Header -->
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Add New Role
                </h3>
                <button
                    @click="closeModal"
                    class="text-gray-500 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white"
                    aria-label="Close Modal"
                >
                    <svg
                        class="w-5 h-5"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <form @submit.prevent="submitRole">
                <div class="mb-4">
                    <label
                        for="roleName"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                    >
                        Role Name
                    </label>
                    <input
                        id="roleName"
                        v-model="roleName"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        placeholder="Enter role name"
                        type="text"
                    />
                </div>

                <button
                    @click="saveRole"
                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                >
                    Save
                </button>
            </form>

            <!-- Modal Footer -->
            <div class="flex justify-end space-x-4">
                <button
                    @click="closeModal"
                    class="bg-gray-300 text-gray-900 px-4 py-2 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400"
                >
                    Close
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import Swal from 'sweetalert2';

export default {
    name: "AddRoleComponent",
    setup(props, { emit }) {
        const roleName = ref("");

        // Emit close event to the parent component
        const closeModal = () => {
            roleName.value = ""; // Reset the input field when closing
            emit("close");
        };

        // Submit the form data
        const submitRole = async () => {
            if (roleName.value.trim() === "") {
                alert("Role name cannot be empty.");
                return;
            }

            try {
                const response = await axios.post(
                    "http://localhost:8000/api/roles/create",
                    { role_name: roleName.value, status: "active" },
                    {
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                    }
                );

                roleName.value = "";
                emit("save", response.data);
                closeModal();
                Swal.fire({
                    title: 'User Role Created',
                    text: 'User Role Created Successfully!',
                    icon: 'success',
                    confirmButtonText: 'Close',
                })
            } catch (error) {
                console.error("Error saving role:", error);
                Swal.fire({
                    title: 'Failed to save role',
                    text: 'Failed to save the role. Please try again.',
                    icon: 'success',
                    confirmButtonText: 'Close',
                });
            }
        };

        return {
            roleName,
            closeModal,
            submitRole,
        };
    },
};
</script>
