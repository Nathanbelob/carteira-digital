<?php
namespace App\Services;

use App\Http\Requests;

class EnvioNotificacaoService
{
    private $envio;

    public function __construct()
    {
        $this->envio = file_get_contents('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
    }

    public function envioDisponivel()
    {
        return json_decode($this->envio, true)['message'] == "Enviado" ? true : false;
    }
}
