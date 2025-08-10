{{-- filepath: resources/views/casher/exports/ordered_foods_report.blade.php --}}
@php use Carbon\Carbon; @endphp
<!DOCTYPE html>
<html lang="ckb" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ __('words.Ordered Foods Report') }}</title>
   <style>
        @font-face {
            font-family: 'RudawRegular';
            src: url('fonts/RudawRegular.ttf') format('truetype');
            font-weight: normal;
            font-style: normal;
        }

        /* @font-face {
            font-family: 'NotoKufiArabic';
            src: url('../fonts/NotoKufiArabic-VariableFont_wght.ttf') format('truetype');
        } */

        body {
            background: #fff;
            color: #222;
            margin: 0;
            padding: 0;
            direction: rtl;
        }

        body,
        table,
        th,
        td,
        .report-table,
        .filter-info {
            font-family: 'RudawRegular', Arial, sans-serif !important;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 32px 24px;
            background: #fff;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #da1e1e;
            padding-bottom: 18px;
            margin-bottom: 24px;
        }

        .brand {
            display: flex;
            align-items: flex-end;
            gap: 18px;
        }

        .brand-title {
            font-size: 2.2rem;
            font-weight: 900;
            color: #da1e1e;
            letter-spacing: 2px;
            align-items: flex-start;

        }

        .brand-logo {
            height: 60px;
            width: 60px;
            border-radius: 10px;
            box-shadow: 0 4px 12px #da1e1e22;
        }

        .restaurant-info {
            text-align: right;
            min-width: 260px;
            font-size: 1rem;
            color: #222;
        }

        .restaurant-info .subtitle {
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 2px;
        }

        .restaurant-info .details {
            font-size: 0.95rem;
            color: #444;
        }

        .restaurant-info .generated {
            font-size: 0.9rem;
            color: #888;
            margin-top: 7px;
        }

        h2 {
            text-align: center;
            color: #da1e1e;
            margin: 18px 0 8px 0;
            font-size: 1.7rem;
            font-weight: bold;
        }

        .filter-info {
            text-align: center;
            margin-bottom: 18px;
            font-size: 1rem;
            color: #444;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 32px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #dee2e6;
            padding: 12px 8px;
            text-align: center;
            font-size: 1rem;
        }

        .report-table th {
            background: #da1e1e;
            color: #fff;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.95rem;
        }

        .badge-success {
            background: #28a745;
            color: #fff;
        }

        .badge-warning {
            background: #ffc107;
            color: #222;
        }

        .badge-info {
            background: #17a2b8;
            color: #fff;
        }

        .badge-primary {
            background: #da1e1e;
            color: #fff;
        }

        .badge-light {
            background: #f8f9fa;
            color: #222;
        }

        .badge-danger {
            background: #dc3545;
            color: #fff;
        }

        .footer {
            text-align: center;
            color: #888;
            font-size: 0.95rem;
            margin-top: 32px;
        }

        @media (max-width: 600px) {
            .container {
                padding: 8px;
            }

            h2 {
                font-size: 1.2rem;
            }

            .report-table th,
            .report-table td {
                font-size: 0.9rem;
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
         <!-- Header -->
        <div class="header" dir="rtl">

            <div class="restaurant-info justify-content-start">
                <div class="subtitle">Best Fast Food Restaurant</div>
                <div class="details">
                   <span style="font-family: 'NotoKufiArabic', 'RudawRegular', Arial, sans-serif;">
                        {{ __('words.Address') }}: 
                    </span>
                     <span dir="ltr">
                         123 Main St ،Baghdad</span><br>
                    <span style="font-family: 'NotoKufiArabic', 'RudawRegular', Arial, sans-serif; direction: ">
                        {{ __('words.Phone') }}:
                    </span>
                    <span dir="ltr">
                        0770 128 58 52 </span><br>
                    <span style="font-family: 'NotoKufiArabic', 'RudawRegular', Arial, sans-serif;">
                        {{ __('words.Email') }}: info@restfood.com</span>
                </div>

            </div>
            <div class="brand">
                <span class="brand-title justify-content-end">Rest</span>
                <img src="{{ public_path('icons/RestFood-Icon.png') }}" alt="Rest Food Icon" class="brand-logo">
                <span class="brand-title">Food</span>
            </div>
        </div>

        <!-- Title & Filters -->
        <h2>{{ __('words.Ordered Foods Report') }}</h2>
        <div class="filter-info">
            <strong>{{ __('words.From') }}:</strong> {{ $from ? Carbon::parse($from)->format('Y-m-d') : __('words.All') }}
            &nbsp;|&nbsp;
            <strong>{{ __('words.To') }}:</strong> {{ $to ? Carbon::parse($to)->format('Y-m-d') : __('words.All') }}
            &nbsp;|&nbsp;
            <strong>{{ __('words.Cashier') }}:</strong> {{ $cashierName }}
            &nbsp;|&nbsp;
            <strong>{{ __('words.Table') }}:</strong> {{ $tableNumber }}
        </div>

        <!-- Foods Table -->
        <table class="report-table">
            <thead>
                <tr>
                    <th>{{ __('words.Date') }}</th>
                    <th>{{ __('words.Food Name') }}</th>
                    <th>{{ __('words.Quantity') }}</th>
                    <th>{{ __('words.Total Price') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($foods as $food)
                    <tr>
                        <td>{{ $food->date }}</td>
                        <td>{{ $food->food->name_ckb ?? __('words.Unknown') }}</td>
                        <td>
                            <span class="badge badge-primary">{{ $food->total_quantity }}</span>
                        </td>
                        <td>
                            <span class="badge badge-success">{{ number_format($food->total_revenue) }} {{ __('words.IQD') }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-4">
                            {{ __('words.No food records found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background:#f7f7f7; font-weight:bold; font-size: 16px;">
                    <td colspan="4" style="text-align:center;">
                        <span style="margin-right:24px;"><strong>{{ __('words.Total Quantity') }} خواردن : </strong> {{ $totalQuantity }} </span>
                        <span><strong> || {{ __('words.Total Revenue') }}:</strong> {{ number_format($totalRevenue) }} {{ __('words.IQD') }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer -->
        <div class="footer" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 0 8px; box-sizing: border-box;">
            <span style="text-align: right;">
            {{ __('words.Printed by') }}: {{ auth()->user()->username ?? __('words.Unknown') }}
            </span>
            <span style="text-align: left;">
            {{ __('words.Printed at') }}: {{ Carbon::now()->format('Y-m-d H:i') }}
            </span>
        </div>
    </div>
</body>
</html>