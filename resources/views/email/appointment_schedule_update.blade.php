<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Update</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }
        .content {
            padding: 20px;
            color: #333333;
        }
        .content h2 {
            margin-top: 0;
        }
        .appointment-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #4CAF50;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 12px;
        }
        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Appointment Schedule Update</h1>
        </div>
        <div class="content">
            <h2>Dear {{ $data->first_name}} {{ $data->last_name}},</h2>
            <p>Your appointment schedule has been updated and your appointment has been accepted and pay now :</p>
            <div class="appointment-details">
                <p><strong>New Date:</strong> {{ $data->appointment_date ?? '' }}</p>
                <p><strong>Available Time:</strong>{{ $data->appointment_time ?? ''}}-{{ $data->available_times ?? '' }}</p>
                <p><strong>Available Day:</strong> {{ $data->available_day ?? '' }}</p>

                <a href="" class="button">Pay Now</a>
                <hr>

                Note: {{ $data->note ?? '' }}

            </div>
            
        </div>
        <div class="footer">
            <p>Thank you for choosing our service. We look forward to seeing you!</p>
            <p>© 2025 Jingduanyang. All Rights Reserved.</p>
        </div>
    </div>
</body>
</html>
