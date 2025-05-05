<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Bill Details</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/cusopr.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


    <style>
        .col-bill-date {
            white-space: nowrap;
        }
    </style>


</head>

<body>
    <!-- Container with border -->
    <div class="container mt-5">
        <h2>All Bill Details</h2>
        <!-- Customer Info Form -->
        <form class="row g-3">

            <div class="col-6 col-md-4">
                <label for="date" class="form-label">From Date</label>
                <input type="date" class="form-control form-control-sm" id="fromdate" name="fromdate" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="date" class="form-label">
                    To Date
                    <span class="fa fa-search search" id="date" style="margin-left: 5px; color:rgb(255, 0, 0); cursor: pointer;"></span>
                </label>
                <input type="date" class="form-control form-control-sm" id="todate" name="todate" required>
            </div>
            <div class="col-6 col-md-4">
                <label for="customer_name" class="form-label">
                    Customer Name
                    <span class="fa fa-search search" id="cusname" style="margin-left: 5px; color:rgb(255, 0, 0); cursor: pointer;"></span>
                </label>
                <select class="form-control" id="customer_name" name="customer_name" required>
                    <option value="">Select Customer</option>
                    @foreach($cusnames as $cusname)
                    <option value="{{ $cusname }}">{{ $cusname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label for="name" class="form-label">
                    Pending All Amount
                    <span class="fa fa-search search" id="allpenamnt" style="margin-left: 5px; color:rgb(255, 0, 0); cursor: pointer;"></span>
                </label>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>

            </div>
        </form>

        <!-- Table to show customer data -->
        <!-- Make the whole thing horizontally scrollable -->
        <div class="table-container" style="overflow-x: auto;">
            <!-- Set a wide container to hold both table and total amount -->
            <div style="min-width: 1200px;">

                <!-- Your Table -->
                <table class="table table-striped table-bordered mt-4" id="operatorTable">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>BillNo</th>
                            <th class="col-bill-date">BillDate</th>
                            <th>CusName</th>
                            <th>CusMobNo</th>
                            <th>CusAddress</th>
                            <th>OprName</th>
                            <th>VehiID</th>
                            <th>Works</th>
                            <th>StartTime</th>
                            <th>EndTime</th>
                            <th>TotalTime</th>
                            <th>TotalAmount</th>
                            <th>Paid</th>
                            <th>Balance</th>
                        </tr>
                    </thead>
                    <tbody id="billTableBody">
                        @foreach($billall as $bill)
                        <tr>
                            <td>{{ $loop->iteration + ($billall->firstItem() - 1) }}</td>
                            <td>{{ $bill->BillNo }}</td>
                            <td class="col-bill-date">{{ $bill->BillDate->format('d-m-Y') }}</td>
                            <td>{{ $bill->CusName }}</td>
                            <td>{{ $bill->CusMobNo }}</td>
                            <td>{{ $bill->CusAddress }}</td>
                            <td>{{ $bill->OprName }}</td>
                            <td>{{ $bill->VehiID }}</td>
                            <td>{{ $bill->Works }}</td>
                            <td>{{ $bill->StartTime }}</td>
                            <td>{{ $bill->EndTime }}</td>
                            <td>{{ $bill->TotalTime }}</td>
                            <td>{{ $bill->TotalAmount }}</td>
                            <td>{{ $bill->Paid }}</td>
                            <td>{{ $bill->Balance }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Total aligned to right end -->
                <div style="text-align: right; padding: 10px 0; font-weight: bold;">
                    Over All Amount : <span id="totalAmount" style="color: red;">₹{{ number_format($TotAmnt, 2) }}</span>
                </div>
                <div style="text-align: right; padding: 10px 0; font-weight: bold;">
                    Over All Paid : <span id="totalPaid" style="color: red;">₹{{ number_format($TotPaid, 2) }}</span>
                </div>
                <div style="text-align: right; padding: 10px 0; font-weight: bold;">
                    Over All Balance : <span id="totalBalance" style="color: red;">₹{{ number_format($TotBal, 2) }}</span>
                </div>

            </div>
        </div>
        <div id="paginationLinksbillall">
            @include('partials.billall-pagination', ['billall' => $billall])
        </div>
    </div>
    </div>
    <script>
        const billallnewFetchUrl = "{{ route('getbillallNew') }}";
        const customerUpdateUrl = "{{ route('customer.update') }}";
        const customerDeleteUrl = "{{ route('customer.delete') }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('assets/js/billall.js') }}"></script>
    <script src="assets/js/cusopr.js"></script>
</body>

</html>