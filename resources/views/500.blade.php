<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Page</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
</head>

<style>
    body {
        display: flex;
        flex-direction: column;
        background-color: rgb(58, 58, 58);
    }

    .center {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .container {
        /* max-width: 500px; */
        justify-content: center;
        align-items: center;
        display: flex;
        flex-direction: column;
        margin: auto auto;
        height: 100vh;
        color: whitesmoke;
    }

    h1 {
        font-size: 10rem;
    }

    p {
        font-size: 2rem;
    }

    a {
        padding: 10px 20px;
        border-radius: 10px;
        background-color: whitesmoke;
    }
</style>

<body>
    <div class="center">
        <div class="container">
            <h1>500 Page</h1>
            <div><img src="{{ asset('assets/images/logo-light.png') }}" alt=""></div>
            <p>Internal Server Error</p>
            <a href="{{ route('login') }}" class="btn">Back To Home Page</a>
        </div>
    </div>
</body>

</html>