<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Connexion</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="dist/img/icon_stock.png"/>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            overflow: hidden;
            perspective: 1000px;
        }

        .container {
            position: relative;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .circles {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 1;
        }

        .circles li {
            position: absolute;
            list-style: none;
            display: block;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.2);
            animation: animate 25s linear infinite;
            bottom: -150px;
            border-radius: 50%;
        }

        .circles li:nth-child(1) {
            left: 25%;
            width: 80px;
            height: 80px;
            animation-delay: 0s;
        }

        .circles li:nth-child(2) {
            left: 10%;
            width: 100px;
            height: 100px;
            animation-delay: 2s;
            animation-duration: 12s;
        }

        .circles li:nth-child(3) {
            left: 70%;
            width: 120px;
            height: 120px;
            animation-delay: 4s;
        }

        .circles li:nth-child(4) {
            left: 40%;
            width: 60px;
            height: 60px;
            animation-delay: 0s;
            animation-duration: 18s;
        }

        .circles li:nth-child(5) {
            left: 65%;
            width: 20px;
            height: 20px;
            animation-delay: 0s;
            animation-duration: 22s;
        }

        .circles li:nth-child(6) {
            left: 75%;
            width: 110px;
            height: 110px;
            animation-delay: 3s;
        }

        .circles li:nth-child(7) {
            left: 35%;
            width: 150px;
            height: 150px;
            animation-delay: 7s;
        }

        .circles li:nth-child(8) {
            left: 50%;
            width: 25px;
            height: 25px;
            animation-delay: 15s;
            animation-duration: 45s;
        }

        .circles li:nth-child(9) {
            left: 20%;
            width: 150px;
            height: 150px;
            animation-delay: 2s;
            animation-duration: 35s;
        }

        .circles li:nth-child(10) {
            left: 85%;
            width: 90px;
            height: 90px;
            animation-delay: 0s;
            animation-duration: 11s;
        }

        @keyframes animate {
            0% {
                transform: translateY(0) rotate(0deg);
                opacity: 1;
                border-radius: 0;
            }
            100% {
                transform: translateY(-1000px) rotate(720deg);
                opacity: 0;
                border-radius: 50%;
            }
        }

        .login-form {
            width: 400px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .login-form:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 30px rgba(0, 0, 0, 0.2);
        }

        .login-form h2 {
            margin: 0 0 15px;
            text-align: center;
            font-size: 24px;
            color: #333;
            font-weight: 700;
            text-transform: uppercase;
        }

        .form-group {
            position: relative;
            margin-bottom: 30px;
        }

        .form-group .form-control {
            height: 50px;
            padding-left: 55px;
            border-radius: 30px;
            border: 1px solid #ddd;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .form-group .form-control:focus {
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.2);
            border-color: #007bff;
        }

        .form-group i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 20px;
        }

        .btn {
            border-radius: 30px;
            padding: 12px;
            font-size: 16px;
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: #fff;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.2);
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: linear-gradient(135deg, #0056b3, #003f7f);
            box-shadow: 0 5px 15px rgba(0, 123, 255, 0.4);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #555;
        }

        .forgot-password a {
            color: #007bff;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <ul class="circles">
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>
    </ul>
    <div class="login-form">
        <form action="login.php" method="post">
            <h2>Connexion</h2>
            <?php if (isset($_GET['error']) && $_GET['error'] === "true") : ?>
                <div class="alert alert-danger alert-dismiss pull-right">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    Veuillez vérifier votre nom d'utilisateur et votre mot de passe.
                </div>
            <?php endif; ?>
            <div class="form-group">
                <i class="fa fa-user"></i>
                <input type="text" class="form-control" name="username" placeholder="Nom d'utilisateur"
                       required="required">
            </div>
            <div class="form-group">
                <i class="fa fa-lock"></i>
                <input type="password" class="form-control" name="password" placeholder="Mot de passe"
                       required="required">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </div>
        </form>
        <script>

        </script>
    </div>
</div>
</body>
</html>
