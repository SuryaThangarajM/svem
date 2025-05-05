<!DOCTYPE html>
<html lang="ta">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { border: 2px solid blue; padding: 20px; width: 90%; margin: auto; }
        .header { text-align: center; font-size: 18px; font-weight: bold; color: blue; }
        .section { margin-top: 10px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .label { font-weight: bold; }
        .signatures { display: flex; justify-content: space-between; margin-top: 40px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            SRI VINAYAGA EARTH MOVERS<br>
            <span style="font-family: 'NotoSansTamil';">சிறு வினாயக எர்த் மூவர்ஸ்</span><br>
            HP Petrol Bunk, Mettukadai, Erode - 12<br>
            📞 75022 62003, 97886 24505
        </div>

        <div class="section">
            <div class="row">
                <span class="label" style="margin-right: 10px;">No: A</span> <span>{{ $data['receipt_no'] }}</span>
            </div>
            <div class="row">
                <span class="label" style="margin-right: 10px;">Vehicle No:</span> <span>{{ $data['vehicle_no'] }}</span>
                <span class="label" style="margin-left: 20px; margin-right: 10px;">Date:</span> <span>{{ $data['date'] }}</span>
            </div>
            <div class="row">
                <span class="label">Customer Name:</span> <span>{{ $data['customer_name'] }}</span>
            </div>
        </div>

        <div class="section">
            <div class="row">
                <span class="label">Start Time:</span> <span>{{ $data['start_time'] }}</span>
            </div>
            <div class="row">
                <span class="label">End Time:</span> <span>{{ $data['end_time'] }}</span>
            </div>
            <div class="row">
                <span class="label">Total Hours:</span> <span>{{ $data['total_hours'] }}</span>
            </div>
        </div>

        <div class="signatures">
            <span>Signature: {{ $data['signatures'][0] }}</span>
            <span>Owner's Signature: {{ $data['signatures'][1] }}</span>
        </div>
    </div>

</body>
</html>
