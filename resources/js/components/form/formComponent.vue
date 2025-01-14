<template>
    <div class="container mt-5">
        <div class="row justify-content-center max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg">
            <img
                v-bind:src="'images/balesin_logo.png'"
                style="width: 45%"
                class="rounded-t-lg mb-3"
                alt="Image description"
            />
            <!-- <h5 class="text-md dark:text-white mb-2 ml-4"><strong>Hello, <span class="text-md font-bold text-blue-500 lg:text-xl dark:text-blue-400">{{ fullName }}</span>! To reserve a flight, please complete the form below to get started.</strong></h5> -->
            <form @submit.prevent="submitForm">
                <div class="col-md-12">
                    <div v-if="userType === 'guest'">
                        <div class="mt-3 divider p-3">
                            <span>Member Details</span>

                            <div class="row mt-2 ml-2">
                                <div class="flex-1 mb-3">
                                    <label for="fullName" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Membership No:</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="membershipNo"
                                        placeholder="Full Name"
                                        aria-label="Full Name"
                                        v-model="membershipNo"
                                        :disabled="isDisabled"
                                        :style="{
                                            backgroundColor: isDisabled
                                                ? '#d2d2d2'
                                                : 'white',
                                        }"
                                    />
                                </div>
                                <div class="flex-1 mb-3">
                                    <label for="fullName" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Name of Sponsoring Member</label>
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
                            </div>
                        </div>
                        <div class="mt-3 divider p-3">
                            <span>Guest Details</span>

                            <div class="row mt-2 ml-2">
                                <div class="flex-1 mb-3">
                                    <label for="emailAddress" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Email Address</label
                                    >
                                    <input
                                        type="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="emailAddress"
                                        placeholder="Email Address"
                                        aria-label="Email Address"
                                        v-model="emailAddress"
                                    />
                                </div>

                                <div class="flex-1 mb-3">
                                    <label for="guestFullName" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Full Name</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="guestFullName"
                                        placeholder="Full Name"
                                        aria-label="Full Name"
                                        v-model="guestFullName"
                                    />
                                </div>

                                <div class="flex-1 mb-3">
                                    <label
                                        for="contactNumber"
                                        class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Contact Number</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="contactNumber"
                                        placeholder="Contact Number"
                                        aria-label="Contact Number"
                                        v-model="contactNumber"
                                    />
                                </div>
                            </div>

                            <div class="row mt-2 ml-2">
                                <div class="flex-1 mb-3">
                                    <label for="address" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Address</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="address"
                                        placeholder="Address"
                                        aria-label="Address"
                                        v-model="address"
                                    />
                                </div>

                                <div class="flex-1 mb-3">
                                    <label for="birthDate" class="form-label block text-sm font-medium text-gray-700 mb-2">
                                    Birthday
                                    </label>
                                    <div class="relative">
                                        <input
                                            id="birthDate"
                                            type="date"
                                            class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            v-model="birthDate"
                                            required
                                        />
                                        <label
                                            for="birthDate"
                                            :class="[
                                            'absolute text-gray-400 text-sm left-3 transition-all duration-200 ease-in-out bg-gray-50 px-1 dark:bg-gray-700',
                                            birthDate ? 'top-[-10px] text-blue-500 text-xs' : 'top-2 text-gray-400 text-sm'
                                            ]"
                                        >
                                            Select a date
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else>
                        <div class="mt-3 divider p-3">
                            <span>Personal Details</span>

                            <div class="row mt-2 ml-2">
                                <div class="flex-1 mb-3">
                                    <label for="emailAddress" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Email Address</label
                                    >
                                    <input
                                        type="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="emailAddress"
                                        placeholder="Email Address"
                                        aria-label="Email Address"
                                        v-model="emailAddress"
                                        :disabled="isEmailDisabled"
                                        :style="{
                                            backgroundColor: isEmailDisabled
                                                ? '#d2d2d2'
                                                : 'white',
                                        }"
                                    />
                                </div>

                                <div class="flex-1 mb-3">
                                    <label for="fullName" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Full Name</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="fullName"
                                        placeholder="Full Name"
                                        aria-label="Full Name"
                                        v-model="fullName"
                                        :disabled="isFullNameDisabled"
                                        :style="{
                                            backgroundColor: isFullNameDisabled
                                                ? '#d2d2d2'
                                                : 'white',
                                        }"
                                    />
                                </div>

                                <div class="flex-1 mb-3">
                                    <label
                                        for="contactNumber"
                                        class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Contact Number</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="contactNumber"
                                        placeholder="Contact Number"
                                        aria-label="Contact Number"
                                        v-model="contactNumber"
                                        :disabled="isContactDisabled"
                                        :style="{
                                            backgroundColor: isContactDisabled
                                                ? '#d2d2d2'
                                                : 'white',
                                        }"
                                    />
                                </div>
                            </div>

                            <div class="row mt-2 ml-2">
                                <div class="flex-1 mb-3">
                                    <label for="address" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Address</label
                                    >
                                    <input
                                        type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        id="address"
                                        placeholder="Address"
                                        aria-label="Address"
                                        v-model="address"
                                        :disabled="isAddressDisabled"
                                        :style="{
                                            backgroundColor: isAddressDisabled
                                                ? '#d2d2d2'
                                                : 'white',
                                        }"
                                    />
                                </div>

                                <div class="flex-1 mb-3">
                                    <label for="birthDate" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                        >Birth Date</label
                                    >
                                    <div class="position-relative">
                                        <div
                                            class="position-absolute inset-y-0 start-0 d-flex align-items-center ps-3"
                                        >
                                            <svg
                                                class="w-4 h-4 text-gray-500 dark:text-gray-400"
                                                aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"
                                                />
                                            </svg>
                                        </div>
                                        <input
                                            datepicker
                                            id="birthDate"
                                            type="text"
                                            class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Select date"
                                            v-model="birthDate"
                                            :disabled="isBirthDateDisabled"
                                            :style="{
                                                backgroundColor: isBirthDateDisabled
                                                    ? '#d2d2d2'
                                                    : 'white',
                                            }"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4" v-if="userType === 'member'">
                        <h1 class="text-lg font-semibold">Please fill in</h1>
                    </div>
                    <div class="mt-3 divider p-3">
                        <span>Flight Dates</span>

                        <div class="row mt-2 ml-2 flex gap-4">
                            <!-- Arrival Date -->
                            <div class="flex-1 mb-3">
                                <label for="travelStart" class="form-label block text-sm font-medium text-gray-700 mb-1">
                                Arrival Date
                                </label>
                                <div class="relative">
                                    <input
                                        id="travelStart"
                                        type="date"
                                        class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        v-model="travelStart"
                                        required
                                    />
                                    <label
                                        for="travelStart"
                                        :class="[
                                        'absolute text-gray-400 text-sm left-3 transition-all duration-200 ease-in-out bg-gray-50 px-1 dark:bg-gray-700',
                                        travelStart ? 'top-[-10px] text-blue-500 text-xs' : 'top-2 text-gray-400 text-sm'
                                        ]"
                                    >
                                        Select a date
                                    </label>
                                </div>
                            </div>

                            <!-- Departure Date -->
                            <div class="flex-1 mb-3">
                                <label for="travelEnd" class="form-label block text-sm font-medium text-gray-700 mb-1">
                                Departure Date
                                </label>
                                <div class="relative">
                                    <input
                                        id="travelEnd"
                                        type="date"
                                        class="peer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-3 py-2 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        v-model="travelEnd"
                                        required
                                    />
                                    <label
                                        for="travelEnd"
                                        :class="[
                                        'absolute text-gray-400 text-sm left-3 transition-all duration-200 ease-in-out bg-gray-50 px-1 dark:bg-gray-700',
                                        travelEnd ? 'top-[-10px] text-blue-500 text-xs' : 'top-2 text-gray-400 text-sm'
                                        ]"
                                    >
                                        Select a date
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 divider p-3">
                        <span>In Case of Emergency</span>

                        <div class="row mt-2">
                            <div class="flex-1 mb-3 ml-5">
                                <label for="emergencyName" class="form-label block text-sm font-medium text-gray-700 mb-1">Name</label>
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
                                <label for="emergencyContact" class="form-label block text-sm font-medium text-gray-700 mb-1"
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

                            <div class="flex-1 mb-3">
                                <label for="emergencyAddress" class="form-label block text-sm font-medium text-gray-700 mb-1"
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

                            <div class="flex-1 mb-3">
                                <label for="relationship" class="form-label block text-sm font-medium text-gray-700 mb-1"
                                    >Relationship</label
                                >
                                <select
                                    id="relationship"
                                    name="relationship"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-model="
                                        contactEmergencyRelationship
                                    "
                                >
                                    <option value="">Select</option>
                                    <option value="father">
                                        Father
                                    </option>
                                    <option value="mother">
                                        Mother
                                    </option>
                                    <option value="brother">
                                        Brother
                                    </option>
                                    <option value="sister">
                                        Sister
                                    </option>
                                    <option value="spouse">
                                        Spouse
                                    </option>
                                    <option value="others">
                                        Others
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 divider p-3">
                        <span>Email QR Code</span>
                        <div class="p-3">
                            <div class="form-check mb-3">
                                <input
                                    type="checkbox"
                                    id="sameAsEmail"
                                    class="form-check-input"
                                    v-model="sameAsEmail"
                                    @change="alternateChecked('sameAsEmail')"
                                />
                                <label for="sameAsEmail" class="form-check-label">
                                    Same Email Address as indicated above
                                </label>
                            </div>

                            <div class="form-check mb-3">
                                <input
                                    type="checkbox"
                                    id="alternateAddress"
                                    class="form-check-input"
                                    v-model="isAlternateChecked"
                                    @change="syncAlternateEmail"
                                />
                                <label for="alternateAddress" class="form-check-label">
                                    Use other Email Address
                                </label>
                            </div>

                            <div v-if="isAlternateChecked" class="mb-3">
                                <label for="altEmailInput">Alternate Email Address</label>
                                <input
                                    type="email"
                                    id="altEmailInput"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-model="altEmail"
                                    placeholder="Enter alternate email address"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="checkbox-container mt-3 mb-4">
                        <input
                        type="checkbox"
                        id="waiver"
                        :disabled="!isAgree"
                        :style="{ backgroundColor: !isAgree ? '#d2d2d2' : 'blue' }"
                        required
                        />
                        <label for="waiver">
                        I agree to the
                        <a href="javascript:void(0)" @click="showWaiverModal">Release and Waiver of Liability</a>
                        </label>
                    </div>

                    <div class="d-grid">
                        <button
                            type="submit"
                            class="bg-transparent hover:bg-blue-500 text-black-700 font-semibold hover:text-blue-900 py-2 px-4 border border-blue-500 hover:border-transparent rounded"
                        >
                            Submit
                        </button>
                    </div>

                    <div
                        id="waiverModal"
                        tabindex="-1"
                        aria-labelledby="waiverModalLabel"
                        aria-hidden="true"
                        v-if="modalVisible"
                        class="fixed inset-0 z-50 bg-gray-800 bg-opacity-50 flex items-center justify-center"
                    >
                        <div class="bg-white rounded-lg shadow-lg w-11/12 md:w-3/4 lg:w-1/2 p-6 max-h-[90vh] overflow-y-auto">
                            <div class="flex justify-between items-center mb-4">
                                <h5 class="text-xl font-semibold" id="waiverModalLabel">
                                    Release and Waiver of Liability
                                </h5>
                                <button
                                    type="button"
                                    class="text-gray-500 hover:text-gray-700"
                                    @click="closeModal"
                                    aria-label="Close"
                                >
                                    <svg
                                        class="w-6 h-6"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        aria-hidden="true"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M6.293 4.293a1 1 0 011.414 0L10 6.586l2.293-2.293a1 1 0 111.414 1.414L11.414 8l2.293 2.293a1 1 0 01-1.414 1.414L10 9.414l-2.293 2.293a1 1 0 01-1.414-1.414L8.586 8 6.293 5.707a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                            <div class="modal-body mb-6 text-sm text-gray-700">
                                <p>
                                    As a Member or Guest of Balesin Island Club (the “Club”), I understand and undertake to always comply with the relevant laws, rules, and regulations and Club Rules, including, but not limited to:
                                </p>
                                <ul class="list-disc pl-5">
                                    <li>Membership Rules</li>
                                    <li>House Rules</li>
                                </ul>

                                <p class="mt-4">
                                    I acknowledge that these rules may be amended by the Club at its sole discretion from time to time. As a Member, I represent and warrant that:
                                </p>
                                <ul class="list-disc pl-5">
                                    <li>
                                        I have neither leased nor sold my free villa nights and room entitlements, nor have I utilized these entitlements for a commercial purpose.
                                    </li>
                                    <li>
                                        My guests, if any, are bona fide, and I have not received any benefit or consideration from them directly or indirectly.
                                    </li>
                                </ul>

                                <p class="mt-4">
                                    I understand that violating these rules will result in my immediate expulsion as a Member of the Club.
                                </p>

                                <h6 class="font-semibold mt-4">Responsibility for Guests and Dependents</h6>
                                <p>
                                    As a Member, I am responsible for the behavior of my guests and any unpaid costs of goods consumed or services rendered by the Club to my Dependents and Guests.
                                </p>

                                <h6 class="font-semibold mt-4">Intellectual Property Notice</h6>
                                <p>
                                    "Balesin", "Balesin Island", "Balesin Island Club," and official Club images (from its website or social media posts) are the Intellectual Property of the Club. Unauthorized use of these items for any purpose is prohibited without explicit consent from the Club.
                                </p>

                                <h6 class="font-semibold mt-4">Assumption of Risk</h6>
                                <p>
                                    I understand that participation in the trip to Balesin Island and the Club involves some risks, including risks related to air travel and transportation, which could lead to property damage, injury, or death.
                                </p>

                                <p>
                                    By signing this Release and Waiver of Liability, I hold Alphaland Corporations, Alphaland Balesin Island Resort Corporation, Alphaland Balesin Island Club, Inc., Alphaland Aviation, Inc., and their affiliates free and harmless from all liability for any injury, loss, or damage suffered at the Club or in transit to the Club.
                                </p>

                                <p>
                                    This Release and Waiver of Liability binds my family members, spouse, heirs, successors-in-interest, assigns, and personal representatives.
                                </p>
                            </div>
                            <div class="flex justify-end space-x-4">
                                <button
                                    type="button"
                                    class="bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none"
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

        const isAgree = ref(false);
        const modalVisible = ref(false); // Track modal visibility

        const membershipNo = ref("");
        const membershipId = ref("");

        // This below block is for auto-populating fields in form
        const emailAddress = ref("");
        const fullName = ref("");
        const guestFullName = ref("");
        const emailAdd = ref("");
        const contactNumber = ref("");
        const birthDate = ref("");
        const address = ref("");
        const userType = ref("");
        const travelStart = ref("");
        const travelEnd = ref("");
        const contactEmergencyName = ref("");
        const contactEmergencyNumber = ref("");
        const contactEmergencyAddress = ref("");
        const contactEmergencyRelationship = ref("");

        const router = useRouter();

        const isAutoFilledEmail = ref(false);
        const isAutoFilledFullName = ref(false);
        const isAutoFilledContact = ref(false);
        const isAutoFilledBirthDate = ref(false);
        const isAutoFilledAddress = ref(false);
        const isAutoFilledArrival = ref(false);
        const isAutoFilledDeparture = ref(false);

        const infoDetails = JSON.parse(sessionStorage.getItem("info"));

        const autoFillForm = () => {
            if (infoDetails) {
                emailAddress.value = infoDetails.email_address || "";
                fullName.value = infoDetails.member_name || "";
                contactNumber.value = infoDetails.contact_no || "";
                birthDate.value = infoDetails.birthdate || "";
                address.value = infoDetails.member_address || "";
                userType.value = infoDetails.role_name || "";
                membershipNo.value = infoDetails.membership_no || "";
                membershipId.value = infoDetails.membership_id || "";
                travelStart.value = infoDetails.arrival_date || "";
                travelEnd.value = infoDetails.return_date || "";

                if(infoDetails.emergencyContact)
                {
                    contactEmergencyName.value = infoDetails.emergencyContact.name || "";
                    contactEmergencyNumber.value = infoDetails.emergencyContact.contact_no || "";
                    contactEmergencyAddress.value = infoDetails.emergencyContact.address || "";
                    contactEmergencyRelationship.value = infoDetails.emergencyContact.relationship || "";
                }

                isAutoFilledEmail.value = !!infoDetails.email_address;
                isAutoFilledFullName.value = !!infoDetails.member_name;
                isAutoFilledContact.value = !!infoDetails.contact_no;
                isAutoFilledBirthDate.value = !!infoDetails.birthdate;
                isAutoFilledAddress.value = !!infoDetails.member_address;
                isAutoFilledArrival.value = !!infoDetails.arrival_date;
                isAutoFilledDeparture.value = !!infoDetails.return_date;
            }
        };

        // const syncAlternateEmail = () => {
        //     if (isAlternateChecked.value) {
        //         emailAddress.value = altEmail.value;
        //     }
        // };

        const alternateChecked = (type) => {
            if (type === "sameAsEmail") {
                if (sameAsEmail.value) {
                    isAlternateChecked.value = false;
                }
            } else if (type === "isAlternateChecked") {
                if (isAlternateChecked.value) {
                    sameAsEmail.value = false;
                }
            }
        };

        const showWaiverModal = () => {
            modalVisible.value = !modalVisible.value;
        };


        const closeModal = () => {
            modalVisible.value = false;
        };

        const acceptWaiver = () => {
            isAgree.value = true;
            document.getElementById("waiver").checked = true;
            closeModal();
        };

        const submitForm = async () => {
            const userData = {
                membership_id: infoDetails ? infoDetails.membership_id : null,
                name: guestFullName.value ? guestFullName.value : fullName.value,
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
                user_role_status: null,
                travel_id: infoDetails ? infoDetails.travel_id : null
            };

            if (altEmail.value) {
                userData.alternate_email = altEmail.value;
            }

            if (infoDetails) {
                const userRole = infoDetails.role_name;
                try {
                    const response = await axios.get(
                        "http://localhost:8000/api/roles/show",
                        {
                            params: { role_name: userRole },
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                            },
                        }
                    );

                    if (response.data?.data) {
                        userData.role_id = response.data.data.role_id || null;
                        userData.user_role_status = response.data.data.status || null;
                    }
                } catch (error) {
                    console.error("Error fetching role:", error);
                    Swal.fire({
                        title: "Error",
                        text: "Failed to fetch role. Please try again.",
                        icon: "error",
                        confirmButtonText: "Close",
                    });
                    return;
                }
            }

            try {
                // Submit user data
                const userResponse = await axios.post(
                    "http://localhost:8000/api/users/create", // Ensure the URL is clean
                    userData, // Pass the data as the body
                    {
                        headers: {
                            "Content-Type": "application/json", // Use JSON to avoid URL-encoded behavior
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                        },
                    }
                );

                // Handle success
                if (userResponse.status === 200) {
                    Swal.fire({
                        title: "QR Code has been sent",
                        text: "QR Code has been sent to "+userResponse.data.data.email_address,
                        icon: "success",
                        confirmButtonText: "Close",
                    }).then(() => {
                        sessionStorage.removeItem("info");
                        router.replace("/index");
                    });
                } else {
                    console.error("Unexpected response:", userResponse);
                    Swal.fire({
                        title: "Failed to generate QR Code",
                        text: "Failed to generate QR Code. Please try again.",
                        icon: "error",
                        confirmButtonText: "Close",
                    });
                }
            } catch (err) {
                console.error("Error submitting qr code data:", err);
                Swal.fire({
                    title: "Error",
                    text: "Error generating QR Code: " + err.message,
                    icon: "error",
                    confirmButtonText: "Close",
                });
            }

            // if(infoDetails.emergencyContact != {})
            // {
            //     const contactDetails = {
            //         "name": contactEmergencyName.value,
            //         "contact_no": contactEmergencyNumber.value,
            //         "address": contactEmergencyAddress.value,
            //         "relationship": contactEmergencyRelationship.value,
            //         "user_id": infoDetails.user_id
            //     };

            //     try {
            //         const emergencyContactResponse = await axios.put("http://localhost:8000/api/emergency_details/update", contactDetails, {
            //             headers: {
            //                 "Content-Type": "application/json", // Use JSON to avoid URL-encoded behavior
            //                 "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            //             },
            //         })

            //         if(emergencyContactResponse.status === 200)
            //         {
            //             console.error("Unexpected response:", userResponse);
            //         }
            //     } catch (e) {
            //         console.error("Error updating emergency details data:", err);
            //         Swal.fire({
            //             title: "Error",
            //             text: "Error updating the emergency contact details: " + err.message,
            //             icon: "error",
            //             confirmButtonText: "Close",
            //         });
            //     }
            // }
        };

        const isEmailDisabled = computed(() => isAutoFilledEmail.value);
        const isFullNameDisabled = computed(() => isAutoFilledFullName.value);
        const isContactDisabled = computed(() => isAutoFilledContact.value);
        const isBirthDateDisabled = computed(() => isAutoFilledBirthDate.value);
        const isAddressDisabled = computed(() => isAutoFilledAddress.value);
        const isArrivalDisabled = computed(() => isAutoFilledArrival.value);
        const isDepartureDisabled = computed(() => isAutoFilledDeparture.value);

        onMounted(() => {
            autoFillForm();
        });

        return {
            emailAddress,
            membershipNo,
            fullName,
            guestFullName,
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
            // isDisabled,
            alternateChecked,
            modalVisible,
            userType,
            isAgree,
            isEmailDisabled,
            isFullNameDisabled,
            isContactDisabled,
            isBirthDateDisabled,
            isAddressDisabled,
            isArrivalDisabled,
            isDepartureDisabled,
        };
    },
};
</script>

<style>
ul {
    list-style-type: disc;
    padding-left: 20px;
}

.checkbox-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
}
</style>
