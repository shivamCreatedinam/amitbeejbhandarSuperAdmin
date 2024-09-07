<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quote</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #ebe2c5 !important; /* Updated background color */
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        h1, h2 {
            color: #007BFF;
        }
        p {
            line-height: 1.6;
            margin: 0 0 10px;
        }
        .button {
            display: inline-block;
            padding: 7px 14px;
            font-size: 16px;
            color: #fff !important;
            background-color: #007BFF;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            border: none;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quote for You</h1>
        <p>Dear <strong>{{$name}}</strong>,</p>
        <p>{{ $messageContent }}</p>
        <p>If you have any questions, feel free to <a href="mailto:{{$company_email}}" class="button">Contact Us</a>.</p>
        <div class="footer">
            <p>Thank you for choosing our service!</p>
            <p>&copy; {{ date('Y') }} {{ucfirst($company_name)}}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
