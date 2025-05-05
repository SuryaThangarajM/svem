<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Expense Details</title>
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
        <h2>Income Expense Details</h2>

        <!-- Customer Info Form -->
        <form class="row g-3" autocomplete="off">
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
            <div class="col-12 d-flex justify-content-center">
                <button type="button" class="btn btn-secondary me-2" onclick="window.location.href='/'">Close</button>
            </div>
        </form>

        <!-- Table to show customer data -->
        <!-- Make the whole thing horizontally scrollable -->
        <!-- <div class="table-container" style="overflow-x: auto;"> -->
        <!-- Set a wide container to hold both table and total amount -->
        <!-- <div style="min-width: 1200px;"> -->

        <!-- Total aligned to right end -->
        <div style="text-align: center; padding: 10px 0; font-weight: bold;">
            Income : <span id="income" style="color: red;">₹{{ number_format($paidTotal, 2) }}</span>
        </div>
        <div style="text-align: center; padding: 10px 0; font-weight: bold;">
            Expense : <span id="expense" style="color: red;">₹{{ number_format($expenseTotal, 2) }}</span>
        </div>
        <div style="text-align: center; padding: 10px 0; font-weight: bold;">
            Profit: <span id="profit" style="color: red;">₹{{ number_format($profit, 2) }}</span>
        </div>

        <!-- </div>
        </div> -->
    </div>
    <script>
        const incexpFetchUrl = "{{ route('getExpenseDateWise') }}";
    </script>
    <script src="{{ asset('assets/js/incexp.js') }}"></script>
</body>

</html>