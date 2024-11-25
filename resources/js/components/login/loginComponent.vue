<template>
    <div class="row justify-content-md-center">
        <div class="card" style="width: 40rem; margin-top: 250px">
            <div class="card-body">
                <img v-bind:src="'images/balesinbanner.jpg'" class="rounded-t-lg" alt="Image description" />
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
                        <label for="member">Membership ID:</label>
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="member"
                            placeholder="Membership ID"
                            required
                        />
                    </div>

                    <div v-if="userType === 'spouse'" class="mb-3">
                        <label for="member">Membership ID:</label>
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="member"
                            placeholder="Primary Membership ID"
                            required
                        />
                    </div>

                    <div v-if="userType === 'dependent'" class="mb-3">
                        <label for="dependent">Primary Membership ID:</label>
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="dependent"
                            placeholder="Primary Member ID"
                            required
                        />
                    </div>

                    <div v-if="userType === 'guest'" class="mb-3">
                        <label for="sponsoring"
                            >Sponsoring Membership ID:</label
                        >
                        <input
                            type="text"
                            v-model="membership_no"
                            class="form-control"
                            id="sponsoring"
                            placeholder="Sponsoring Member ID"
                            required
                        />
                    </div>

                    <div class="mb-3 d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">
                            Submit
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

export default {
    setup() {
        const userType = ref("");
        const membership_no = ref("");
        const primaryMemberID = ref("");
        const sponsoringMemberID = ref("");
        const router = useRouter();

        const reservationForm = async () => {

            const formData = {
                membership_no: membership_no.value,
            };

            try {
                const response = await axios.get('http://localhost:8000/api/members/show', {
                    params: formData,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                if (response.data) {
                    console.log("Response Data:", response.data);
                    if (response.data.data && Object.keys(response.data.data).length > 0) {

                        const userTypeVal = {};

                        switch(userType.value) {
                            case 'member':
                                sessionStorage.setItem('info', JSON.stringify(response.data.data));
                                break;
                            case 'spouse':
                                userTypeVal['role_name'] = userType.value;
                                userTypeVal['membership_id'] = response.data.data.membership_id;
                                sessionStorage.setItem('info', JSON.stringify(userTypeVal));
                                break;
                            case 'dependent':
                                userTypeVal['role_name'] = userType.value;
                                userTypeVal['membership_id'] = response.data.data.membership_id;
                                sessionStorage.setItem('info', JSON.stringify(userTypeVal));
                                break;
                            case 'guest':
                                userTypeVal['role_name'] = userType.value;
                                userTypeVal['membership_id'] = response.data.data.membership_id;
                                sessionStorage.setItem('info', JSON.stringify(userTypeVal));
                                break;
                            default:
                                console.warn("Unknown userType value:", userType.value);
                                break;
                        }

                        router.push("/reservation_form");
                    } else {
                        alert("Membership ID does not exist");
                    }
                }
            } catch (error) {
                if (error.response) {
                    console.error("Error Response Data:", error.response.data);
                    console.error("Error Response Status:", error.response.status);
                    console.error("Error Response Headers:", error.response.headers);
                } else if (error.request) {
                    console.error("Error Request:", error.request);
                } else {
                    console.error("Error Message:", error.message);
                }
            }

        };

        const updateUserType = () => {
            // Reset input fields when userType changes
            membership_no.value = "";
            primaryMemberID.value = "";
            sponsoringMemberID.value = "";
        };

        // const imageUrl = computed(() => {
        //     return `http://localhost:8000/public/storage/images/balesinbanner.jpg`;
        // });

        return {
            userType,
            membership_no,
            primaryMemberID,
            sponsoringMemberID,
            updateUserType,
            reservationForm,
            // imageUrl
        };
    },
};
</script>

<style>
/* Customize the styles as needed */
</style>
