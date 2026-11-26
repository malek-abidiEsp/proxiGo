
<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ProxiGo', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="assets/CSS/automark.css">
    <link rel="stylesheet" href="assets/CSS/automark-theme.css">
    <style>
        body {
            min-height: 100vh;
            margin: 0;
            background: #03010e;
        }

        .topnav {
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 76px;
            padding: 0 7%;
            background: rgba(11, 12, 23, 0.92);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(147, 122, 255, 0.15);
        }

        .brand {
            display: flex;
            align-items: center;
        }

        .brand img {
            display: block;
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        .topnav .links {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .topnav .links a {
            color: #dad4de;
            font-size: 15px;
            font-weight: 500;
            text-decoration: none;
            transition: color .25s ease;
        }

        .topnav .links a:hover {
            color: #937aff;
        }

        .topnav .links .btn-primary {
            padding: 11px 23px;
            background: #937aff;
            color: #fff;
            border-radius: 8px;
            transition: all .25s ease;
        }

        .topnav .links .btn-primary:hover {
            background: #4d36d0;
            color: #fff;
            transform: translateY(-2px);
        }

        .container {
            width: min(90%, 480px);
            margin: 60px auto;
            padding: 35px;
            background: #0b0c17;
            border: 1px solid #202128;
            border-radius: 16px;
        }

        .container.wide {
            max-width: 1000px;
        }

        .container h1 {
            margin-bottom: 25px;
        }

        .container form {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .container label {
            color: #dad4de;
        }

        .container input,
        .container select,
        .container textarea {
            width: 100%;
            padding: 12px 14px;
            background: #040404;
            color: #e5e5e5;
            border: 1px solid #202128;
            border-radius: 8px;
            outline: none;
            box-sizing: border-box;
        }

        .container input:focus,
        .container select:focus,
        .container textarea:focus {
            border-color: #937aff;
        }

        .container button {
            padding: 13px 20px;
            margin-top: 12px;
            background: #937aff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: background .25s ease;
        }

        .container button:hover {
            background: #4d36d0;
        }

        .alert {
            padding: 12px 15px;
            margin-bottom: 18px;
            border-radius: 8px;
        }

        .alert-error {
            background: #351818;
            color: #ff7777;
        }

        .alert-success {
            background: #153322;
            color: #79d99b;
        }

        .switch-link {
            margin-top: 22px;
            text-align: center;
            color: #817e84;
        }

        .switch-link a {
            color: #937aff;
            text-decoration: none;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-admin {
            background: #351818;
            color: #ff7777;
        }

        .badge-user {
            background: #252044;
            color: #b5a3ff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #202128;
        }

        th {
            color: #937aff;
        }

        @media (max-width: 600px) {
            .topnav {
                padding: 15px 5%;
                flex-direction: column;
                gap: 15px;
            }

            .topnav .links {
                flex-wrap: wrap;
                justify-content: center;
                gap: 18px;
            }

            .container {
                padding: 22px;
            }
        }
    </style>
</head>
<body>
    <nav class="topnav">
        <div class="brand">
            <img src="assets/images/ProxiGo.png" alt="ProxiGo Logo">
        </div>

        <div class="links">
            <?php if (!empty($_SESSION['user_id'])): ?>
                <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                    <a href="index.php?action=admin">Admin panel</a>
                <?php else: ?>
                    <a href="index.php?action=dashboard">My space</a>
                    <a href="index.php?action=profile">Mon Profil</a>
                <?php endif; ?>
                <a href="index.php?action=logout" class="btn-primary">Log out</a>
            <?php else: ?>
                <a href="index.php?action=login">Log in</a>
                <a href="index.php?action=register" class="btn-primary">Sign up</a>
            <?php endif; ?>
        </div>
    </nav>

    <?= $content ?>
</body>
</html>
