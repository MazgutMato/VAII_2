<?php

namespace App\Controllers;

use App\Core\Responses\Response;

abstract class AControllerRedirect extends \App\Core\AControllerBase
{
    protected function redirect($controller, $action = "", $params = [])
    {
        $location = "Location: ?c=$controller";
        if ($action != "") {
            $location .= "&a=$action";
        }
        foreach ($params as $name => $value) {
            $location .= "&$name=" . urlencode($value);
        }
        header($location);
    }
}