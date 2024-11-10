<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }
        .invoice-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 800px;
            margin: auto;
        }
        .header {
            text-align: center;
        }
        .header h1 {
            background-color: black;
            color: white;
            padding: 10px;
            display: inline-block;
        }
        .billing-info, .terms {
            margin-top: 20px;
        }
        .billing-info p, .terms p {
            font-size: 14px;
            margin: 2px 0;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: black;
            color: white;
        }
        .totals {
            text-align: right;
            margin-top: 20px;
        }
        .totals h3, .totals p {
            margin: 5px 0;
        }
        .terms p {
            font-size: 12px;
            color: gray;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="header">
            <h1>INVOICE</h1>
            <p>Invoice #: 00000A</p>
        </div>

        <!-- Project Name -->
        <div class="project">
            <h3>DESIGN PROJECT NAME</h3>
        </div>

        <!-- Billing Information -->
        <div class="billing-info">
            <h3>BILLING TO:</h3>
            <p>Client's name</p>
            <p>Street Avenue 10019</p>
            <p>Miami, FL</p>
        </div>

        <!-- Product Table -->
        <table>
            <thead>
                <tr>
                    <th>PRODUCT</th>
                    <th>PRICE</th>
                    <th>QTY</th>
                    <th>TOTAL</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Logo Design</td>
                    <td>$0.00</td>
                    <td>0</td>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <td>Brand Identity</td>
                    <td>$0.00</td>
                    <td>0</td>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <td>Website Design</td>
                    <td>$0.00</td>
                    <td>0</td>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <td>Stationery Design</td>
                    <td>$0.00</td>
                    <td>0</td>
                    <td>$0.00</td>
                </tr>
                <tr>
                    <td>Updatings</td>
                    <td>$0.00</td>
                    <td>0</td>
                    <td>$0.00</td>
                </tr>
            </tbody>
        </table>

        <!-- Totals Section -->
        <div class="totals">
            <h3>SUB TOTAL: $0.00</h3>
            <p>TAX: 0.00%</p>
            <h3>TOTAL: $0.00</h3>
        </div>

        <!-- Terms & Conditions -->
        <div class="terms">
            <h3>TERMS & CONDITIONS:</h3>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
        </div>
    </div>
</body>
</html>
