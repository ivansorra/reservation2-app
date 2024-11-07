<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center bg-primary text-white">
                        <h2 class="mb-0"><b>Reservation Form</b></h2>
                    </div>
                    <div class="card-body p-4">
                        <form @submit.prevent="submitForm">
                            <!-- Email Address -->
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"
                                    ><i class="bx bx-envelope"></i
                                ></span>
                                <input
                                    type="email"
                                    class="form-control"
                                    placeholder="Email Address"
                                    aria-label="Email Address"
                                    v-model="emailAddress"
                                />
                            </div>

                            <!-- First and Last Name Fields -->
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"
                                    ><i class="bx bx-id-card"></i
                                ></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Name"
                                    aria-label="Name"
                                    v-model="fullName"
                                />
                            </div>
                            <!-- <div class="input-group mb-3">
                                <span class="input-group-text bg-light"
                                    ><i class="bx bx-id-card"></i
                                ></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Last Name"
                                    aria-label="Last Name"
                                />
                            </div> -->

                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"
                                    ><i class="bx bx-mobile"></i
                                ></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Contact Number"
                                    aria-label="Contact Number"
                                    v-model="contactNumber"
                                />
                            </div>

                            <!-- Address Field -->
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"
                                    ><i class="bx bx-book"></i
                                ></span>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Address"
                                    aria-label="Address"
                                    v-model="address"
                                />
                            </div>

                            <!-- Birth Date Field -->
                            <div class="input-group mb-3">
                                <span class="input-group-text bg-light"
                                    ><i class="bx bx-cake"></i
                                ></span>
                                <input
                                    type="date"
                                    class="form-control"
                                    placeholder="Birth Date"
                                    aria-label="Birth Date"
                                    v-model="birthDate"
                                />
                            </div>

                            <!-- Travel Date -->
                            <div class="mb-3">
                                <span>Travel Date Start:</span>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="travelstart"
                                    v-model="travelStart"
                                />
                            </div>

                            <!-- Travel Date -->
                            <div class="mb-3">
                                <span>Travel Date End:</span>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="travelend"
                                    v-model="travelEnd"
                                />
                            </div>

                            <!-- Emergency Contact Section -->
                            <div class="divider">
                                <span>In Case of Emergency</span>

                                <div class="form-group mb-3">
                                    <label for="emergencyName">Name</label>
                                    <input
                                        type="text"
                                        id="emergencyName"
                                        name="emergencyName"
                                        class="form-control"
                                        v-model="contactEmergencyName"
                                        required
                                    />
                                </div>

                                <div class="form-group mb-3">
                                    <label for="emergencyContact"
                                        >Contact Number</label
                                    >
                                    <input
                                        type="tel"
                                        id="emergencyContact"
                                        name="emergencyContact"
                                        v-model="contactEmergencyNumber"
                                        class="form-control"
                                    />
                                </div>

                                <div class="form-group mb-3">
                                    <label for="emergencyAddress"
                                        >Address</label
                                    >
                                    <input
                                        type="text"
                                        id="emergencyAddress"
                                        name="emergencyAddress"
                                        v-model="contactEmergencyAddress"
                                        class="form-control"
                                    />
                                </div>

                                <div class="form-group mb-3">
                                    <label for="relationship"
                                        >Relationship</label
                                    >
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

                            <div class="divider">
                                <h5 class="text-muted mb-3">
                                    Select where to send the QR Code
                                </h5>

                                <div class="form-check mb-3">
                                    <input
                                        type="checkbox"
                                        id="sameAsEmail"
                                        class="form-check-input"
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
                                        class="form-control"
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
                                    class="btn btn-primary btn-lg"
                                >
                                    Submit
                                </button>
                            </div>

                            <!-- Modal Component -->
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
