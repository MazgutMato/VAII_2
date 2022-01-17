<?php /** @var Array $data */ ?>

<div class="container bg-dark mt-5">
    <div class="row">
        <div class="col-12 mt-3 border-bottom mb-3"><h1>Prihlasovacie údaje</h1></div>
    </div>
    <div class="row m-3">
        <div class="col-12 komentare">
            <?php if ($data['error'] != "") {?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?= $data['error'] ?>
            </div>
            <?php } ?>
            <?php if ($data['success'] != "") {?>
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?= $data['success'] ?>
                </div>
            <?php } ?>
            <form method="post" action="?c=auth&a=login">
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input class="form-control" placeholder="Zadaj login" type="text" name="login" minlength="3" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Zadaj heslo</label>
                    <input class="form-control" placeholder="Zadaj heslo" type="password" name="password" required>
                </div>
                <a href="?c=auth&a=registracia">Najskôr sa musíte registrovať!</a>
                <div class="mt-3 mb-3">
                    <input type="submit" class="btn btn-secondary" name="prihlasit" value="Prihlasiť">
                </div>
            </form>
        </div>
    </div>
</div>
