<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-slate-300">
                        <h2 class="mb-0"><b>Qr Code Reservation Form</b></h2>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="submitForm">
                            <!-- Email Address -->
                            <div class="row">
                                <!-- Email Address -->
                                <div class="col-md-3 mb-3">
                                    <label for="emailAddress" class="form-label">Email Address</label>
                                    <input
                                        type="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="emailAddress"
                                        placeholder="Email Address"
                                        aria-label="Email Address"
                                        v-model="emailAddress"
                                        :disabled="isDisabled"
                                        :style="{ backgroundColor: isDisabled ? '#d2d2d2' : 'white'}"
                                    />
                                </div>

                                <!-- Full Name -->
                                <div class="col-md-3 mb-3">
                                    <label for="fullName" class="form-label">Full Name</label>
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="fullName"
                                        placeholder="Full Name"
                                        aria-label="Full Name"
                                        v-model="fullName"
                                        :disabled="isDisabled"
                                        :style="{ backgroundColor: isDisabled ? '#d2d2d2' : 'white'}"
                                    />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="contactNumber" class="form-label">Contact Number</label>
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="contactNumber"
                                        placeholder="Contact Number"
                                        aria-label="Contact Number"
                                        v-model="contactNumber"
                                        :disabled="isDisabled"
                                        :style="{ backgroundColor: isDisabled ? '#d2d2d2' : 'white'}"
                                    />
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="address"
                                        placeholder="Address"
                                        aria-label="Address"
                                        v-model="address"
                                        :disabled="isDisabled"
                                        :style="{ backgroundColor: isDisabled ? '#d2d2d2' : 'white'}"
                                    />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="birthDate" class="form-label">Birth Date</label>
                                    <div class="position-relative">
                                        <div class="position-absolute inset-y-0 start-0 d-flex align-items-center ps-3">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                            </svg>
                                        </div>
                                        <input datepicker id="birthDate" type="text" class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date" v-model="birthDate" :disabled="isDisabled"
                                        :style="{ backgroundColor: isDisabled ? '#d2d2d2' : 'white'}" />
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="travelStart" class="form-label">Travel Date Start</label>
                                    <div class="relative">
                                        <!-- Date Input -->
                                        <input
                                            id="travelStart"
                                            type="date"
                                            class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            v-model="travelStart"
                                        />

                                        <!-- Floating Label -->
                                        <label
                                            for="travelStart"
                                            :class="[
                                            'absolute text-gray-400 text-sm left-3 transition-all duration-200 ease-in-out bg-gray-50 px-1 dark:bg-gray-700',
                                            travelStart ? 'top-[-10px] text-blue-500 text-xs' : 'top-2 text-gray-400 text-sm',
                                            ]"
                                        >
                                            Select a date
                                        </label>
                                    </div>
                                </div>


                                <div class="col-md-4 mb-3">
                                    <label for="travelend" class="form-label">Travel Date End</label>
                                    <div class="relative">
                                        <!-- Date Input -->
                                        <input
                                            id="travelEnd"
                                            type="date"
                                            class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            v-model="travelEnd"
                                        />

                                        <label
                                            for="travelEnd" :class="['absolute text-gray-400 text-sm left-3 transition-all duration-200 ease-in-out bg-gray-50 px-1 dark:bg-gray-700', travelEnd ? 'top-[-10px] text-blue-500 text-xs' : 'top-2 text-gray-400 text-sm',
                                            ]">Select a date
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 divider p-3">
                                <span>In Case of Emergency</span>

                                <div class="row mt-2">
                                    <div class="col-md-3 mb-3">
                                        <label for="emergencyName">Name</label>
                                        <input
                                            type="text"
                                            id="emergencyName"
                                            name="emergencyName"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            v-model="contactEmergencyName"
                                            required
                                        />
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="emergencyContact"
                                            >Contact Number</label
                                        >
                                        <input
                                            type="tel"
                                            id="emergencyContact"
                                            name="emergencyContact"
                                            v-model="contactEmergencyNumber"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        />
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="emergencyAddress"
                                            >Address</label
                                        >
                                        <input
                                            type="text"
                                            id="emergencyAddress"
                                            name="emergencyAddress"
                                            v-model="contactEmergencyAddress"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        />
                                    </div>

                                    <div class="col-md-3 mb-3">
                                        <label for="relationship"
                                            >Relationship</label
                                        >
                                        <select
                                            id="relationship"
                                            name="relationship"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
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

                            <div class="divider">
                                <h5 class="text-muted mb-3">
                                    Select where to send the QR Code
                                </h5>

                                <div class="form-check mb-3">
                                    <input
                                        type="checkbox"
                                        id="sameAsEmail"
                                        class="form-check-input"
                                        v-model="sameAsEmail"
                                    />
                                    <label
                                        for="sameAsEmail"
                                        class="form-check-label"
                                        >Same as Email Address</label
                                    >
                                </div>

                                <div class="form-check mb-3">
                                    <input
                                        type="checkbox"
                                        id="alternateAddress"
                                        class="form-check-input"
                                        v-model="isAlternateChecked"
                                    />
                                    <label
                                        for="alternateAddress"
                                        class="form-check-label"
                                    >
                                        Use other Email Address
                                    </label>
                                </div>

                                <div v-if="isAlternateChecked" class="mb-3">
                                    <label for="altEmailInput"
                                        >Alternate Email Address</label
                                    >
                                    <input
                                        type="email"
                                        id="altEmailInput"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        v-model="altEmail"
                                        placeholder="Enter alternate email address"
                                    />
                                </div>
                            </div>

                            <div class="form-check mt-3 mb-4">
                                <input
                                    type="checkbox"
                                    id="waiver"
                                    class="form-check-input"
                                    @change="showWaiverModal"
                                    required
                                />
                                <label for="waiver" class="form-check-label">
                                    I agree to the Release and Waiver of
                                    Liability
                                </label>
                            </div>

                            <div class="d-grid">
                                <button
                                    type="submit"
                                    class="bg-transparent hover:bg-blue-500 text-black-700 font-semibold hover:text-blue-900 py-2 px-4 border border-blue-500 hover:border-transparent rounded">
                                    Submit
                                </button>
                            </div>

                            <div
                                class="modal fade"
                                id="waiverModal"
                                tabindex="-1"
                                aria-labelledby="waiverModalLabel"
                                aria-hidden="true"
                                ref="waiverModal"
                            >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5
                                                class="modal-title"
                                                id="waiverModalLabel"
                                            >
                                                Release and Waiver of Liability
                                            </h5>
                                            <button
                                                type="button"
                                                class="btn-close"
                                                @click="closeModal"
                                                aria-label="Close"
                                            ></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                As a Member or Guest of Balesin Island Club (the “Club”), I understand
                                                and undertake to always comply with the relevant laws, rules, and
                                                regulations and Club Rules, including, but not limited to:
                                            </p>

                                            <ul>
                                                <li>Membership Rules</li>
                                                <li>House Rules</li>
                                            </ul>

                                            <p>
                                                I acknowledge that these rules may be amended by the Club at its sole
                                                discretion from time to time. As a Member, I represent and warrant that:
                                            </p>

                                            <ul>
                                                <li>I have neither leased nor sold my free villa nights and room entitlements, nor have I utilized these entitlements for a commercial purpose.</li>
                                                <li>My guests, if any, are bona fide, and I have not received any benefit or consideration from them directly or indirectly.</li>
                                            </ul>

                                            <p>
                                                I understand that violating these rules will result in my immediate
                                                expulsion as a Member of the Club.
                                            </p>

                                            <h6>Responsibility for Guests and Dependents</h6>
                                            <p>
                                                As a Member, I am responsible for the behavior of my guests and any
                                                unpaid costs of goods consumed or services rendered by the Club to my
                                                Dependents and Guests.
                                            </p>

                                            <h6>Intellectual Property Notice</h6>
                                            <p>
                                                "Balesin", "Balesin Island", "Balesin Island Club," and official Club
                                                images (from its website or social media posts) are the Intellectual
                                                Property of the Club. Unauthorized use of these items for any purpose
                                                is prohibited without explicit consent from the Club.
                                            </p>

                                            <h6>Assumption of Risk</h6>
                                            <p>
                                                I understand that participation in the trip to Balesin Island and the
                                                Club involves some risks, including risks related to air travel and
                                                transportation, which could lead to property damage, injury, or death.
                                            </p>

                                            <p>
                                                By signing this Release and Waiver of Liability, I hold Alphaland
                                                Corporations, Alphaland Balesin Island Resort Corporation, Alphaland
                                                Balesin Island Club, Inc., Alphaland Aviation, Inc., and their
                                                affiliates free and harmless from all liability for any injury, loss,
                                                or damage suffered at the Club or in transit to the Club.
                                            </p>

                                            <p>
                                                This Release and Waiver of Liability binds my family members, spouse,
                                                heirs, successors-in-interest, assigns, and personal representatives.
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button
                                                type="button"
                                                class="btn btn-secondary"
                                                @click="closeModal"
                                            >
                                                Close
                                            </button>
                                            <button
                                                type="button"
                                                class="btn btn-primary"
                                                @click="acceptWaiver"
                                            >
                                                Agree
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, ref, computed } from "vue";
import * as bootstrap from "bootstrap";
import { useRouter } from "vue-router";
import axios from "axios";
import Swal from 'sweetalert2';

export default {
    setup() {
        const sameAsEmail = ref(false);
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

        const syncAlternateEmail = () => {
            if (isAlternateChecked.value) {
                emailAddress.value = altEmail.value || "";
            } else {
                altEmail.value = "";
            }
        };

        const alternateChecked = (type) => {
            if (type === 'sameAsEmail') {
                if (sameAsEmail.value) {
                    isAlternateChecked.value = false;
                }
            } else if (type === 'isAlternateChecked') {
                if (isAlternateChecked.value) {
                    sameAsEmail.value = false;
                }
            }
        };

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
                    // alert('User created successfully!');
                    Swal.fire({
                        title: 'User Created',
                        text: 'User created successfully!',
                        icon: 'success',
                        confirmButtonText: 'Close',
                    })
                    sessionStorage.removeItem('info');
                    router.push('/login');
                } else {
                    console.error('Unexpected response:', userResponse);
                    // alert('Failed to create user. Please try again.');
                    Swal.fire({
                        title: 'Failed to Create User',
                        text: 'Failed to create user. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Close',
                    })
                }
            } catch (err) {
                console.error('Error submitting user data:', err);
                alert('Error creating user: ' + err.message);
            }
        }

        const isDisabled = computed(() => {
            return emailAddress.value !== '' && fullName.value !== '' && birthDate.value !== '' && contactNumber.value !== '' && address.value !== '';
        });

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
            submitForm,
            isDisabled,
            syncAlternateEmail,
            alternateChecked
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
