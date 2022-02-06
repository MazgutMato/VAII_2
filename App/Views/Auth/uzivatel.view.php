<?php /** @var Array $data */ ?>

<script src="public/pouzivatel.js"></script>

<div class="container bg-dark mt-5">
    <div class="row">
        <div class="col-12 mt-3 border-bottom mb-3"><h1>Informacie o používateľovi</h1></div>
    </div>
    <div class="row align-items-center">
        <div class="col-12 col-md-3">
            <div class="d-flex justify-content-center mb-1">
                <img class="img-thumbnail" id="fotka" src="<?= $data['pouzivatel']->obrazok?>" alt="obrazky/chyba.jpg">
                <input type="hidden" id="meno" name="meno" value="<?= $data['pouzivatel']->meno ?>">
            </div>
            <div class="mb-1">
                <div class="d-flex justify-content-center">
                    <label class="form-label" for="obrazok">Zmen obrazok</label>
                </div>
                <input class="form-control" type="file" name="file" id="obrazok">
            </div>
            <div class="d-flex justify-content-center mb-1">
                <button class="btn btn-secondary" id="pridajObr" name="pridajObrazok">Odosli obrazok</button>
            </div>
        </div>
        <div class="col-12 col-md-9">
            <table class="table table-bordered table-responsive pouzivatelTab">
                <tbody>
                    <tr>
                        <td class="pouzivatelTabTdNadpisPrvy">Meno:</td>
                        <td class="pouzivatelTabTdText"><?= $data['pouzivatel']->meno?></td>
                    </tr>
                    <tr>
                        <td class="pouzivatelTabTdNadpis">Počet pridaných filmov</td>
                        <td class="pouzivatelTabTdText" id="pocetFilmov">
                            <?= count($data['pouzivatel']->getFilmy()) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="pouzivatelTabTdNadpis">Dátum registrácie</td>
                        <td class="pouzivatelTabTdText" id="datum">
                            <?= $data['pouzivatel']->datumReg?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12 mt-3 border-bottom mb-3"><h1>Zoznam pridanych filmov</h1></div>
    </div>
    <div class="row" id="filmy">
        <?php foreach ($data['filmy'] as $key => $film) { ?>
        <div class="col-12 col-lg-4" id="film<?=$film->id?>">
            <table class="table tabulka">
                <tbody>
                <tr>
                    <td><a href="?c=movie&a=film&filmId=<?= $film->id ?>" class="odkaz">
                            <img src="<?php echo $film->obrazok?>" class="img-news" alt="obrazky/chyba.jpg"></a>
                    </td>
                </tr>
                <tr>
                    <td><a href="?c=movie&a=film&filmId=<?= $film->id ?>" class="odkaz"><?= $film->nazov ?></a></td>
                </tr>
                <tr>
                    <td><button class="btn btn-secondary" onclick="zmazFilm(<?= $film->id ?>)">Zmaž film</button></td>
                </tr>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>