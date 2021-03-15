<?php
namespace App\Services;

use App\Http\Requests;

class AutorizadorService
{
    private $autorizador;

    public function __construct()
    {
        $this->autorizador = file_get_contents('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
    }

    public function defineAutorizacao()
    {
        return json_decode($this->autorizador, true)['message'] == "Autorizado" ? true : false;
    }
}
