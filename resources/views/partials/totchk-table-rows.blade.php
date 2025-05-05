<div class="table-responsive mt-4">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>S.NO</th>
                <th>Bill Date</th>
                <th>Vehicle ID</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Total Time</th>
            </tr>
        </thead>
        <tbody>
            @php $serial = $billall->firstItem(); @endphp
            @foreach ($billall as $index => $bill)
            <tr>
                <td>{{ $serial + $index }}</td>
                <td style=" white-space: nowrap;">{{ \Carbon\Carbon::parse($bill->BillDate)->format('d-m-Y') }}</td>
                <td>{{ $bill->VehiID }}</td>
                <td>{{ $bill->StartTime }}</td>
                <td>{{ $bill->EndTime }}</td>
                <td>{{ $bill->TotalTime }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div style="text-align: right; padding: 10px 0; font-weight: bold;">
    Over All Time: <span style="color: red;">{{ number_format($TotTime, 2) }}</span>
</div>