<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coming Soon — CrackTeck</title>

    <!-- Fonts & Styles from frontend-assets -->
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-assets/css/custom.css') }}">

    <style>
        /* Small custom overrides to ensure the coming-soon layout looks good */
        body,
        html {
            height: 100%;
        }

        .coming-soon-wrap {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('{{ asset('frontend-assets/images/section/line-br.jpg') }}') center/cover no-repeat, #fff;
            color: #fff;
            text-align: center;
            padding: 60px 15px;
        }

        .coming-card {
            background: rgb(0, 0, 0);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
            max-width: 760px;
            width: 100%;
        }

        .coming-logo img {
            max-width: 160px;
        }

        .coming-title {
            font-size: 48px;
            font-weight: 700;
            margin: 18px 0;
            letter-spacing: 1px;
        }

        .coming-subtitle {
            color: #cbd5e1;
            margin-bottom: 28px;
        }

        .countdown {
            display: flex;
            gap: 18px;
            justify-content: center;
            margin-bottom: 22px;
        }

        .countdown .time-box {
            background: rgba(255, 255, 255, 0.06);
            padding: 18px 14px;
            border-radius: 8px;
            min-width: 80px;
        }

        .time-box .num {
            font-size: 26px;
            font-weight: 700;
        }

        .time-box .label {
            font-size: 12px;
            color: #cbd5e1;
        }

        .subscribe-form {
            max-width: 520px;
            margin: 0 auto;
            display: flex;
            gap: 8px;
        }

        .subscribe-form input[type="email"] {
            flex: 1;
        }

        .socials {
            margin-top: 18px;
        }

        .socials img {
            width: 36px;
            margin: 0 6px;
            opacity: .9;
        }

        @media (max-width:576px) {
            .coming-title {
                font-size: 34px;
            }
        }
    </style>
</head>

<body>

    <section class="coming-soon-wrap">
        <div class="coming-card">
            <div class="coming-logo mb-3">
                <a href="{{ url('/') }}"><img src="{{ asset('frontend-assets/images/logo/header-logo-2.png') }}"
                        alt="CrackTeck"></a>
            </div>

            <h1 class="coming-title">Coming Soon</h1>
            <p class="coming-subtitle">We're working hard behind the scenes. We'll be ready soon — stay tuned.</p>

            {{-- <form class="subscribe-form" id="subscribeForm" onsubmit="return subscribe(event)">
                <input type="email" name="email" id="emailInput" class="form-control" placeholder="Enter your email"
                    required>
                <button type="submit" class="btn btn-primary">Notify Me</button>
            </form>

            <div class="socials mt-3">
                <a href="#"><img src="{{ asset('frontend-assets/images/icons/icon-1.png') }}" alt="social"></a>
                <a href="#"><img src="{{ asset('frontend-assets/images/icons/icon-2.png') }}" alt="social"></a>
                <a href="#"><img src="{{ asset('frontend-assets/images/icons/icon-3.png') }}" alt="social"></a>
                <a href="#"><img src="{{ asset('frontend-assets/images/icons/icon-4.png') }}" alt="social"></a>
            </div> --}}

            {{-- <p class="mt-3 small">Prefer to contact us? <a href="mailto:info@crackteck.com"
                    style="color:#fff;text-decoration:underline;">info@crackteck.com</a></p> --}}
        </div>
    </section>

    <!-- Scripts -->
    <script src="{{ asset('frontend-assets/js/jquery.min.js') }}"></script>
    <script>
        // Simple subscription feedback (no backend)
        function subscribe(e) {
            e.preventDefault();
            var email = document.getElementById('emailInput').value;
            if (!email) return false;
            // Replace with real AJAX to your subscribe endpoint if available
            alert('Thanks! We\'ll notify ' + email + ' when we launch.');
            document.getElementById('subscribeForm').reset();
            return false;
        }

        // Countdown: set target to 30 days from now by default
        (function() {
            var target = new Date();
            target.setDate(target.getDate() + 30);

            function update() {
                var now = new Date();
                var diff = target - now;
                if (diff <= 0) {
                    document.getElementById('countdown').innerHTML = '<strong>We are live! 🎉</strong>';
                    clearInterval(timer);
                    return;
                }
                var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                var hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                var minutes = Math.floor((diff / (1000 * 60)) % 60);
                var seconds = Math.floor((diff / 1000) % 60);

                document.getElementById('days').textContent = days;
                document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
                document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
                document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
            }

            var timer = setInterval(update, 1000);
            update();
        })();
    </script>

</body>

</html>
