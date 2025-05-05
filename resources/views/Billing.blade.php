<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill Entry Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/cusopr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Container with border -->
    <div class="container mt-5">
        @if(session('success'))
        <script>
            Swal.fire({
                title: "Success!",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                location.reload(); // Refresh AFTER alert closes
            });
        </script>
        @endif

        <h2>Bill Entry Form</h2>
        <form action="{{ route('Bills.store') }}" method="post" id="billingForm">
            @csrf
            <div class="row g-3">
                <div class="col-6 col-md-4">
                    <label for="date" class="form-label">Select Date</label>
                    <input type="date" class="form-control form-control-sm" id="date" name="date" required>
                </div>

                <div class="col-6 col-md-4">
                    <label for="bill_no" class="form-label">
                        Bill No <span class="text-danger">*</span>
                    </label>
                    <i class="fa fa-search" id="searchBtn" style="margin-left: 5px; color: #007bff; cursor: pointer;"></i>
                    <i class="fa fa-trash" id="deleteBtn" style="margin-left: 5px; color: red; cursor: pointer;"></i>

                    <input type="number" class="form-control form-control-sm" id="bill_no" name="bill_no" min="0" value="{{ $count }}" required>
                </div>


                <!-- Customer Name Dropdown -->
                <div class="col-6 col-md-4">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <select class="form-control" id="customer_name" name="customer_name" required>
                        <option value="">Select Customer</option>
                        @foreach($cusnames as $cusname)
                        <option value="{{ $cusname }}">{{ $cusname }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="cusmob" class="form-label">Cus MobNo</label>
                    <input type="text" class="form-control form-control-sm" id="cusmob" name="cusmob" required readonly>
                </div>

                <div class="col-6 col-md-4">
                    <label for="cusadd" class="form-label">Cus Address</label>
                    <input type="text" class="form-control form-control-sm" id="cusadd" name="cusadd" required readonly>
                </div>


                <!-- Operator Name Dropdown -->
                <div class="col-6 col-md-4">
                    <label for="operator_name" class="form-label">Operator Name</label>
                    <select class="form-control" id="operator_name" name="operator_name" required>
                        <option value="">Select Operator</option>
                        @foreach($oprnames as $oprname)
                        <option value="{{ $oprname }}">{{ $oprname }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Vehicle ID Dropdown -->
                <div class="col-6 col-md-4">
                    <label for="vehicle_id" class="form-label">Vehicle ID</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                        <option value="">Select Vehicle</option>
                        @foreach($vehiids as $vehiid)
                        <option value="{{ $vehiid }}">{{ $vehiid }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-6 col-md-4">
                    <label for="works" class="form-label">Works</label>
                    <input type="text" class="form-control form-control-sm" id="works" name="works">
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-6 col-md-4 text-center">
                    <label for="starttime" class="form-label">Start Time</label>
                    <input type="number" class="form-control form-control-sm" id="starttime" name="starttime" step="any" required>
                </div>

                <div class="col-6 col-md-4 text-center">
                    <label for="endtime" class="form-label">End Time</label>
                    <input type="number" class="form-control form-control-sm" id="endtime" name="endtime" step="any" required>
                </div>

                <div class="col-6 col-md-4 mx-auto text-center">
                    <label for="totaltime" class="form-label ">Total Time</label>
                    <input type="number" class="form-control form-control-sm" id="totaltime" step="any" name="totaltime" readonly>
                </div>
                <div class="d-flex justify-content-center" dir="rtl">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="CheckType" id="tone">
                        <label class="form-check-label" for="tone">1200</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="CheckType" id="ttwo">
                        <label class="form-check-label" for="ttwo">1100</label>
                    </div>
                </div>
            </div>
            <div class="row g-3 mt-1">
                <div class="col-6 col-md-4 text-center">
                    <label for="totamt" class="form-label">Total Amount</label>
                    <input type="number" class="form-control form-control-sm" id="totamt" name="totamt" min="0" required>
                </div>

                <div class="col-6 col-md-4 text-center">
                    <label id="paid1" for="paid" class="form-label">Paid</label>
                    <input type="number" class="form-control form-control-sm" id="paid" name="paid" min="0">
                </div>

                <div id="tobepayDiv" class="col-6 col-md-4">
                    <label for="tobepay" class="form-label">To Be Pay :</label> <label for="tobeamnt" id="tobeamnt" style="color: red;"></label>
                    <input type="number" class="form-control form-control-sm" id="tobepay" name="tobepay" min="0" required>
                </div>

                <div class="col-6 col-md-4 mx-auto text-center">
                    <label for="balamt" class="form-label ">Balance</label>
                    <input type="number" class="form-control form-control-sm" id="balamt" name="balamt" readonly>
                </div>


                <div class="col-12 d-flex justify-content-center">
                    <button id="submit" type="submit" class="btn btn-primary me-2" style="background-color: green; border-color: green;">Submit</button>
                    <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>
                </div>
            </div>
        </form>
        <button id="update" type="update" class="btn btn-primary me-2" style="background-color: green; border-color: green;">Update</button>
    </div>




    <!-- AJAX Script to Fetch Data and Update Table -->
    <script>
        const getbilldata = "{{ url('get-bill-data') }}";
        const getcusmob = "{{ route('getcusmobadd') }}";
        const billFetchUrl = "{{ route('customer.fetch') }}";
        const billUpdateUrl = "{{ route('bill.update') }}";
        const billDeleteUrl = "{{ route('bill.delete') }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/bill.js') }}"></script>
    <script src="assets/js/cusopr.js"></script>
</body>

</html>