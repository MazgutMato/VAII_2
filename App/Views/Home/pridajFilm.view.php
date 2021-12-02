<div class="container bg-dark mt-5">
    <div class="row">
        <div class="col-12 mt-3"><h1>Pridanie filmu</h1></div>
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

        <form method="post" action="?c=home&a=formFilm">
            <div class="mb-3">
                <label for="orgNazov" class="form-label">Zadaj základne informacie o filme:</label>
                <input class="form-control mb-1" placeholder="Názov" type="text" name="nazov" required>
                <input class="form-control mb-1" placeholder="Orig.nazov" type="text" name="orgNazov" required>
                <input class="form-control mb-1" placeholder="Žáner" type="text" name="zaner" required>
                <input class="form-control mb-1" placeholder="Krajina" type="text" name="krajina" required>
                <input class="form-control mb-1" placeholder="Režia" type="text" name="rezia" required>
                <input class="form-control mb-1" placeholder="Scenár" type="text" name="scenar" required>
                <input class="form-control mb-1" placeholder="Hrajú" type="text" name="hraju" required>
            </div>

            <div class="form-floating mb-3">
                <p>Obsah:</p>
                <textarea class="form-control " id="obsah" name="obsah" ></textarea>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-secondary" name="pridaj" value="Pridaj">
            </div>
        </form>
    </div>
</div>