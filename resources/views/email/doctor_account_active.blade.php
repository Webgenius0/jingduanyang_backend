<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account Activation Email</title>
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
      background: #ffffff;
      border: 1px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
    }
    .header {
      background: #007bff;
      color: #ffffff;
      text-align: center;
      padding: 20px;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
    }
    .content {
      padding: 20px;
    }
    .content h2 {
      color: #333333;
    }
    .content p {
      color: #555555;
      line-height: 1.6;
    }
    .content a {
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      color: #ffffff;
      background: #007bff;
      text-decoration: none;
      border-radius: 4px;
    }
    .content a:hover {
      background: #0056b3;
    }
    .footer {
      text-align: center;
      padding: 10px;
      background: #f4f4f4;
      color: #777777;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">
      <h1>Welcome to My Platform!</h1>
    </div>
    <div class="content">
      <h2>Dear Dr. [Doctor’s {{ $data->user->first_name}} {{ $data->user->last_name}} ],</h2>
      <p>
        We are excited to inform you that your account is now active. You can start using our platform to connect with patients and manage your practice more efficiently.
      </p>
      <p>
        If you have any questions, feel free to contact our support team at [Contact Information].
      </p>
    </div>
    <div class="footer">
      <p>&copy; 2025 My Platform. All rights reserved.</p>
    </div>
  </div>
</body>
</html>
