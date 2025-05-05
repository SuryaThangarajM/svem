<div class="table-responsive mt-4">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Bill Date</th>
                <th>Vehicle ID</th>
                <th>Head</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            @php $serial = $expall->firstItem(); @endphp
            @foreach ($expall as $index => $exp)
            <tr>
                <td>{{ $serial + $index }}</td>
                <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($exp->BillDate)->format('d-m-Y') }}</td>
                <td>{{ $exp->oprvehiid }}</td>
                <td>{{ $exp->head }}</td>
                <td>{{ number_format($exp->ExpAmt, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="text-align: right; padding: 10px 0; font-weight: bold;">
    Total Amount : <span style="color: red;">₹{{ number_format($TotalAmount, 2) }}</span>
</div>