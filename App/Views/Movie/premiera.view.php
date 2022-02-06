<?php /** @var Array $data */ ?>
<div class="container bg-dark">
    <div class="container bg-dark mt-5">
        <!--            Nadpis-->
        <div class="row">
            <div class="col-12 mt-3">
                <h1>Čoskoro v kinách</h1>
            </div>
        </div>

        <?php foreach ($data['film'] as $film) { ?>
            <div class="row align-items-center border-bottom border-top">
                <div class="col-12 col-lg-4">
                    <table class="table tabulka">
                        <tbody>
                        <tr>
                            <td><a href="?c=movie&a=film&filmId=<?= $film->id ?>" class="odkaz">
                                    <img src=" <?php echo $film->obrazok?>" class="img-news" alt="obrazky/chyba.jpg"></a></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="?c=movie&a=film&filmId=<?= $film->id ?>" class="odkaz"><?= $film->nazov ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 col-lg-5 p-5 zakladneinfo">
                    <p>
                        Orig. názov: <?=$film->orgNazov ?>
                    </p>
                    <p>
                        Žáner: <?=$film->zaner ?>
                    </p>
                    <p>
                        Krajina: <?=$film->krajina ?>
                    </p>
                    <p>
                        Réžia: <?=$film->rezia?>
                    </p>
                    <p>
                        Scenár: <?=$film->scenar?>
                    </p>
                    <p>
                        Hrajú: <?=$film->hraju ?>
                    </p>
                    <p>
                        Dátum premiery: <?=$film->premiera ?>
                    </p>
                </div>
                <div class="col-12 col-lg-3">
                    <div class="row">
                        <p class="text-center fs-2">Hodnotenie</p>
                    </div>
                    <div class="row">
                        <p class="hodnotenie border bg-danger">
                            <?= number_format($film->hodnotenie,2) ?>/ 5 <i class="bi bi-star"></i> </p>
                    </div>
                </div>
            </div>
        <?php } ?>

    </div>
</div>
