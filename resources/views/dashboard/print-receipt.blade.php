{-- Print Receipt View --}
{-- This view handles the display and user interaction for Print Receipt. --}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ substr($order->id, -6) }} | Millenium</title>
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
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background: white;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            border: 1px solid #f0f0f0;
            padding: 40px;
            border-radius: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid var(--primary);
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            font-weight: bold;
            color: var(--primary);
            text-decoration: none;
            display: block;
            margin-bottom: 5px;
        }
        .logo span { color: var(--gold); }
        .receipt-title {
            text-transform: uppercase;
            letter-spacing: 3px;
            font-size: 12px;
            font-weight: 800;
            color: #666;
        }
        .info-grid {
            display: grid;
            grid-template-cols: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            font-size: 13px;
        }
        .info-item label {
            display: block;
            text-transform: uppercase;
            font-size: 10px;
            font-weight: 800;
            color: #999;
            margin-bottom: 2px;
        }
        .info-item p {
            margin: 0;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            color: #999;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 10px;
        }
        td {
            padding: 15px 0;
            border-bottom: 1px solid #fafafa;
            font-size: 14px;
        }
        .qty { font-weight: 700; color: var(--primary); }
        .price { text-align: right; font-weight: 600; }
        .totals {
            border-top: 2px solid var(--text);
            padding-top: 20px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .grand-total {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary);
        }
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px dashed #ddd;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body { padding: 0; }
            .container { border: none; width: 100%; max-width: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="header">
            <div class="logo">Mille<span>nium</span></div>
            <div class="receipt-title">Order Receipt</div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <label>Order ID</label>
                <p>#{{ strtoupper(substr($order->id, -8)) }}</p>
            </div>
            <div class="info-item">
                <label>Date & Time</label>
                <p>{{ $order->created_at->format('M d, Y | H:i') }}</p>
            </div>
            <div class="info-item">
                <label>Customer</label>
                <p>{{ $order->user->name ?? 'Guest Customer' }}</p>
            </div>
            <div class="info-item">
                <label>Service Mode</label>
                <p>
                    @if($order->service_type === 'delivered')
                        Delivery ({{ $order->location }})
                    @else
                        Table {{ $order->table->title ?? 'N/A' }}
                    @endif
                </p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Item Description</th>
                    <th>Qty</th>
                    <th style="text-align: right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td style="font-weight: 600">{{ $item['name'] }}</td>
                        <td class="qty">{{ $item['qty'] }}</td>
                        <td class="price">{{ number_format($item['price'] * $item['qty']) }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row">
                <span style="font-weight: 600">Subtotal</span>
                <span>{{ number_format($order->total_price) }} FCFA</span>
            </div>
            <div class="total-row grand-total">
                <span>Total</span>
                <span>{{ number_format($order->total_price) }} FCFA</span>
            </div>
        </div>

        <div class="footer">
            <p>Thank you for choosing <strong>Millenium</strong>.</p>
            <p>Please keep this receipt for your records.</p>
            <p style="font-size: 10px; margin-top: 10px; color: #999">Printed on {{ date('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
