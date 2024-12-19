<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>

<body>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full">
            <div class="col-md-12">
                <div class="d-flex align-items-center">
                    <img src="{{ asset('images/balesin_logo.png')}}" class="rounded-t-lg h-50 w-100" alt="Image description" />
                </div>
            </div>
            @if ($qr_code['departure_date'] < now())
                <div class="bg-red-100 text-red-700 p-4 rounded-lg">
                    <h2 class="text-xl font-semibold">The QR code has expired.</h2>
                    <p class="mt-2">Please refer to this link <a href="/index" class="text-blue-600 underline">Click here.</a> to create new QR Code.</p>
                </div>
            @else
                <h1 class="text-2xl font-bold text-blue-600 mb-4 mt-2">
                    Tracking System
                </h1>
                <form action="{{ route('create.activity') }}" method="POST" id="activityForm">
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
                            name="fullname"
                            value="{{ $qr_code['name']}}"
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
                            name="emailaddress"
                            value="{{ $qr_code['email_address']}}"
                        />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="contactNumber" class="form-label"
                            >Activity:</label
                        >
                        <select
                            class="form-control bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="activity_name"
                            name="activity_name"
                        >
                            <option value="" disabled selected>
                                Please Select
                            </option>
                            <option value="Flight Check-In">Flight Check-in</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="arrival_date" class="form-label">Arrival Date:</label>
                        <input
                            type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="arrival_date"
                            placeholder="arrival_date"
                            aria-label="arrival_date"
                            name="arrival_date"
                            value="{{ $qr_code['arrival_date'] }}"
                        />
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="location" class="form-label"
                            >Location:</label
                        >
                        <select
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            id="location"
                            name="location"
                        >
                            <option value="" disabled selected>
                                Please Select
                            </option>
                            <option value="Manila - Hangar">Manila - Hangar</option>
                            <option value="Clark - Hangar">Clark - Hangar</option>
                            <option value="Sangley - Hangar">Sangley - Hangar</option>
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
            @endif
        </div>
    </div>

    @vite('resources/js/app.js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function(){
            var user_id = "{{ $qr_code['user_id'] }}";
            var travel_id = "{{ $qr_code['travel_id'] }}";
            var formData = $('#activityForm').serialize();

            $('#activityForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                formData.append('user_id', user_id);
                formData.append('travel_id', travel_id);

                console.log('formData', formData);
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.data) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'Okay'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = '/index';
                                }
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Something went wrong.',
                            icon: 'error',
                            confirmButtonText: 'Okay'
                        });
                    }
                });
            });
        })
    </script>
</body>
</html>
