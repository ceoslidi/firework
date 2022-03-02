<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>First Steps</title>
    <link rel="stylesheet" href="./dist/css/first.css">
</head>
<body>
    <h1 class="head">
        It's Fire.
    </h1>
    @extend(extend)
    <p class="steps">
        You can modify the project for 3 steps:
    </p>
    <ul>
        <li>
            1. Create a controller in <span class="code">/app/controllers/</span>
        </li>
        <li>
            2. Import your controller in <span class="code">/index.php</span>
        </li>
        <li>
            3. Create a route in <span class="code">/index.php</span> by <span class="code">$router->get('/', [FirstController::class, 'render'])</span>
        </li>
    </ul>
</body>
</html>