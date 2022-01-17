<?php /** @var Array $data */
$arraySize = count($data['filmy']);
if ($arraySize > 0){
    $posledny = $data['filmy'][($arraySize-1)];
}
?>
<!--Filmove novinky-->
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
        <?php
        if (isset($posledny)) {
            ?>
            <div class="row">
                <div class="col-12 mt-3 border-bottom mb-3">
                    <h1>Najnovšie pridaný</h1>
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
                    <p>
                        Príspevok pridal: <?= $posledny->autor ?>
                    </p>
                </div>
                <div class="col-12 col-lg-6">
                    <table class="table tabulka">
                        <tbody>
                        <tr>
                            <td><a href="?c=home&a=film&filmId=<?= $posledny->id ?>" class="odkaz">
                                <img src="<?php echo $posledny->obrazok?>" class="img-news" alt="obrazky/chyba.jpg"></a>
                            </td>
                        </tr>
                        <tr>
                            <td><a href="?c=home&a=film&filmId=<?= $posledny->id ?>" class="odkaz"><?= $posledny->nazov ?></a></td>
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
            <div class="row">
                <div class="col-12 mt-3 border-bottom mb-3">
                    <h1>Posledné pridané</h1>
                </div>
            </div>
            <?php } ?>
        <div class="row">
            <?php
            foreach ($data['filmy'] as $key => $film) {
                if ($key > ($arraySize - 5) && $key < ($arraySize-1) ) { ?>
                    <div class="col-12 col-lg-4">
                    <table class="table tabulka">
                        <tbody>
                        <tr>
                            <td><a href="?c=home&a=film&filmId=<?= $film->id ?>" class="odkaz">
                                <img src=" <?php echo $film->obrazok?>" class="img-news" alt="obrazky/chyba.jpg"></a></td>
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
    </div>
</div>
