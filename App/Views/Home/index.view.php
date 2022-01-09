<?php /** @var Array $data */
$arraySize = count($data['filmy']);
$posledny = $data['filmy'][($arraySize-1)];
?>
<!--Filmove novinky-->
<div class="container bg-dark">
    <div class="container bg-dark mt-5">
        <div class="row">
            <div class="col-12 mt-3 border-bottom mb-3">
                <h1>Filmové novinky</h1>
            </div>
        </div>
        <div class="row">
            <?php
            foreach ($data['filmy'] as $key => $film) {
                if ($key > ($arraySize - 5) && $key < ($arraySize-1) ) { ?>
                    <div class="col-12 col-lg-4">
                    <table class="table tabulka">
                        <tbody>
                        <tr>
                            <td><img src=" <?php if (count($film->getObrazky()) > 0) { echo $film->getObrazky()[0]->obrazok; }
                                else { echo "https://elitebaby.sk/files/shop/default.jpg";} ?>" class="img-news" alt="..."></td>
                        </tr>
                        <tr>
                            <td>
                                <a href="?c=home&a=film&filmId=<?= $film->id ?>" class="odkaz"><?= $film->nazov ?></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                <?php }} ?>
        </div>

        <!--Čoskoro v kinách-->
            <div class="row">
                <div class="col-12">
                    <h1><?= $posledny->nazov ?></h1>
                </div>
            </div>
            <div class="row align-items-center p-3">
                <div class="col-12 col-lg-6 zakladneinfo">
                    <p>
                        Orig. názov: <?= $posledny->nazov ?>
                    </p>
                    <p>
                        Žáner: <?= $posledny->zaner ?>
                    </p>
                    <p>
                        Krajina: <?= $posledny->krajina ?>
                    </p>
                    <p>
                        Réžia: <?= $posledny->rezia ?>
                    </p>
                    <p>
                        Scenár: <?= $posledny->scenar ?>
                    </p>
                    <p>
                        Hrajú: <?= $posledny->hraju ?>
                    </p>
                </div>
                <div class="col-12 col-lg-6">
                    <table class="table tabulka">
                        <tbody>
                        <tr>
                            <td><img src="<?php if (count($posledny->getObrazky()) > 0) { echo $posledny->getObrazky()[0]->obrazok; }
                                else { echo "https://elitebaby.sk/files/shop/default.jpg";} ?>" class="img-news" alt="..."></td>
                        </tr>
                        <tr>
                            <td><a href="?c=home&a=film&filmId=<?= $film->id ?>" class="odkaz"><?= $posledny->nazov ?></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-12 obsah p-3">
                    <p>
                        <?=$posledny->obsah?>
                    </p>
                </div>
            </div>
    </div>
</div>
