<template>
    <div class="scanner-container">
        <!-- QR Code Scanner Component -->
        <qrcode-stream @decode="onDecode" @init="onInit"></qrcode-stream>

        <!-- Display Captured QR Code Result -->
        <div v-if="qrResult" class="result">
            <h3>QR Code Captured:</h3>
            <p>{{ qrResult }}</p>
        </div>
    </div>
</template>

<script>
import { QrcodeStream } from "vue-qrcode-reader";

export default {
    components: { QrcodeStream },
    data() {
        return {
            qrResult: null,
        };
    },
    methods: {
        onDecode(result) {
            this.qrResult = result;
            console.log("QR Code Result:", result);
        },
        // Initialize the scanner
        onInit(promise) {
            promise
                .then(() => {
                    console.log("Camera is ready");
                })
                .catch((error) => {
                    console.error("Camera initialization failed:", error);
                });
        },
    },
};
</script>

<style>
.scanner-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 30px;
    border: 1px solid #ccc;
    border-radius: 8px;
    background-color: #f8f9fa;
    max-width: 50%;
    margin: 60px auto;
}

.result {
    margin-top: 20px;
    text-align: center;
}
</style>
