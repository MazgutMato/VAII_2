<?php /** @var Array $data */ ?>
<!--Telo-->

<div class="container bg-dark">
    <div class="container bg-dark mt-5">
        <div class="row">
            <div class="col-12 mt-3 border-bottom mb-3"><h1><?= $data['film']->nazov ?></h1></div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php if (count($data['film']->getObrazky()) == 0) { ?>
                        <div class="carousel-item active">
                            <img src="https://elitebaby.sk/files/shop/default.jpg" class="d-block w-100 img-info" alt="...">
                        </div>
                        <?php } else {?>
                        <?php foreach ($data['film']->getObrazky() as $index => $obrazok ) { ?>
                            <div class="carousel-item <?php
                            if ($index == 0) { ?>
                            active
                        <?php } ?> ">
                                <img src="<?= $obrazok->url ?>" class="d-block w-100 img-info" alt="...">
                            </div>
                        <?php }} ?>
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
                <?php if (\App\Auth::isLogged()) { ?>
                <form method="post" action="?c=home&a=pridajObrazok" class="mt-2">
                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                    <div class="mb-1">
                        <input class="form-control" placeholder="Zadaj url" type="url" name="url" required>
                    </div>
                    <div class="mb-1">
                        <input type="submit" class="btn btn-secondary" name="pridajObrazok" value="Pridaj obrazok">
                    </div>
                </form>
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
                        Krajina: <?= $data['film']->krajina?>
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
            <div class="col-12 mt-2"><h1>Zaujimavosti</h1></div>
        </div>

        <?php if (count($data['film']->getZaujimavosti())) { ?>
        <div class="row m-2">
            <div class="col-12 komentare">
                <div class="card bg-dark border-light">
                    <ul>
                        <?php foreach ($data['film']->getZaujimavosti() as $zaujimavost) { ?>
                            <div class="card-body">
                                <p> <?= $zaujimavost->text." (".$zaujimavost->autor.")" ?> </p>
                                <?php if (\App\Auth::isLogged()) {?>
                                <form method="post" action="?a=deleteZaujimavost">
                                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                                    <input type="hidden" name="ZaujimavostId" value="<?= $zaujimavost->id ?>">
                                    <input type="submit" class="btn btn-secondary" name="zmaz" value="Zmaž zaujimavost">
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
                <form method="post" action="?a=addZaujimavost">
                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                    <input type="hidden" name="autor" value="<?= \App\Auth::getName() ?>">
                    <div class="mb-3">
                        <label for="zaujimavost" class="form-label">Text zaujimavosti</label>
                        <input class="form-control" placeholder="Zadaj zaujimavost" type="text" name="zaujimavost" required><br>
                    </div>
                    <div class="mb-3">
                        <input type="submit" class="btn btn-secondary" name="odoslat" value="Odošli zaujimavost">
                    </div>
                </form>
                <?php } ?>
            </div>
        </div>

    </div>
</div>