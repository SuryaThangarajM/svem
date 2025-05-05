<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Reports</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/cusopr.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <!-- Container with border -->
    <div class="container mt-5">
        <h2>Vehicle's Reports</h2>
        <!-- Customer Info Form -->
        <form class="row g-3">
            <div class="col-6 col-md-4">
                <label for="date" class="form-label">From Date</label>
                <input type="date" class="form-control form-control-sm" id="fromdate" name="fromdate" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="date" class="form-label"> To Date </label>
                <input type="date" class="form-control form-control-sm" id="todate" name="todate" required>
            </div>

            <!-- Vehicle ID Dropdown -->
            <div class="col-6 col-md-4">
                <label for="vehicle_id" class="form-label"> Vehicle ID </label>
                <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                    <option value="">Select Vehicle</option>
                    @foreach($vehiids as $vehiid)
                    <option value="{{ $vehiid }}">{{ $vehiid }}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-6 col-md-4">
                <label class="form-label d-block">Select Payment Method</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="CheckType" id="totchk">
                    <label class="form-check-label" for="totaltime">TotalTime Check</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="CheckType" id="expchk">
                    <label class="form-check-label" for="expense">Expense Check</label>
                </div>

            </div>

            <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>
            </div>
        </form>

        <!-- Table to show customer data -->
        <div class="table-container" id="tablevehi" style="overflow-x: auto; display: none;">
            <div id="billTableBody"></div>
        </div>
        <div id="paginationLinks"></div>
    </div>
    <script>
        const vehichkFetchUrl = "{{ route('gettotvehichk') }}";
    </script>
    <script src="{{ asset('assets/js/vehireports.js') }}"></script>

</body>

</html>