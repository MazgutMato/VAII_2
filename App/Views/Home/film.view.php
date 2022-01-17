<?php /** @var Array $data */ ?>
<div class="container bg-dark">
    <div class="container bg-dark mt-5">
        <div id="komentare"></div>
        <div class="row mt-2">
            <?php if (isset($_GET['success'])) {?>
                <div class="alert alert-success alert-dismissible mt-3">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?= $_GET['success'] ?>
                </div>
            <?php } ?>
            <?php if (isset($_GET['error'])) {?>
                <div class="alert alert-danger alert-dismissible mt-2">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <?= $_GET['error'] ?>
                </div>
            <?php } ?>
        </div>
        <div class="row">
            <div class="col-12 mt-3 border-bottom mb-3"><h1><?= $data['film']->nazov ?></h1></div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= $data['film']->obrazok ?>" class="d-block w-100 img-info" alt="...">
                        </div>
                        <?php foreach ($data['film']->getObrazky() as $index => $obrazok ) { ?>
                            <div class="carousel-item">
                                <img src="<?= $obrazok->obrazok ?>" class="d-block w-100 img-info" alt="...">
                                <?php if (\App\Auth::getName() == $data['film']->autor && \App\Auth::isLogged()) { ?>
                                <div class="d-flex justify-content-center">
                                    <form method="post" action="?a=zmazObrazok">
                                        <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                                        <input type="hidden" name="obrazokId" value="<?php echo $obrazok->id ?>">
                                        <button class="btn btn-secondary">Zmaz obrázok</button>
                                    </form>
                                </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                <?php if (\App\Auth::getName() == $data['film']->autor && \App\Auth::isLogged()) { ?>
                <div class="card bg-dark m-2 p-2 border">
                    <form method="post" action="?c=home&a=pridajObrazok" class="mt-2" enctype="multipart/form-data">
                        <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                        <div class="mb-1">
                            <div class="d-flex justify-content-center">
                                <label class="form-label" for="obrazok">Pridaj obrazok</label>
                            </div>
                            <input class="form-control" placeholder="Zadaj subor" type="file" name="file" id="obrazok" required>
                        </div>
                        <div class="d-flex justify-content-center mb-1">
                            <input type="submit" class="btn btn-secondary" name="pridajObrazok" value="Odosli obrazok">
                        </div>
                    </form>
                </div>
                <?php } ?>
            </div>
            <div class="col-12 col-md-6 zakladneinfo p-3">
                <p>
                    Orig. názov: <?= $data['film']->orgNazov ?>
                </p>
                <p>
                    Žáner: <?= $data['film']->zaner ?>
                </p>
                <p>
                    Krajina: <?= $data['film']->krajina ?>
                </p>
                <p>
                    Réžia: <?= $data['film']->rezia ?>
                </p>
                <p>
                    Scenár: <?= $data['film']->scenar ?>
                </p>
                <p>
                    Hrajú: <?= $data['film']->hraju ?>
                </p>
                <p>
                    Príspevok pridal: <?= $data['film']->autor ?>
                    <?php if ($data['film']->autor == \App\Auth::getName()) { ?>
                <form method="post" action="?c=home&a=zmazFilm">
                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                    <button class="btn btn-secondary" type="submit">Zmaž film</button>
                </form>
                    <?php } ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 p-3">
                <div class="row">
                    <p class="text-center fs-2">Hodnotenie</p>
                </div>
                <div class="row">
                    <p class="hodnotenie border bg-danger">
                        <?= number_format($data['film']->hodnotenie,2) ?>/ 5 <i class="bi bi-star"></i></p>
                </div>
            </div>
            <div class="col-12 col-md-6 p-3">
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <p class="fs-2">Ohodnoť</p>
                    </div>
                </div>
                <div class="row">
                    <div class="d-flex justify-content-center">
                        <form method="post" action="?a=addHviezda">
                            <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                            <button name="pocetHviezd" value="1" class="btn btn-secondary" type="submit"><i class='bi bi-star'></i></button>
                            <button name="pocetHviezd" value="2" class="btn btn-secondary" type="submit"><i class='bi bi-star'></i></button>
                            <button name="pocetHviezd" value="3" class="btn btn-secondary" type="submit"><i class='bi bi-star'></i></button>
                            <button name="pocetHviezd" value="4" class="btn btn-secondary" type="submit"><i class='bi bi-star'></i></button>
                            <button name="pocetHviezd" value="5" class="btn btn-secondary" type="submit"><i class='bi bi-star'></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-2"><h1>Obsah</h1></div>
        </div>
        <div class="row">
            <div class="col-12 obsah p-4">
                <p>
                    <?= $data['film']->obsah ?>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 mt-2"><h1>Komentáre</h1></div>
        </div>

        <?php if (count($data['film']->getKomentare())) { ?>
        <div class="row m-2">
            <div class="col-12 komentare">
                <div class="card bg-dark border-light">
                    <?php foreach ($data['film']->getKomentare() as $komentar) { ?>
                        <div class="card-body">
                            <p class="card-text"><?= $komentar->text . " (" . $komentar->autor . ")" ?></p>
                            <?php if (App\Auth::getName() == $komentar->autor
                                || App\Auth::getName() == $data['film']->autor && \App\Auth::isLogged()) { ?>
                                <form method="post" action="?a=deleteKomentar">
                                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                                    <input type="hidden" name="KomentarId" value="<?= $komentar->id ?>">
                                    <input type="submit" class="btn btn-secondary" name="zmaz" value="Zmaž komentar">
                                </form>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>

        <div class="row m-2">
            <div class="col-12 komentare">
                <?php if (\App\Auth::isLogged()) { ?>
                <form method="post" action="?a=addKomentar">
                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                    <input type="hidden" name="autor" value="<?= \App\Auth::getName() ?>">
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Text komentaru</label>
                        <input class="form-control" placeholder="Zadaj komentar" type="text" name="komentar" required><br>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-secondary" name="odoslat" value="Odošli komentar">
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>

    </div>
</div>