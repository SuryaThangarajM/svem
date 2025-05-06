<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Operator Details Form</title>
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
        <h2>Operator Details Form</h2>
        <!-- Customer Info Form -->
        <form action="{{ route('referopr') }}" method="post" id="operatorForm" class="row g-3" autocomplete="off">
            @csrf
            <div class="col-md-4">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="mobno" placeholder="Enter Phone" required oninput="formatcusopr(this)" autocomplete="off">
            </div>
            <div class="col-md-4">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required oninput="cusoprcaps(this)" autocomplete="off">
            </div>
            <div class="col-md-4">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" required oninput="cusoprcaps(this)" autocomplete="off">
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>
            </div>
        </form>

        <!-- Table to show customer data -->
        <div class="table-container">
            <table class="table table-striped table-bordered table-responsive mt-4" id="operatorTable">
                <thead>
                    <tr>
                        <th>S.No</th> <!-- Serial Number Column -->
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($oprall as $opr)
                    <tr>
                        <td>{{ $loop->iteration + ($oprall->firstItem() - 1) }}</td> <!-- Auto Serial Number -->
                        <td>{{ $opr->name }}</td>
                        <td>{{ $opr->mobno }}</td>
                        <td>{{ $opr->address }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $opr->id }}" data-name="{{ $opr->name }}" data-mobno="{{ $opr->mobno }}" data-address="{{ $opr->address }}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $opr->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-column align-items-center mt-3">
                <!-- Visible on mobile only -->
                <p class="text-muted text-center d-md-none">
                    Showing {{ $oprall->firstItem() }} to {{ $oprall->lastItem() }} of {{ $oprall->total() }} results
                </p>
                <div class="table-responsive">
                    {{ $oprall->links('pagination::bootstrap-5') }}
                </div>
                <!-- Visible on desktop only -->
                <p class="text-muted text-center d-none d-md-block">
                    Showing {{ $oprall->firstItem() }} to {{ $oprall->lastItem() }} of {{ $oprall->total() }} results
                </p>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="assets/js/cusopr.js"></script>

        <script>
            $(document).ready(function() {
                // Fetch Customer Data
                $('#phone').on('keyup', function() {
                    let mobno = $(this).val();

                    $.ajax({
                        url: "{{ route('operator.fetch') }}",
                        type: "GET",
                        data: {
                            mobno: mobno
                        },
                        success: function(response) {
                            let tableBody = $('#operatorTable tbody');
                            tableBody.empty();

                            if (response.success) {
                                $('#name').val(response.operator.name);
                                $('#address').val(response.operator.address);

                                tableBody.append(`
            <tr id="row-${response.operator.id}">
                <td>1</td>  <!-- Single Customer Case -->
                <td>${response.operator.name}</td>
                <td>${mobno}</td>
                <td>${response.operator.address}</td>
                <td>
                    <button class="btn btn-warning btn-sm edit-btn" 
                        data-id="${response.operator.id}" 
                        data-name="${response.operator.name}" 
                        data-mobno="${mobno}" 
                        data-address="${response.operator.address}">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete-btn" data-id="${response.operator.id}">Delete</button>
                </td>
            </tr>
        `);
                            } else {
                                $('#name').val('');
                                $('#address').val('');

                                if (response.operators.length > 0) {
                                    let serial = 1;
                                    response.operators.forEach(function(opr) {
                                        tableBody.append(`
                    <tr id="row-${opr.id}">
                    <td>${serial}</td>  <!-- Proper Auto Serial Numbering -->
                        <td>${opr.name}</td>
                        <td>${opr.mobno}</td>
                        <td>${opr.address}</td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="${opr.id}" 
                                data-name="${opr.name}" 
                                data-mobno="${opr.mobno}" 
                                data-address="${opr.address}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${opr.id}">Delete</button>
                        </td>
                    </tr>
                `);
                                        serial++; // Increment serial number for each row
                                    });
                                } else {
                                    tableBody.append('<tr><td colspan="4" class="text-center">No Operator Data Available</td></tr>');
                                }
                            }
                        }
                    });
                });

                // Handle Edit Button Click
                $(document).on('click', '.edit-btn', function() {
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let mobno = $(this).data('mobno');
                    let address = $(this).data('address');

                    $('#phone').val(mobno);
                    $('#name').val(name);
                    $('#address').val(address);

                    // Ensure the hidden input is added
                    if ($('#edit-id').length === 0) {
                        $('#operatorForm').append(`<input type="hidden" id="edit-id" name="id" value="${id}">`);
                    } else {
                        $('#edit-id').val(id);
                    }

                    $('.btn-primary').text('Update').attr('id', 'updateBtn');
                });

                // Handle Update Action
                $(document).on('click', '#updateBtn', function(e) {
                    e.preventDefault();
                    let id = $('#edit-id').val();
                    let name = $('#name').val();
                    let mobno = $('#phone').val();
                    let address = $('#address').val();

                    // Debugging: Check if ID exists
                    // console.log("Updating Customer - ID:", id, "Name:", name, "MobNo:", mobno, "Address:", address);
                    // alert(id); 
                    $.ajax({
                        url: "{{ route('operator.update') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            name: name,
                            mobno: mobno,
                            address: address
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    title: "Updated",
                                    text: "Operator data has been Updated.",
                                    icon: "success",
                                    timer: 10000, // Auto-close after 10 seconds
                                    confirmButtonText: "OK"
                                }).then(() => {
                                    location.reload(); // Refresh AFTER alert closes
                                });
                            } else {
                                Swal.fire("Error!", "Failed to Update operator.", "error");
                            }
                        }
                    });
                });

                // Handle Delete Button Click
                $(document).on('click', '.delete-btn', function() {
                    let id = $(this).data('id');

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to recover this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, delete it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('operator.delete') }}",
                                type: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    id: id
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            title: "Deleted!",
                                            text: "Operator data has been removed.",
                                            icon: "success",
                                            timer: 10000, // Auto-close after 10 seconds
                                            confirmButtonText: "OK"
                                        }).then(() => {
                                            location.reload(); // Refresh AFTER alert closes
                                        });
                                    } else {
                                        Swal.fire("Error!", "Failed to delete Operator.", "error");
                                    }
                                }

                            });
                        }
                    });
                });

            });
        </script>

</body>

</html>