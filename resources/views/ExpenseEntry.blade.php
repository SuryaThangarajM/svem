<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> <!-- ✅ Important for JS -->
    <title>Expense Entry Form</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">



    <link rel="stylesheet" href="assets/css/cusopr.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        .col-bill-date {
            white-space: nowrap;
        }
    </style>

</head>

<body>
    <!-- Container with border -->
    <div class="container mt-5">
        @if(session('success'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    location.reload();
                });
            });
        </script>
        @endif

        <h2>Expense Entry Form</h2>
        <!-- Customer Info Form -->
        <form action="{{ route('storeexp') }}" method="post" id="customerForm" class="row g-3" autocomplete="off">
            @csrf
            <div class="col-6 col-md-4">
                <label for="date" class="form-label">Select Date</label>
                <input type="date" class="form-control form-control-sm" id="date1" name="date" required>
            </div>

            <div class="col-12 col-md-4">
                <label for="entity" class="form-label">Select or Enter Operator / Vehicle</label>
                <input class="form-control" list="entityOptions" id="entity" name="entity" required autocomplete="off">
                <datalist id="entityOptions">
                    <option value="COMPANY"></option>
                    @foreach($oprnames as $oprname)
                    <option value="{{ $oprname }}"></option>
                    @endforeach
                    @foreach($vehiids as $vehiid)
                    <option value="{{ $vehiid }}"></option>
                    @endforeach
                </datalist>
            </div>

            <div class="col-6 col-md-4">
                <label for="works" class="form-label">Head</label>
                <input type="text" class="form-control form-control-sm" id="head" name="head" autocomplete="off">
            </div>

            <div class="col-6 col-md-4">
                <label for="totamt" class="form-label">Expense Amount</label>
                <input type="number" class="form-control form-control-sm" id="totamt" name="totamt" min="0" required autocomplete="off">
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary me-2">Submit</button>
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>
            </div>
        </form>

        <!-- Table to show customer data -->
        <div class="table-container">
            <table class="table table-striped table-bordered table-responsive mt-4" id="expenseTable">
                <thead>
                    <tr>
                        <th>S.No</th>
                        <th>Bill Date</th>
                        <th>Operator/Vehicle ID</th>
                        <th>Head</th>
                        <th>Expense Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration + ($expenses->firstItem() - 1) }}</td> <!-- Auto Serial Number -->
                        <td class="col-bill-date">{{ $expense->BillDate->format('d-m-Y') }}</td>
                        <td>{{ $expense->oprvehiid }}</td>
                        <td>{{ $expense->head }}</td>
                        <td>{{ $expense->ExpAmt }}</td>
                        <td>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $expense->id }}">Delete</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="d-flex flex-column align-items-center mt-3">
                <!-- Visible on mobile only -->
                <p class="text-muted text-center d-md-none">
                    Showing {{ $expenses->firstItem() }} to {{ $expenses->lastItem() }} of {{ $expenses->total() }} results
                </p>
                <div class="table-responsive">
                    {{ $expenses->links('pagination::bootstrap-5') }}
                </div>
                <!-- Visible on desktop only -->
                <p class="text-muted text-center d-none d-md-block">
                    Showing {{ $expenses->firstItem() }} to {{ $expenses->lastItem() }} of {{ $expenses->total() }} results
                </p>
            </div>
        </div>

    </div>
</body>
<!-- AJAX Script to Fetch Data and Update Table -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/exp.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>