<template>
    <div class="row justify-content-md-center">
        <div class="card" style="width: 40rem; margin-top: 250px">
            <div class="card-body">
                <p style="text-align: center; font-weight: bold">
                    Welcome to Reservation App!
                </p>
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
                                Which type of user are you?
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
                            v-model="memberID"
                            class="form-control"
                            id="member"
                            placeholder="Membership ID"
                        />
                    </div>

                    <div v-if="userType === 'spouse'" class="mb-3">
                        <label for="member">Membership ID:</label>
                        <input
                            type="text"
                            v-model="memberID"
                            class="form-control"
                            id="member"
                            placeholder="Primary Membership ID"
                        />
                    </div>

                    <div v-if="userType === 'dependent'" class="mb-3">
                        <label for="dependent">Primary Membership ID:</label>
                        <input
                            type="text"
                            v-model="primaryMemberID"
                            class="form-control"
                            id="dependent"
                            placeholder="Primary Member ID"
                        />
                    </div>

                    <div v-if="userType === 'guest'" class="mb-3">
                        <label for="sponsoring"
                            >Sponsoring Membership ID:</label
                        >
                        <input
                            type="text"
                            v-model="sponsoringMemberID"
                            class="form-control"
                            id="sponsoring"
                            placeholder="Sponsoring Member ID"
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
import { ref } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    setup() {
        const userType = ref("");
        const memberID = ref("");
        const primaryMemberID = ref("");
        const sponsoringMemberID = ref("");
        const router = useRouter();

        const reservationForm = async () => {
            // Prepare form data
            const formData = {
                userType: userType.value,
                memberID: memberID.value || null,
                primaryMemberID: primaryMemberID.value || null,
                sponsoringMemberID: sponsoringMemberID.value || null,
            };

            // On this line will insert the api call in Intimus
            try {
                //   const response = await axios.post('/your-api-endpoint', formData, {
                //     headers: {
                //       'Content-Type': 'application/json',
                //       'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                //     },
                //   });

                //   console.log('Form submitted successfully:', response.data);

                router.push({ name: "form" });
            } catch (error) {
                console.error("Error submitting form:", error);
            }
        };

        const updateUserType = () => {
            // Reset input fields when userType changes
            memberID.value = "";
            primaryMemberID.value = "";
            sponsoringMemberID.value = "";
        };

        return {
            userType,
            memberID,
            primaryMemberID,
            sponsoringMemberID,
            updateUserType,
            reservationForm,
        };
    },
};
</script>

<style>
/* Customize the styles as needed */
</style>
