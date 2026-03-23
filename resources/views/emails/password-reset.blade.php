<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .email-wrapper {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .email-header {
            background-color: #4f46e5;
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body p {
            margin: 0 0 20px;
            font-size: 16px;
        }
        .btn {
            display: inline-block;
            padding: 14px 32px;
            background-color: #4f46e5;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin: 20px 0;
        }
        .btn:hover {
            background-color: #4338ca;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 20px 30px;
            text-align: center;
            font-size: 14px;
            color: #6b7280;
        }
        .email-footer p {
            margin: 0;
        }
        .warning-box {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 15px;
            margin: 20px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="email-wrapper">
            <div class="email-header">
                <h1>Password Reset Request</h1>
            </div>
            <div class="email-body">
                <p>Hello {{ $user->first_name ?? 'User' }},</p>
                
                <p>We received a request to reset your password for your Crackteck account. Click the button below to reset your password:</p>
                
                <div style="text-align: center;">
                    <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
                </div>
                
                <p>This password reset link will expire in 60 minutes for security reasons.</p>
                
                <div class="warning-box">
                    <strong>Note:</strong> If you didn't request a password reset, please ignore this email. Your password will remain unchanged.
                </div>
                
                <p>If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
                
                <p style="word-break: break-all; font-size: 12px; color: #6b7280;">
                    {{ $resetUrl }}
                </p>
            </div>
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} Crackteck. All rights reserved.</p>
                <p>This is an automated message, please do not reply to this email.</p>
            </div>
        </div>
    </div>
</body>
</html>
