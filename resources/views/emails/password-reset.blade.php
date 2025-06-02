<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #7367F0;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .password {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 5px;
            font-family: monospace;
            font-size: 16px;
            margin: 15px 0;
            text-align: center;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('app.name') }}</h1>
    </div>
    <div class="content">
        <h2>Hello {{ $user->name }},</h2>
        
        <p>You recently requested to reset your password for your {{ config('app.name') }} account.</p>
        
        <p>Your new password is:</p>
        
        <div class="password">{{ $password }}</div>
        
        <p>For security reasons, we recommend changing this password after you log in.</p>
        
        <p>If you did not request a password reset, please contact our support team immediately.</p>
        
        <p>Thank you,<br>
        The {{ config('app.name') }} Team</p>
    </div>
    <div class="footer">
        <p>This is an automated email, please do not reply to this message.</p>
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
