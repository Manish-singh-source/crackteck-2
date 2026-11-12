<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Coming Soon | SRB Computers</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}?v=1">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon.png') }}?v=1">
    <style>
        :root { color-scheme: dark; }
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: grid; place-items: center; overflow: hidden; background: url('{{ asset('assets/images/banner-im.jpeg') }}') center / cover no-repeat; color: #f7fbff; font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif; }
        main { width: min(92%, 760px); text-align: center; padding: 3rem 1.5rem; text-shadow: 0 2px 12px rgba(0,0,0,.85); }
        .mark { width: min(310px, 76vw); margin: 0 auto 2rem; filter: drop-shadow(0 14px 24px rgba(0,0,0,.45)); }
        .mark img { display: block; width: 100%; height: auto; }
        .eyebrow { margin: 0 0 1rem; color: #ff8a84; font-size: .76rem; font-weight: 800; letter-spacing: .18em; text-transform: uppercase; }
        h1 { margin: 0; font-size: clamp(2.7rem, 8vw, 5.4rem); line-height: .98; letter-spacing: -.065em; }
        h1 span { color: #ff4b42; }
        .message { max-width: 560px; margin: 1.6rem auto 0; color: #f5e8e8; font-size: clamp(1rem, 2.5vw, 1.15rem); line-height: 1.7; }
        .line { width: 54px; height: 3px; margin: 2.3rem auto 1.4rem; border-radius: 10px; background: #ff4239; }
        .status { display: inline-flex; align-items: center; gap: .6rem; margin: 0; padding: .68rem 1rem; border: 1px solid rgba(255,255,255,.35); border-radius: 999px; color: #fff5f4; font-size: .88rem; }
        .dot { width: .55rem; height: .55rem; border-radius: 50%; background: #ff4b42; box-shadow: 0 0 0 5px rgba(255,75,66,.17); }
        .brand { margin-top: 2.8rem; color: #91a4b9; font-size: .83rem; letter-spacing: .07em; text-transform: uppercase; }
        @media (max-width: 480px) { main { padding: 2rem 0; } .mark { margin-bottom: 1.5rem; } }
    </style>
</head>
<body>
    <main>
        <div class="mark"><img src="{{ asset('frontend-assets/images/logo/white-logo.png') }}" alt="SRB"></div>
        <p class="eyebrow">Something new is on the way</p>
        <h1>Coming <span>Soon.</span></h1>
        <p class="message">We are putting the finishing touches on a better experience. Please check back shortly.</p>
        <div class="line" aria-hidden="true"></div>
    </main>
</body>
</html>
