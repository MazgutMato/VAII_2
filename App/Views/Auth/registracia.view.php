<?php /** @var Array $data */ ?>

<div class="container bg-dark mt-5">
    <div class="row">
        <div class="col-12 mt-3 border-bottom mb-3"><h1>Registrančné údaje</h1></div>
    </div>
    <div class="row m-3">
        <div class="col-12 komentare">
            <?php if ($data['error'] != "") {?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?= $data['error'] ?>
                </div>
            <?php } ?>
            <form method="post" action="?c=auth&a=register">
                <div class="mb-3">
                    <label for="login" class="form-label">Login</label>
                    <input class="form-control" placeholder="Zadaj login(min. 3 znaky)" type="text" name="login" minlength="3" required>
                </div>
                <div class="mb-3">
                    <label for="password1" class="form-label">Zadaj heslo</label>
                    <input class="form-control" placeholder="Zadaj heslo(min. 5 znaky)" type="password" name="password1" required minlength="5">
                </div>
                <div class="mb-3">
                    <label for="password2" class="form-label">Potvrď heslo</label>
                    <input class="form-control" placeholder="Potvrď heslo(min. 5 znaky)" type="password" name="password2" required minlength="5">
                </div>
                <div class="mb-3">
                    <input type="submit" class="btn btn-secondary" name="registrovat" value="Registrovať">
                </div>
            </form>
        </div>
    </div>
</div>

