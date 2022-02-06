<?php

namespace App\Controllers;

use App\Auth;
use App\Core\Responses\Response;
use App\Models\Obrazok;

class ImageController extends AControllerRedirect
{
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function pridajObrazok()
    {
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        $param['filmId'] = $this->request()->getValue('filmId');
        if (isset($_FILES['file'])) {
            $meno = date('Y-m-d-H-m-s_') . $_FILES['file']['name'];
            $path = "obrazky/$meno";
            $typObrazok = strtolower(pathinfo(basename($path), PATHINFO_EXTENSION));
            if ($typObrazok != "jpg" && $typObrazok != "png" && $typObrazok != "jpeg" && $typObrazok != "gif") {
                $param['error'] = "Mozete pridat len obrazok typu: JPG, JPEG, PNG & GIF!";
                $this->redirect('movie', 'film', $param);
                return;
            }
            if (strlen($path) > 255) {
                $param['error'] = "Meno obrazku je prilis dlhe!";
                $this->redirect('movie', 'film', $param);
                return;
            }
            if ($_FILES['file']['error'] == UPLOAD_ERR_OK) {
                move_uploaded_file($_FILES['file']['tmp_name'], $path);

                $obrazok = new Obrazok();
                $obrazok->film_id = $param['filmId'];
                $obrazok->obrazok = $path;
                $obrazok->save();
                $param['success'] = "Obrazok bol uspesne pridany!";
                $this->redirect('movie', 'film', $param);
            } else {
                $param['error'] = "Nepodarilo sa pridat obrazok!";
                $this->redirect('movie', 'film', $param);
            }
        } else {
            $param['error'] = "Nepodarilo sa pridat obrazok!";
            $this->redirect('movie', 'film', $param);
        }
    }

    public function zmazObrazok(){
        if (!Auth::isLogged()) {
            $this->redirect('home');
            return;
        }
        if (isset($_POST['obrazokId']) && isset($_POST['filmId'])){
            $param['filmId'] = $this->request()->getValue('filmId');
            $obrazok = Obrazok::getOne($this->request()->getValue('obrazokId'));
            $obrazok->zmaz();
            $param['success'] = "Obrazok bol uspesne odstraneny!";
            $this->redirect('movie','film',$param);
        } else {
            $this->redirect('home');
        }
    }
}