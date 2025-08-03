{{-- filepath: resources/views/casher/exports/ordered_foods_report.blade.php --}}
@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html>
<head>
    <title>Ordered Foods Report</title>
    <style>
 body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            background: #f8f9fa;
            color: #222;
        }
        .header {
            text-align: center;
            margin-bottom: 10px;
        }
        .header h2 {
            color: #2c3e50;
            margin-bottom: 2px;
        }
        .header small {
            color: #888;
        }
        .summary-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 18px 24px;
            margin: 0 auto 18px auto;
            max-width: 600px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
        }
        .summary-card span {
            display: inline-block;
            margin-right: 18px;
        }
        .filter-info {
            margin: 18px auto 0 auto;
            text-align: center;
            background: #e9ecef;
            border-radius: 6px;
            padding: 10px 0;
            font-size: 14px;
            max-width: 600px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 18px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px #0001;
        }
        th {
            background: #2c3e50;
            color: #fff;
            font-weight: 600;
            padding: 10px 6px;
            border-bottom: 2px solid #dee2e6;
        }
        td {
            padding: 8px 6px;
            border-bottom: 1px solid #e9ecef;
        }
        tr:last-child td {
            border-bottom: none;
        }
        .status-paid {
            color: #27ae60;
            font-weight: bold;
        }
        .status-unpaid {
            color: #e67e22;
            font-weight: bold;
        }
        .no-data {
            color: #888;
            font-style: italic;
            text-align: center;
            padding: 24px 0;
        }
    </style>
</head>
<body>
     <div style="display: flex; padding-bottom: 10px; border-bottom: 2px solid #da1e1e; margin-bottom: 10px;">
    <!-- Left: Horizontal Row - Rest + Logo + Food -->
    <div style="text-align: left;  margin-top:15px;">
    <span style="font-size: 3rem; font-weight: 800; color: #2c3e50;">Rest</span>
    <img src="{{ public_path('icons/RestFood-Icon.png') }}" alt="Rest Food Icon" style="height:55px; width:55px; border-radius:6px; box-shadow:0 2px 6px #0001;">
    <span style="font-size: 3rem; font-weight: 800; color: #2c3e50;">Food</span>
</div>

    <!-- Right: Restaurant Info -->
    <div style="text-align: right;">
        <div style="font-size: 14px; color: #333; ">
            <div>Best Fast Food Restaurant</div>
            <div>Address: 123 Main St, Baghdad</div>
            <div>Phone: +964 123 456 7890</div>
            <div>Email: info@restfood.com</div>
        </div>
        <div style="font-size: 13px; color: #666; margin-top: 5px;">
            Generated at: {{ now()->format('Y-m-d H:i') }}
        </div>
    </div>
</div>
    <h2 style="text-align:center; color:#2c3e50; margin: 0 0 8px 0;"> Ordered Foods Report</h2>
     <div class="filter-info">
        <strong>From:</strong>
        {{ $from ? Carbon::parse($from)->format('Y-m-d') : 'All' }}
        &nbsp;|&nbsp;
        <strong>To:</strong>
        {{ $to ? Carbon::parse($to)->format('Y-m-d') : 'All' }}
        &nbsp;|&nbsp;
        <strong>Cashier:</strong> {{ $cashierName }}
        
    </div>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Food Item</th>
                <th>Total Quantity</th>
                <th>Total Revenue (IQD)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($foods as $row)
                <tr>
                    <td>{{ $row->date }}</td>
                    <td>{{ $row->food->name_en ?? 'Unknown' }}</td>
                    <td>{{ $row->total_quantity }}</td>
                    <td>{{ number_format($row->total_revenue) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="no-data">No food data found.</td>
                </tr>
            @endforelse
        </tbody>
        
        
    </table>
    <div style="position: fixed; bottom: 20px; left: 0; right: 0; text-align: center; font-size: 11px; color: #aaa;">
    © {{ date('Y') }} Rest Food. All rights reserved.
</div>
</body>
</html>