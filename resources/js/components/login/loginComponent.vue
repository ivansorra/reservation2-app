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
                            v-model="primaryMemberID"
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
                            v-model="sponsoringMemberID"
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
import { ref } from "vue";
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
            // Prepare form data
            const formData = {
                membership_no: membership_no.value || null,
            };

            // On this line will insert the api call in Intimus
            try {
                const response = await axios.get('http://localhost:8000/api/members/show', {
                    params: formData,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                });

                if (response.data) {
                    if (response.data.data && Object.keys(response.data.data).length > 0) {
                        // console.log(userType)
                        if(userType.value === response.data.data.role_name)
                        {
                            console.log("same");
                            localStorage.setItem('memberInfo', JSON.stringify(response.data.data));
                        }

                        router.push("/reservation_form");
                    } else {
                        console.log(response.data.message);
                    }
                }

            } catch (error) {
                console.error("Error submitting form:", error);
            }
        };

        const updateUserType = () => {
            // Reset input fields when userType changes
            membership_no.value = "";
            primaryMemberID.value = "";
            sponsoringMemberID.value = "";
        };

        return {
            userType,
            membership_no,
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
