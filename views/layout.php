<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title><?php echo $title ?></title>
    <script
            src="https://code.jquery.com/jquery-3.7.0.min.js"
            integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g="
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../assets/bootstrap.css"  type="text/css"/>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                    <ul class="navbar-nav mb-2 mb-lg-0 text-end">

                        <?php if(isset($_SESSION['login'])): ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/page/logout">Logout</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/survey/cabinet">Cabinet</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><?php echo $_SESSION['login'] ?></a>

                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="/page/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/page/register">Register</a>
                            </li>
                        <?php endif; ?>
                    </ul>

            </div>
        </nav>
    </header>
    <div class="container">
        <?php require($view); ?>
    </div>
</body>
</html>

