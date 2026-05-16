<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Summary | Millenium</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #8B1C3A;
            --gold: #D4A574;
            --text: #1a1a1a;
        }
        body {
            font-family: 'Inter', sans-serif;
            color: var(--text);
            margin: 0;
            padding: 50px;
            background: white;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 3px solid var(--primary);
            padding-bottom: 20px;
            margin-bottom: 40px;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: bold;
            color: var(--primary);
        }
        .logo span { color: var(--gold); }
        .report-info { text-align: right; }
        .report-info h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .report-info p { margin: 5px 0 0; color: #666; font-size: 12px; }

        .stats-grid {
            display: grid;
            grid-template-cols: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 50px;
        }
        .stat-card {
            background: #fafafa;
            padding: 20px;
            border-radius: 15px;
            border: 1px solid #eee;
            text-align: center;
        }
        .stat-card h3 {
            margin: 0;
            font-size: 10px;
            text-transform: uppercase;
            color: #999;
            letter-spacing: 1px;
        }
        .stat-card p {
            margin: 10px 0 0;
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
        }

        h2 {
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-left: 4px solid var(--primary);
            padding-left: 15px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        th {
            text-align: left;
            background: #f8f8f8;
            padding: 12px 15px;
            font-size: 11px;
            text-transform: uppercase;
            color: #666;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 11px;
            color: #999;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <div class="logo">Mille<span>nium</span></div>
        <div class="report-info">
            <h1>Executive Report</h1>
            <p>Generated on {{ date('F d, Y | H:i') }}</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Sales</h3>
            <p>{{ number_format($totalSales) }} FCFA</p>
        </div>
        <div class="stat-card">
            <h3>Total Orders</h3>
            <p>{{ $totalOrders }}</p>
        </div>
        <div class="stat-card">
            <h3>Registered Users</h3>
            <p>{{ $totalCustomers }}</p>
        </div>
        <div class="stat-card">
            <h3>Reservations</h3>
            <p>{{ $totalReservations }}</p>
        </div>
    </div>

    <h2>Recent Transactions Breakdown</h2>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Items Summary</th>
                <th>Payment Method</th>
                <th>Date</th>
                <th style="text-align: right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentSales as $sale)
                <tr>
                    <td style="font-family: monospace; font-weight: 700">#{{ substr($sale->id, -8) }}</td>
                    <td>{{ $sale->items }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                    <td style="text-align: right; font-weight: 700; color: var(--primary)">{{ number_format($sale->amount) }} FCFA</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Operational Summary</h2>
    <p style="font-size: 14px; color: #444; line-height: 1.6;">
        This report consolidates the performance metrics for <strong>Millenium</strong> as of {{ date('l, F d, Y') }}. 
        The current revenue of <strong>{{ number_format($totalSales) }} FCFA</strong> reflects the ongoing operational activities across all service modes including in-house dining and delivery services. 
        With a total of <strong>{{ $totalOrders }}</strong> orders processed and <strong>{{ $totalReservations }}</strong> reservations managed, the platform continues to demonstrate stable engagement from our <strong>{{ $totalCustomers }}</strong> registered clients.
    </p>

    <div class="footer">
        <p>© {{ date('Y') }} Millenium Management Platform • Internal Use Only</p>
    </div>
</body>
</html>
