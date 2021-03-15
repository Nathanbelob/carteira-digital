<?php

namespace App\BO;

use Illuminate\Http\Request;
use App\Http\Repositories\UserRepository;
use App\Services\AutorizadorService;
use App\Services\EnvioNotificacaoService;

class UserBO
{
    private $retorno;
    private $mensagem;
    private $response;

    public function __construct()
    {
        $this->retorno = true;
        $this->mensagem = '';
        $this->response = new \stdClass();
    }

    public function findById($idUser)
    {
        return UserRepository::findById($idUser);
    }

    public function update($request, $user)
    {
        return UserRepository::update($request, $user);
    }

    public function executeTransaction($request)
    {
        \DB::beginTransaction();
        try{
            if($request->payer == $request->payee)
            {
                $this->response->mensagem = 'Operação inválida';
                return response()->json($this->response);
            }

            $payer = $this->findById($request->payer);
            $payee = $this->findById($request->payee);
            
            if(!\in_array($payer->tipo->sigla, config('permissoes_transacoes.pagar'))){
                $this->response->mensagem = 'Operação não permitida para esse tipo de usuário.';
                return response()->json($this->response);
            }
    
            if($request->value > $payer->saldo){
                $this->response->mensagem = 'Saldo insuficiente para realizar a transação.';
                return response()->json($this->response);
            }
    
            if((new AutorizadorService())->defineAutorizacao())
            {
                if($this->trataTransacao($request->except('payee'), $payer) && 
                $this->trataTransacao($request->except('payer'), $payee) &&
                (new EnvioNotificacaoService())->envioDisponivel()){
                    $this->response->mensagem = 'Transação efetuada com sucesso!';
                    \DB::commit();
                    return response()->json($this->response);
                }
            }

            $this->response->mensagem = 'Erro ao efetuar a transação';
            \DB::rollback();
            return response()->json($this->response);
        } catch(\Exception $e){
            \DB::rollback();
            $this->response->mensagem = $e->getMessage();
            return response()->json($this->response, 500);
        }
    }

    public function trataTransacao($request, $user)
    {
        if(\array_key_exists("payer", $request)){
            $novoSaldo = $user->saldo - $request['value'];
        } else {
            $novoSaldo = $user->saldo + $request['value'];
        }

        return $this->update(['saldo' => $novoSaldo], $user);
    }
}
