<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subjectLine }}</title>
</head>
<body style="margin:0;padding:24px;font-family:Arial,sans-serif;background:#f6f6f6;color:#1f2937;">
    <div style="max-width:640px;margin:0 auto;background:#ffffff;border-radius:12px;padding:32px;">
        <h2 style="margin-top:0;">{{ $heading }}</h2>
        <p style="line-height:1.6;">{{ $messageBody }}</p>

        @if ($actionText && $actionUrl)
            <p style="margin:24px 0;">
                <a href="{{ $actionUrl }}" style="display:inline-block;background:#111827;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:8px;">
                    {{ $actionText }}
                </a>
            </p>
        @endif

        <p style="margin-bottom:0;line-height:1.6;">Crackteck Team</p>
    </div>
</body>
</html>
