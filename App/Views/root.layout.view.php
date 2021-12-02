<!DOCTYPE html>
<html lang="sk">
<head>
    <title>FRI-MVC FW</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="public/css.css">
</head>
<body>
<!--navbar-->
<nav class="navbar fixed-top navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <div class="container-fluid">
        <i class="bi bi-film icon"></i>
        <a class="navbar-brand" href="#">Filmpedia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="?c=home">Domov</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?c=home&a=rebricek">Rebríček filmov</a>
                </li>

                <?php if (\App\Auth::isLogged()) {?>
                    <li class="nav-item">
                        <a class="nav-link" href="?c=home&a=pridajFilm">Pridanie filmu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?c=auth&a=logout">Odhlasenie</a>
                    </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="?c=auth&a=prihlasenie">Prihlasenie</a>
                </li>
                <?php } ?>

            </ul>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row mt-2">
        <div class="col">
            <?= $contentHTML ?>
        </div>
    </div>
</div>
</body>
</html>

