<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Details Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="assets/css/cusopr.css">
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
        <h2>Vehicle Details Form</h2>
        <!-- Customer Info Form -->
        <form action="{{ route('referVehi') }}" method="post" id="VehicleForm" class="row g-3" autocomplete="off">
            @csrf
            <div class="col-md-4">
                <label for="phone" class="form-label">Vehicle No</label>
                <input type="text" class="form-control" id="VehiNo" name="VehiNo" placeholder="Enter Vehicle No" required oninput="formatVehiNo(this)" autocomplete="off">
            </div>
            <div class="col-md-4">
                <label for="name" class="form-label">Vehicle Name</label>
                <input type="text" class="form-control" id="Vehiname" name="Vehiname" placeholder="Enter Vehicle Name" required oninput="formatVehiNo(this)" autocomplete="off">
            </div>
            <!-- <div class="col-md-4">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required>
            </div> -->
            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>
            </div>
        </form>

        <!-- Table to show customer data -->
        <div class="table-container">
            <table class="table table-striped table-bordered table-responsive mt-4" id="vehicleTable">
                <thead>
                    <tr>
                        <th>S.No</th> <!-- Serial Number Column -->
                        <th>Vehicle No</th>
                        <th>Vehicle Name</th>
                        <!-- <th>Address</th> -->
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($VehiAll as $Vehi)
                    <tr>
                        <td>{{ $loop->iteration + ($VehiAll->firstItem() - 1) }}</td> <!-- Auto Serial Number -->
                        <td>{{ $Vehi->VehiID }}</td>
                        <td>{{ $Vehi->VehiName }}</td>
                        <!-- <td>{{ $Vehi->address }}</td> -->
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $Vehi->id }}" data-vehiid="{{ $Vehi->VehiID }}" data-vehiname="{{ $Vehi->VehiName }}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $Vehi->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-column align-items-center mt-3">
                <!-- Visible on mobile only -->
                <p class="text-muted text-center d-md-none">
                    Showing {{ $VehiAll->firstItem() }} to {{ $VehiAll->lastItem() }} of {{ $VehiAll->total() }} results
                </p>
                <div class="table-responsive">
                    {{ $VehiAll->links('pagination::bootstrap-5') }}
                </div>
                <!-- Visible on desktop only -->
                <p class="text-muted text-center d-none d-md-block">
                    Showing {{ $VehiAll->firstItem() }} to {{ $VehiAll->lastItem() }} of {{ $VehiAll->total() }} results
                </p>
            </div>
        </div>

        <!-- AJAX Script to Fetch Data and Update Table -->
        <script>
            const vehiFetchUrl = "{{ route('Vehicle.fetch') }}";
            const vehiUpdateUrl = "{{ route('Vehicle.update') }}";
            const vehiDeleteUrl = "{{ route('Vehicle.delete') }}";
            const csrfToken = "{{ csrf_token() }}";
        </script>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="{{ asset('assets/js/vehi.js') }}"></script>

</html>