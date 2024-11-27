<template>
    <div class="p-6">
        <!-- Trigger Button to Open Add Modal -->
        <button
            @click="openAddModal"
            class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200"
        >
            Add New Role
        </button>

        <!-- Main Container for Table -->
        <div
            class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900 p-6 mt-6"
        >
            <!-- Table -->
            <table
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3">Role Name</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(role, index) in roles"
                        :key="index"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                    >
                        <td class="px-6 py-4">{{ role.role_name }}</td>
                        <td class="px-6 py-4">{{ role.status }}</td>
                        <td
                            class="px-6 py-4 text-blue-600 hover:text-blue-800 cursor-pointer"
                        >
                            <button
                                @click="openEditModal(role)"
                                class="hover:underline px-3"
                            >
                                Edit
                            </button>
                            <button
                                @click="deleteRole(role)"
                                class="hover:underline px-3"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Add Role Modal Component -->
        <addRoleComponent v-if="isAddModalOpen" @close="closeAddModal" />

        <!-- Edit Role Modal Component -->
        <EditRoleComponent
            v-if="isEditModalOpen"
            :initial-role-name="selectedRole?.role_name || ''"
            :initial-user-role-status="selectedRole?.status || ''"
            @close="closeEditModal"
            @save="updateRole"
        />
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
import addRoleComponent from "./addRoleComponent.vue";
import EditRoleComponent from "./editRoleComponent.vue";

export default {
    name: "rolesComponent",
    components: {
        addRoleComponent,
        EditRoleComponent,
    },
    setup() {
        const isAddModalOpen = ref(false);
        const isEditModalOpen = ref(false);
        const selectedRole = ref(null);
        const roles = ref([]);

        const fetchRoles = async () => {
            try {
                const response = await axios.get(
                    "http://localhost:8000/api/roles"
                );
                if (response.data?.data?.data) {
                    roles.value = response.data.data.data;
                }
            } catch (error) {
                console.error("Error fetching roles:", error);
            }
        };

        const openAddModal = () => {
            isAddModalOpen.value = true;
        };

        const closeAddModal = () => {
            isAddModalOpen.value = false;
        };

        const openEditModal = (role) => {
            selectedRole.value = role; // Set the selected role for editing
            isEditModalOpen.value = true;
        };

        const closeEditModal = () => {
            isEditModalOpen.value = false;
            selectedRole.value = null; // Reset selected role
        };

        const updateRole = (updatedRole) => {
            // Update the roles list locally
            const index = roles.value.findIndex(
                (role) => role.id === updatedRole.id
            );
            if (index !== -1) {
                roles.value[index] = updatedRole;
            }
            closeEditModal();
        };

        const deleteRole = async (role) => {
            try {
                await axios.delete(`http://localhost:8000/api/roles/${role.id}`);
                roles.value = roles.value.filter((r) => r.id !== role.id);
            } catch (error) {
                console.error("Error deleting role:", error);
            }
        };

        onMounted(() => {
            fetchRoles();
        });

        return {
            isAddModalOpen,
            isEditModalOpen,
            roles,
            selectedRole,
            openAddModal,
            closeAddModal,
            openEditModal,
            closeEditModal,
            updateRole,
            deleteRole,
        };
    },
};
</script>

<style scoped>
/* Optional scoped styles */
</style>
