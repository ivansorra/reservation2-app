<template>
    <div class="row justify-content-md-center">
        <div class="card" style="width: 40rem; margin-top: 150px">
            <div class="card-body">
                <img v-bind:src="'images/balesin_logo.png'" class="rounded-t-lg h-40 w-110 ml-auto mr-auto" alt="Image description" />

                <div class="text-center mb-3">
                    <h1 class="text-lg font-semibold">Balesin QR Form</h1>
                </div>

                <form @submit.prevent="reservationForm">
                    <div class="mb-3">
                        <select
                            v-model="userType"
                            @change="updateUserType"
                            class="form-select"
                            id="user_type"
                            name="user_type"
                        >
                            <option value="" disabled selected>
                                Please Select
                            </option>
                            <option value="member">Member</option>
                            <option value="spouse">Spouse</option>
                            <option value="dependent">Dependent</option>
                            <option value="guest">Guest</option>
                        </select>
                    </div>

                    <div v-if="userType === 'member'" class="mb-3">
                        <label for="member">Membership No:</label>
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="member"
                            placeholder="Please enter your Membership No."
                            required
                        />
                    </div>

                    <div v-if="userType === 'spouse'" class="mb-3">
                        <label for="member">Spouse Membership No:</label>
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="member"
                            placeholder="Please enter the Spouse Membership No."
                            required
                        />
                    </div>

                    <div v-if="userType === 'dependent'" class="mb-3">
                        <label for="dependent">Dependent Membership No:</label>
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="dependent"
                            placeholder="Please enter the Dependent Membership No."
                            required
                        />

                        <input type="hidden" v-model="validateDepedent">

                        <div v-if="validateDepedent === 'DESCENDANTS'" class="mt-3 mb-3 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">You're a descendant.</strong>&nbsp;
                            <span class="block sm:inline">Kindly proceed as guest to continue.</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
                            </span>
                        </div>
                    </div>

                    <div v-if="userType === 'guest'" class="mb-3">
                        <label for="sponsoring"
                            >Sponsoring Membership No:</label
                        >
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="sponsoring"
                            placeholder="Please enter the Membership No. of your Sponsoring Member"
                            required
                        />
                    </div>

                    <div v-if="responseMessage" class="mb-3">
                        <div class="bg-red-100 border border-red-500 text-red-700 px-4 py-2 rounded">
                            <strong>Error:</strong> {{ responseMessage }}
                        </div>
                    </div>

                    <div class="mb-3 d-flex justify-content-center">
                        <!-- <button type="submit" class="btn btn-primary">
                            Submit
                        </button> -->
                        <button
                            type="submit"
                            :disabled="isLoading"
                            class="relative flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:bg-gray-400"
                            >
                            <span v-if="!isLoading">Submit</span>
                            <svg v-if="isLoading" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 00-8 8H4z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import dayjs from 'dayjs';
import Swal from "sweetalert2";

export default {
    setup() {
        const userType = ref("");
        const membership_no = ref("");
        const primaryMemberID = ref("");
        const sponsoringMemberID = ref("");
        const validateDepedent = ref("");
        const responseMessage = ref("");
        const isLoading = ref(false);

        const router = useRouter();

        const reservationForm = async () => {
            const formData = {
                membership_no: membership_no.value,
                mem_type: userType.value
            };

            if (isLoading.value) return; // Prevent multiple submissions
            isLoading.value = true; // Start loading

            try {
                // const response = await axios.get('http://localhost:8000/api/members/show', {
                const response = await axios.get(`${import.meta.env.VITE_APP_URL}/api/members/show`, {
                    params: formData,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content, // Optional chaining to prevent errors
                    },
                });

                if (response.data) {
                    // console.log("Response Data:", response.data);
                    if (response.data.data && Object.keys(response.data.data).length > 0)
                    {

                        const userTypeVal = {};
                        // return response.data.data;
                        console.log(response.data.data)
                        response.data.data.birthdate = formatDateToMMDDYYYY(response.data.data.birthdate);
                        response.data.data.travel_id = response.data.data.travel_id;

                        switch(userType.value) {
                            case 'member':
                                sessionStorage.setItem('info', JSON.stringify(response.data.data));
                                router.push("/reservation_form");
                                break;
                            case 'spouse':
                                // userTypeVal['role_name'] = userType.value;
                                // userTypeVal['membership_id'] = response.data.data.membership_id;
                                sessionStorage.setItem('info', JSON.stringify(response.data.data));
                                router.push("/reservation_form");
                                break;
                            case 'dependent':
                                if(response.data.data.mem_type === "DESCENDANTS")
                                {
                                    validateDepedent.value = response.data.data.mem_type;
                                    console.log(response.data.message)
                                }
                                else {
                                    // userTypeVal['role_name'] = userType.value;
                                    // userTypeVal['membership_id'] = response.data.data.membership_id;
                                    // userTypeVal['membership_no'] = response.data.data.membership_no;

                                    // sessionStorage.setItem('info', JSON.stringify(userTypeVal));
                                    sessionStorage.setItem('info', JSON.stringify(response.data.data));
                                    router.push("/reservation_form");
                                }
                                break;
                            case 'guest':
                                userTypeVal['role_name'] = userType.value;
                                userTypeVal['membership_id'] = response.data.data.membership_id;
                                userTypeVal['membership_no'] = response.data.data.membership_no;
                                userTypeVal['member_name'] = response.data.data.member_name;
                                sessionStorage.setItem('info', JSON.stringify(userTypeVal));
                                router.push("/reservation_form");
                                break;
                            default:
                                console.warn("Unknown userType value:", userType.value);
                                break;
                        }
                    }
                }

            } catch (error) {
                if (error.response) {
                    // Server responded with a status code outside the 2xx range
                    console.error("Error Response Data:", error.response.data);
                    console.error("Error Response Status:", error.response.status);
                    console.error("Error Response Headers:", error.response.headers);

                    if (error.response.status === 503) {
                        // Swal.fire({
                        //     title: "Service Unavailable",
                        //     text: "There is a problem connecting to the server. Please contact the administrator.",
                        //     icon: "error",
                        //     confirmButtonText: "Close",
                        // });
                        responseMessage.value = "There is a problem connecting to the Intimus API Service. Please contact the administrator."
                    } else if (error.response.status === 500) {
                        // Swal.fire({
                        //     title: "Membership ID not found",
                        //     text: "An unexpected error occurred. Please contact the administrator.",
                        //     icon: "error",d
                        //     confirmButtonText: "Close"
                        // });
                        responseMessage.value = "Membership ID not found. Please contact the administrator."
                    } else {
                        // Swal.fire({
                        //     title: `Error ${error.response.status}`,
                        //     text: error.response.data?.message || "An unknown error occurred.",
                        //     icon: "error",
                        //     confirmButtonText: "Close",
                        // });
                        responseMessage.value = "An error occurred. Please try again later."
                    }
                } else if (error.request) {
                    // Request was made but no response received
                    console.error("Error Request:", error.request);
                    // Swal.fire({
                    //     title: "Network Error",
                    //     text: "No response from server. Please check your internet connection or try again later.",
                    //     icon: "error",
                    //     confirmButtonText: "Close",
                    // });
                    responseMessage.value = "No response from server. Please check your internet connection or try again later."
                } else {
                    // Something else went wrong
                    console.error("Error Message:", error.message);
                    // Swal.fire({
                    //     title: "Unexpected Error",
                    //     text: "An error occurred. Please try again later.",
                    //     icon: "error",
                    //     confirmButtonText: "Close",
                    // });
                    responseMessage.value = "An error occurred. Please try again later."
                }
            } finally {
                isLoading.value = false; // Ensure loading state resets
            }
        };

        const updateUserType = () => {
            // Reset input fields when userType changes
            membership_no.value = "";
            primaryMemberID.value = "";
            sponsoringMemberID.value = "";
        };

        const formatDateToMMDDYYYY = (dateString) => {
            const date = new Date(dateString);
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
            const day = String(date.getDate()).padStart(2, '0');
            const year = date.getFullYear();
            return `${month}-${day}-${year}`;
        };

        return {
            userType,
            membership_no,
            primaryMemberID,
            sponsoringMemberID,
            updateUserType,
            reservationForm,
            validateDepedent,
            responseMessage,
            isLoading
            // imageUrl
        };
    },
};
</script>

<style>

</style>
