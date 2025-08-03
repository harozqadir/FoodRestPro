@php use Carbon\Carbon; @endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoices Report</title>
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
<div class="d-flex justify-content-between align-items-center ">
    <div class="mb-4" >
         <!-- Left: Horizontal Row - Rest + Logo + Food -->   
    <span style="font-size: 3rem; font-weight: 800; color: #2c3e50;">Rest</span>
    <img src="{{ public_path('icons/RestFood-Icon.png') }}" alt="Rest Food Icon" style="height:55px; width:55px; border-radius:6px; box-shadow:0 2px 6px #0001;">
    <span style="font-size: 3rem; font-weight: 800; color: #2c3e50;">Food</span>

    </div>

    <div>
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

    </div>
<body>
   <div style="display: flex; padding-bottom: 10px; border-bottom: 2px solid #da1e1e; margin-bottom: 10px;">
    

    
</div>
    <h2 style="text-align:center; color:#2c3e50; margin: 0 0 8px 0;">Invoices Report</h2>
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
                <th>Invoice ID</th>
                <th>Table No.</th>
                <th>Cashier</th>
                <th>Total (IQD)</th>
                <th>Status</th>
                <th>Invoice Date</th>
            </tr>
        </thead>
        <tbody>
        @forelse($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>Table {{ $invoice->table->table_number ?? 'N/A' }}</td>
                <td>{{ $invoice->creator->username ?? 'N/A' }}</td>
                <td>{{ number_format($invoice->total_price) }}</td>
                <td>
                    @if ($invoice->status === 'Paid' || $invoice->status == 2)
                        <span class="status-paid">Paid</span>
                    @elseif ($invoice->status === 'Ordered' || $invoice->status == 1)
                        <span class="status-unpaid">Unpaid</span>
                    @else
                        {{ $invoice->status }}
                    @endif
                </td>
                <td>{{ $invoice->created_at ? Carbon::parse($invoice->created_at)->format('Y-m-d H:i') : '-' }}</td>
            
            </tr>
        @empty
            <tr>
                <td colspan="6" class="no-data">No invoice records found.</td>
            </tr>
        @endforelse
        </tbody>
        
        <tfoot>
            <tr style="background:#f7f7f7; font-weight:bold; font-size: 16px; mb-3 ">
                <td colspan="6" style="text-align:center;">
                    <span style="margin-right:24px;"><strong>Total Sales:</strong> IQD {{ number_format($totalSales) }}</span>
                    <span style="margin-right:24px;"><strong>Total Invoices:</strong> {{ $invoices->count() }}</span>
                    <span><strong>Unpaid:</strong> {{ $unpaidCount }}</span>
                </td>
            </tr>
        </tfoot>
    </table>

   <div style="position: fixed; bottom: 20px; left: 0; right: 0; text-align: center; font-size: 11px; color: #aaa;">
    © {{ date('Y') }} Rest Food. All rights reserved.
</div>
</body>

</html>
