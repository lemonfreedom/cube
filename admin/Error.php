<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error <?= $code ?></title>
    <style>
        body {
            height: 100%;
            padding: 10% 15px 0;
            background: #fafafa;
            color: #777;
        }

        h1 {
            text-align: center;
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin: 0;
            color: #222;
        }
    </style>
</head>

<body>
    <h1><?= $message ?></h1>
</body>

</html>
