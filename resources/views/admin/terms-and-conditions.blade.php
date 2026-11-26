<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Terms &amp; Conditions</title>
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <style>
        body { background: #f5f6f8; color: #283142; }
        .legal-page { max-width: 900px; margin: 48px auto; }
        .legal-card { background: #fff; border-radius: 12px; box-shadow: 0 8px 30px rgba(20, 32, 55, .08); }
        .legal-card h1 { font-size: 28px; }
        .legal-card h2 { font-size: 19px; margin-top: 28px; }
        .legal-card p, .legal-card li { line-height: 1.7; color: #667085; }
        .legal-nav a { text-decoration: none; }
    </style>
</head>
<body>
    <main class="legal-page px-3">
        <div class="d-flex justify-content-between align-items-center mb-3 legal-nav">
            <a href="{{ route('login') }}" class="text-primary">&larr; Back to Admin Login</a>
            <a href="{{ route('admin.privacy-policy') }}" class="text-muted">Privacy Policy</a>
        </div>
        <article class="legal-card p-4 p-md-5">
            <h1>Admin Panel Terms &amp; Conditions</h1>
            <p class="mb-4">Last updated: {{ date('F Y') }}</p>
            <p>These Terms &amp; Conditions govern access to and use of the SRB Computers administrative panels for E-commerce, CRM, and Warehouse operations.</p>
            <h2>Authorized use</h2>
            <p>Access is provided only to approved staff and only for legitimate business purposes within the user’s assigned role. Sharing accounts, bypassing permissions, or allowing another person to use your session is prohibited.</p>
            <h2>Account security</h2>
            <p>You are responsible for protecting your password, phone, OTP, and session. Log out when finished, use only approved devices and networks where possible, and report suspicious activity immediately.</p>
            <h2>Business and customer information</h2>
            <p>Customer, order, service, financial, employee, inventory, and operational information is confidential. You must access, edit, download, or disclose it only when necessary for your assigned duties and in accordance with company policy.</p>
            <h2>Records and accuracy</h2>
            <p>Users must enter complete and accurate information, must not falsify or improperly delete records, and must follow approval, inventory, payment, service, and reporting procedures established by the company.</p>
            <h2>Monitoring and suspension</h2>
            <p>Administrative activity may be logged and reviewed for security, compliance, quality, and operational purposes. Access may be restricted or suspended if these terms, company policies, or applicable law are violated.</p>
            <h2>Availability and changes</h2>
            <p>Features may be changed, interrupted, or withdrawn as the system is maintained or improved. These terms may also be updated from time to time; continued use after an update means you accept the revised terms.</p>
            <h2>Contact</h2>
            <p>Questions about access, permissions, or these terms should be directed to the system administrator or the relevant department manager.</p>
        </article>
    </main>
</body>
</html>