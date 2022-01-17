<?php /** @var Array $data */ ?>
<script src="public/zoznam_filmov.js"></script>
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
            <div class="col-12 mt-3 border-bottom mb-3">
                <h1>Zoznam filmov</h1>
            </div>
        </div>
        <div class="row bg-danger border m-3">
            <div class="col-12 col-lg-3 mt-3 d-flex justify-content-center">
                <div class="d-flex justify-content-center">
                    <p class="text-center">Zoradiť podľa: </p>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-2">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary" id="nazov">Nazov</button>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-2">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary" id="hodnotenie">Hodnotenie</button>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-2 mb-2">
                <div class="d-flex justify-content-center">
                    <button class="btn btn-secondary" id="datum">Dátum pridania</button>
                </div>
            </div>
        </div>
        <div class="row m-3 justify-content-end">
            <div class="col-12 col-lg-3">
                <input type="text" class="form-control mb-3" id="nazovFilmu" placeholder="Zadaj názov filmu">
            </div>
            <div class="col-12 col-lg-2">
                <button type="submit" class="btn btn-secondary mb-3" id="vyhladaj">Vyhladaj</button>
            </div>
        </div>
        <div class="row" id="film"></div>
    </div>
</div>
