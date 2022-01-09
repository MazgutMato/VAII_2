<?php /** @var Array $data */ ?>
<div class="container bg-dark">
    <div class="container bg-dark mt-5">
        <!--            Nadpis-->
        <div class="row">
            <div class="col-12 mt-3">
                <h1>Nejlepšie filmy</h1>
            </div>
        </div>

        <?php foreach ($data['filmy'] as $film) { ?>
            <div class="row align-items-center border-bottom border-top">
                <div class="col-12 col-lg-4">
                    <table class="table tabulka">
                        <tbody>
                        <tr>
                            <td><img src="<?php if (count($film->getObrazky()) > 0) { echo $film->getObrazky()[0]->obrazok; }
                                else { echo "https://elitebaby.sk/files/shop/default.jpg";} ?>" class="img-news" alt="..."></td>
                        </tr>
                        <tr>
                            <td><a href="?c=home&a=film&filmId=<?= $film->id ?>" class="odkaz"><?=$film->nazov?></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-lg-5 p-5 zakladneinfo">
                    <p>
                        Orig. názov: <?=$film->orgNazov?>
                    </p>
                    <p>
                        Žáner: <?=$film->zaner?>
                    </p>
                    <p>
                        Krajina: <?=$film->krajina?>
                    </p>
                    <p>
                        Réžia: <?=$film->rezia?>
                    </p>
                    <p>
                        Scenár: <?=$film->scenar?>
                    </p>
                    <p>
                        Hrajú: <?=$film->hraju?>
                    </p>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <p class="text-center fs-2">Hodnotenie</p>
                    </div>
                    <div class="row">
                        <p class="hodnotenie border bg-danger">
                            <?= number_format($film->hodnotenie,2) ?>/ 5 <i class="bi bi-star"></i></p>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>
