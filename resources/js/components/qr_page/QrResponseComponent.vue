<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <h1 class="text-2xl font-bold text-blue-600 mb-4">
                Tracking System
            </h1>
            <form @submit.prevent="submitForm">
                <div class="col-md-12 mb-3">
                    <label for="fullName" class="form-label"
                        >Full Name</label
                    >
                    <input
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="fullName"
                        placeholder="Full Name"
                        aria-label="Full Name"
                        v-model="fullName"
                        :disabled="isDisabled"
                        :style="{
                            backgroundColor: isDisabled
                                ? '#d2d2d2'
                                : 'white',
                        }"
                    />
                </div>

                <div class="col-md-12 mb-3">
                    <label for="emailAddress" class="form-label"
                        >Email Address:</label
                    >
                    <input
                        type="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="emailAddress"
                        placeholder="Email Address"
                        aria-label="Email Address"
                        v-model="emailAddress"
                        :disabled="isDisabled"
                        :style="{
                            backgroundColor: isDisabled
                                ? '#d2d2d2'
                                : 'white',
                        }"
                    />
                </div>

                <div class="col-md-12 mb-3">
                    <label for="contactNumber" class="form-label"
                        >Activity:</label
                    >
                    <select
                        v-model="activity"
                        class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="activity"
                        name="activity"
                    >
                        <option value="" disabled selected>
                            Please Select
                        </option>
                        <option value="flight_checkin">Flight Check-in</option>
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label for="address" class="form-label">Arrival Date:</label>
                    <input
                        type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="address"
                        placeholder="Address"
                        aria-label="Address"
                        v-model="arrivalDate"
                    />
                </div>

                <div class="col-md-12 mb-3">
                    <label for="contactNumber" class="form-label"
                        >Location:</label
                    >
                    <select
                        v-model="location"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        id="location"
                        name="location"
                    >
                        <option value="" disabled selected>
                            Please Select
                        </option>
                        <option value="member">Member</option>
                        <option value="spouse">Spouse</option>
                        <option value="dependent">Dependent</option>
                    </select>
                </div>

                <div class="d-grid">
                    <button
                        type="submit"
                        class="bg-transparent hover:bg-blue-500 text-black-700 font-semibold hover:text-blue-900 py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    name: "qrResponseComponent",
    setup() {
        const emailAddress = ref("");
        const fullName = ref("");
        const arrivalDate = ref("");
        const location = ref("");

        const router = useRouter();

        const isDisabled = computed(() => {
            return emailAddress.value !== '' && fullName.value !== '' && arrivalDate.value !== '' && location.value !== '';
        });

        const submitForm = async () => {

        }

        return {
            isDisabled
        }
    },
};
</script>
