<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Privacy Policy</title>
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
            <a href="{{ route('admin.terms-and-conditions') }}" class="text-muted">Terms &amp; Conditions</a>
        </div>
        <article class="legal-card p-4 p-md-5">
            <h1>Admin Panel Privacy Policy</h1>
            <p class="mb-4">Last updated: {{ date('F Y') }}</p>
            <p>This Privacy Policy explains how SRB Computers collects, uses, stores, and protects information submitted by authorized staff while using the administrative panels for E-commerce, CRM, and Warehouse operations.</p>
            <h2>Information we collect</h2>
            <p>We may collect staff account details, contact information, authentication data, activity logs, customer and order information, service records, inventory data, and other information entered or accessed while performing authorized business duties.</p>
            <h2>How we use information</h2>
            <ul>
                <li>To authenticate staff and provide access to the appropriate admin modules.</li>
                <li>To operate and maintain E-commerce, CRM, and Warehouse workflows.</li>
                <li>To process customer requests, orders, service cases, stock, reports, and communications.</li>
                <li>To monitor security, investigate misuse, prevent fraud, and maintain audit records.</li>
            </ul>
            <h2>Access and security</h2>
            <p>Admin access is restricted to authorized personnel. Users must keep credentials and one-time passwords confidential and must immediately report suspected unauthorized access. We use reasonable administrative and technical safeguards, but no online system can be guaranteed completely secure.</p>
            <h2>Sharing and retention</h2>
            <p>Information may be shared with authorized team members, service providers, payment or delivery partners, and government or law-enforcement authorities where required for business operations or by law. We retain information only as long as reasonably necessary for these purposes and applicable legal obligations.</p>
            <h2>Your responsibilities</h2>
            <p>Use only the information and modules required for your role, follow company security procedures, and do not copy, disclose, or export business or customer information without authorization.</p>
            <h2>Contact</h2>
            <p>For privacy or security questions, contact the system administrator or the company representative responsible for data protection.</p>
        </article>
    </main>
</body>
</html>