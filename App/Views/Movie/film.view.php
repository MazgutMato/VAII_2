<?php /** @var Array $data */ ?>
<script src="public/film.js"></script>
<script type = "text/javascript">
    nacitajId(<?= $data['film']->id?>)
    <?php if (\App\Auth::getName() == $data['film']->autor) { ?>
    nacitajFilm()
    <?php } ?>
</script>
<div class="container bg-dark">
    <div class="container bg-dark mt-5">
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
                                    <form method="post" action="?c=image&a=zmazObrazok">
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
                    <form method="post" action="?c=image&a=pridajObrazok" class="mt-2" enctype="multipart/form-data">
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
                Orig. názov: <div id="nazovFilmuP" class="m-2"><?= $data['film']->orgNazov ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="nazovFilmu">
                    </div>
                </div>
                <?php } ?>
                Žáner: <div id="zanerP" class="m-2"><?= $data['film']->zaner ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="zaner">
                    </div>
                </div>
                <?php } ?>
                Krajina: <div id="krajinaP" class="m-2"><?= $data['film']->krajina ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="krajina">
                    </div>
                </div>
                <?php } ?>
                Réžia: <div id="reziaP" class="m-2"><?= $data['film']->rezia ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="rezia">
                    </div>
                </div>
                <?php } ?>
                Scenár: <div id="scenarP" class="m-2"><?= $data['film']->scenar ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="scenar">
                    </div>
                </div>
                <?php } ?>
                Dátum premiery: <div id="premieraP" class="m-2"><?= $data['film']->premiera ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                    <div class="row">
                        <div class="col-12">
                            <input type="date" class="form-control mb-3" id="premiera">
                        </div>
                    </div>
                <?php } ?>
                Hrajú: <div id="hrajuP" class="m-2"><?= $data['film']->hraju ?></div>
                <?php if($data['film']->autor == \App\Auth::getName()) { ?>
                <div class="row">
                    <div class="col-12">
                        <input type="text" class="form-control mb-3" id="hraju">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-secondary mb-3" id="upravFilm">Uprav film</button>
                    </div>
                </div>
                <?php } ?>
                    Príspevok pridal: <div class="m-2"><?= $data['film']->autor ?></div>
                <?php if ($data['film']->autor == \App\Auth::getName()) { ?>
                <form method="post" action="?c=movie&a=zmazFilm">
                    <input type="hidden" name="filmId" value="<?php echo $data['film']->id ?>">
                    <button class="btn btn-secondary" type="submit">Zmaž film</button>
                </form>
                <?php } ?>
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
                        <form method="post" action="?c=hodnotenie&a=addHviezda">
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
                <p id="obsahP">
                    <?= $data['film']->obsah ?>
                </p>
            </div>
        </div>
        <?php if (\App\Auth::getName() == $data['film']->autor) { ?>
        <label class="form-label" for="obsah">Uprav obsah</label>
        <textarea rows="5" class="form-control " id="obsah" name="obsah" required></textarea>
        <div class="mb-3 mt-2">
            <button class="btn btn-secondary" type="submit" id="upravObsah">Uprav</button>
        </div>
        <?php } ?>
        <div class="row">
            <div class="col-12 mt-2"><h1>Komentáre</h1></div>
        </div>
        <div class="row m-2">
            <div class="col-12 komentare">
                <div class="card bg-dark border-light">
                    <div class="card-body" id="komentare">
                    <?php if (count($data['film']->getKomentare()) > 0) { ?>
                    <?php foreach ($data['film']->getKomentare() as $komentar) { ?>
                    <div id="komentar<?= $komentar->id ?>">
                        <p class="card-text m-2" id="komentarText<?= $komentar->id ?>"><?= $komentar->text . " (" . $komentar->autor . ")" ?></p>
                        <?php if (App\Auth::getName() == $komentar->autor
                            || App\Auth::getName() == $data['film']->autor && \App\Auth::isLogged()) { ?>
                        <input class="form-control" type="text" id="komUpraveny<?= $komentar->id ?>" value="<?= $komentar->text ?>">
                        <button class="btn btn-secondary mt-2" onclick="updateKomentar(<?= $komentar->id ?>)">Uprav komentar</button>
                        <button class="btn btn-secondary mt-2" onclick="deleteKomentar(<?= $komentar->id ?>)">Zmaz komentar</button>
                    </div>
                        <?php } ?>
                    <?php }} ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-2">
            <div class="col-12 komentare">
                <?php if (\App\Auth::isLogged()) { ?>
                    <div class="mb-1">
                        <label for="komentar" class="form-label">Text komentaru</label>
                        <input class="form-control" placeholder="Zadaj komentar" type="text" name="komentar"
                               required id="komentarNovy"><br>
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-secondary" id="odoslatKomentar" >Odošli komentar</button>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>