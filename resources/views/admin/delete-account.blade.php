<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Staff Account</title>
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <style>
        body { background: #f5f6f8; color: #283142; }
        .legal-page { max-width: 820px; margin: 48px auto; }
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
            <div>
                <a href="{{ route('admin.privacy-policy') }}" class="text-muted me-3">Privacy Policy</a>
                <a href="{{ route('admin.terms-and-conditions') }}" class="text-muted">Terms &amp; Conditions</a>
            </div>
        </div>
        <article class="legal-card p-4 p-md-5">
            <h1>Request Staff Account Deletion</h1>
            <p class="mb-4">This page is for SRB Computers staff accounts used to access the E-commerce, CRM, and Warehouse admin panels. It is not for customer accounts.</p>

            <h2>How to request deletion</h2>
            <ol>
                <li>Contact your company administrator or HR/data-protection representative using the official internal contact channel.</li>
                <li>Include your registered staff email address, phone number, staff code, and the words <strong>Staff Account Deletion Request</strong>.</li>
                <li>After verifying your identity and authorization, the administrator will deactivate your staff login and process deletion of personal account data.</li>
            </ol>

            <h2>Data deleted</h2>
            <p>Your staff profile, login credentials, OTP data, contact details, avatar, and other personal account information will be deleted or anonymized where technically and legally possible.</p>

            <h2>Data retained</h2>
            <p>Business records such as audit logs, invoices, service history, inventory activity, approvals, and legally required records may be retained for accounting, security, dispute resolution, fraud prevention, and legal compliance. Retained records will be kept only for the applicable retention period and will not be used to authenticate your deleted staff account.</p>

            <h2>Processing time</h2>
            <p>Requests are reviewed after staff identity verification and are normally processed within 30 days. You may be contacted if additional information is required.</p>

            <div class="alert alert-info mt-4 mb-0">This is a staff/admin account deletion request page. Customer account deletion is handled separately through the customer application.</div>
        </article>
    </main>
</body>
</html>