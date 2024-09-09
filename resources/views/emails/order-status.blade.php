<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        table {
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
            border-spacing: 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        td {
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: #4CAF50;
            margin-bottom: 10px;
        }
        p {
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }
        .status-accepted {
            color: #4CAF50;
        }
        .status-cancelled {
            color: #FF6347;
        }
        .order-details {
            margin: 20px 0;
            font-size: 15px;
            text-align: left;
        }
        .footer {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <table>
        <tr>
            <td>
                <h1>Order Status Update</h1>
                <p>Hello <strong>{{customer_name}}</strong>,</p>
                <p>We wanted to inform you that the status of your order <strong>#{{order_number}}</strong> has been updated.</p>

                <div class="order-details">
                    <p><strong>Order Date:</strong> {{order_date}}</p>
                    <p><strong>Current Status:</strong>
                        <span class="{{order_status == 'Accepted' ? 'status-accepted' : 'status-cancelled'}}">
                            {{order_status}}
                        </span>
                    </p>
                </div>

                <p>If you have any questions or need further assistance, feel free to contact us at <a href="mailto:{{$company_email}}">{{$company_email}}</a>.</p>
            </td>
        </tr>
        <tr>
            <td class="footer">
                <p>Thank you for choosing our service!</p>
                <p>&copy; {{ date('Y') }} {{ucfirst($company_name)}}. All rights reserved.</p>
            </td>
        </tr>
    </table>
</body>
</html>
