<div class="container bg-dark mt-5">
    <div class="row">
        <div class="col-12 mt-3 border-bottom mb-3"><h1>Pridanie filmu</h1></div>
    </div>
    <div class="row m-3">
        <?php if (isset($_GET['success'])) {?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?= $_GET['success'] ?>
            </div>
        <?php } ?>
        <?php if (isset($_GET['error'])) {?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                <?= $_GET['error'] ?>
            </div>
        <?php } ?>

        <form method="post" action="?c=movie&a=formFilm" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nazov" class="form-label">Zadaj základne informacie o filme:</label>
                <input class="form-control mb-1" placeholder="Názov" type="text" name="nazov" id="nazov" required>
                <input class="form-control mb-1" placeholder="Orig.nazov" type="text" name="orgNazov" required>
                <input class="form-control mb-1" placeholder="Žáner" type="text" name="zaner" required>
                <input class="form-control mb-1" placeholder="Krajina" type="text" name="krajina" required>
                <input class="form-control mb-1" placeholder="Režia" type="text" name="rezia" required>
                <input class="form-control mb-1" placeholder="Scenár" type="text" name="scenar" required>
                <input class="form-control mb-1" placeholder="Hrajú" type="text" name="hraju" required>
                <label class="form-label" for="premiera">Dátum premiery</label>
                <input class="form-control mb-1" type="date" name="premiera" id="premiera" required>
                <label class="form-label" for="obrazok">Pridaj obrazok</label>
                <input class="form-control" type="file" name="file" id="obrazok" required>

            </div>
                <label class="form-label" for="obsah">Pridaj obsah</label>
                <textarea rows="5" class="form-control " id="obsah" name="obsah" required></textarea>
            <div class="mb-3 mt-2">
                <input type="submit" class="btn btn-secondary" name="pridaj" value="Pridaj">
            </div>
        </form>
    </div>
</div>