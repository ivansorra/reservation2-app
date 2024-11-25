<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h2 class="mb-0"><b>Qr Code Reservation Form</b></h2>
                    </div>
                    <div class="card-body p-3">
                        <form @submit.prevent="submitForm">
                            <div class="row">
                                <!-- Email Address -->
                                <div class="col-md-3 mb-3">
                                    <label for="emailAddress" class="form-label">Email Address</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="emailAddress"
                                        placeholder="Email Address"
                                        aria-label="Email Address"
                                        v-model="emailAddress"
                                    />
                                </div>

                                <!-- Full Name -->
                                <div class="col-md-3 mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="fullName"
                                        placeholder="Full Name"
                                        aria-label="Full Name"
                                        v-model="fullName"
                                    />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="contactNumber" class="form-label">Contact Number</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="contactNumber"
                                        placeholder="Contact Number"
                                        aria-label="Contact Number"
                                        v-model="contactNumber"
                                    />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="address"
                                        placeholder="Address"
                                        aria-label="Address"
                                        v-model="address"
                                    />
                                </div>
                            </div>
                            <!-- Birth Date -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="birthDate" class="form-label">Birth Date</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="birthDate"
                                        v-model="birthDate"
                                    />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="travelstart" class="form-label">Travel Date Start</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="travelstart"
                                        v-model="travelStart"
                                    />
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="travelend" class="form-label">Travel Date End</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="travelend"
                                        v-model="travelEnd"
                                    />
                                </div>
                            </div>

                            <!-- Travel Dates -->
                            <div class="row">

                            </div>

                            <!-- Emergency Contact Section -->
                            <div class="divider mb-4">
                                <h5>In Case of Emergency</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="emergencyName" class="form-label">Emergency Name</label>
                                        <input
                                            type="text"
                                            id="emergencyName"
                                            name="emergencyName"
                                            class="form-control"
                                            v-model="contactEmergencyName"
                                            required
                                        />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="emergencyContact" class="form-label">Emergency Contact Number</label>
                                        <input
                                            type="tel"
                                            id="emergencyContact"
                                            name="emergencyContact"
                                            class="form-control"
                                            v-model="contactEmergencyNumber"
                                        />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="emergencyAddress" class="form-label">Emergency Address</label>
                                        <input
                                            type="text"
                                            id="emergencyAddress"
                                            name="emergencyAddress"
                                            class="form-control"
                                            v-model="contactEmergencyAddress"
                                        />
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="relationship" class="form-label">Relationship</label>
                                        <select
                                            id="relationship"
                                            name="relationship"
                                            class="form-control"
                                            v-model="contactEmergencyRelationship"
                                        >
                                            <option value="">Select</option>
                                            <option value="father">Father</option>
                                            <option value="mother">Mother</option>
                                            <option value="brother">Brother</option>
                                            <option value="sister">Sister</option>
                                            <option value="spouse">Spouse</option>
                                            <option value="others">Others</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- QR Code Section -->
                            <div class="divider mb-4">
                                <h5>Select where to send the QR Code</h5>
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        id="sameAsEmail"
                                        class="form-check-input"
                                    />
                                    <label for="sameAsEmail" class="form-check-label">
                                        Same as Email Address
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        id="alternateAddress"
                                        class="form-check-input"
                                        v-model="isAlternateChecked"
                                    />
                                    <label for="alternateAddress" class="form-check-label">
                                        Use other Email Address
                                    </label>
                                </div>
                                <div v-if="isAlternateChecked" class="mt-3">
                                    <label for="altEmailInput" class="form-label">Alternate Email Address</label>
                                    <input
                                        type="email"
                                        id="altEmailInput"
                                        class="form-control"
                                        v-model="altEmail"
                                        placeholder="Enter alternate email address"
                                    />
                                </div>
                            </div>

                            <!-- Waiver Agreement -->
                            <div class="form-check mt-3 mb-4">
                                <input
                                    type="checkbox"
                                    id="waiver"
                                    class="form-check-input"
                                    @change="showWaiverModal"
                                    required
                                />
                                <label for="waiver" class="form-check-label">
                                    I agree to the Release and Waiver of Liability
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref } from "vue";
import * as bootstrap from "bootstrap";
import { useRouter } from "vue-router";
import axios from "axios";

export default {
    setup() {
        const isAlternateChecked = ref(false);
        const altEmail = ref("");

        const waiverModal = ref(null);
        const isCheckboxChecked = ref(false);

        // This below block is for auto-populating fields in form
        const emailAddress = ref("");
        const fullName = ref("");
        const emailAdd = ref("");
        const contactNumber = ref("");
        const birthDate = ref("");
        const address = ref("");
        const travelStart = ref("");
        const travelEnd = ref("");
        const contactEmergencyName = ref("");
        const contactEmergencyNumber = ref("");
        const contactEmergencyAddress = ref("");
        const contactEmergencyRelationship = ref("");

        const router = useRouter();

        const infoDetails = JSON.parse(sessionStorage.getItem('info'));

        const autoFillForm = () => {
            if(infoDetails) {
                emailAddress.value = infoDetails.email_address;
                fullName.value = infoDetails.member_name;
                contactNumber.value = infoDetails.contact_no;
                birthDate.value = infoDetails.birthdate;
                address.value = infoDetails.member_address;
            }
        }

        const showWaiverModal = (event) => {
            isCheckboxChecked.value = event.target.checked;
            if (isCheckboxChecked.value) {
                waiverModal.value.show();
            }
        };

        const closeModal = () => {
            isCheckboxChecked.value = false;
            waiverModal.value.hide();
        };

        const acceptWaiver = () => {
            closeModal();
            document.getElementById("waiver").checked = true;
        };

        const submitForm = async () => {
            const userData = {
                membership_id: infoDetails ? infoDetails.membership_id : null,
                name: fullName.value || null,
                email_address: emailAddress.value || null,
                address: address.value || null,
                contact_no: contactNumber.value || null,
                birthdate: birthDate.value || null,
                user_status: 1,
                arrival_date: travelStart.value || null,
                return_date: travelEnd.value || null,
                emergency_contact_name: contactEmergencyName.value || null,
                emergency_contact_no: contactEmergencyNumber.value || null,
                emergency_contact_address: contactEmergencyAddress.value || null,
                relationship: contactEmergencyRelationship.value || null,
            }

            if (infoDetails) {
                const userRole = infoDetails.role_name;

                try {
                    const response = await axios.get('http://localhost:8000/api/roles/show', {
                        params: {
                            role_name: userRole,
                        },
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        }
                    });

                    if (response.data && response.data.data) {
                        if (Object.keys(response.data.data).length > 0) {
                            userData['role_id'] = response.data.data.role_id;
                            userData['user_role_status'] = response.data.data.status;
                        }
                    }
                } catch (error) {
                    console.error('Error fetching role:', error);
                    alert('Error fetching role: ' + error.message);
                    return;
                }
            }

            try {
                const userResponse = await axios.post('http://localhost:8000/api/users/create', userData, {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    }
                });

                if (userResponse.status === 200) {
                    alert('User created successfully!');
                    sessionStorage.removeItem('info');
                    router.push('/login');
                } else {
                    console.error('Unexpected response:', userResponse);
                    alert('Failed to create user. Please try again.');
                }
            } catch (err) {
                console.error('Error submitting user data:', err);
                alert('Error creating user: ' + err.message);
            }

        }

        onMounted(() => {
            waiverModal.value = new bootstrap.Modal(
                document.getElementById("waiverModal")
            );
            autoFillForm();
        });

        return {
            emailAddress,
            fullName,
            emailAdd,
            contactNumber,
            birthDate,
            address,
            travelStart,
            travelEnd,
            contactEmergencyName,
            contactEmergencyNumber,
            contactEmergencyAddress,
            contactEmergencyRelationship,
            showWaiverModal,
            acceptWaiver,
            closeModal,
            isAlternateChecked,
            altEmail,
            autoFillForm,
            submitForm
        };
    },
};
</script>

<style>
    ul {
        list-style-type: disc;
        padding-left: 20px;
    }
</style>
