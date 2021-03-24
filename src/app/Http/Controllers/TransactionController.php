<?php

namespace App\Http\Controllers;

use Validator;
use App\BO\UserBO;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    private $retorno;
    private $codigo;


        /**
     * Set default values to return in
     */
    public function __construct()
    {
        $this->codigo = 200;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function executaTransacao(Request $request)
    {
        $validator = Validator::make($request->all(), $this->_rules());

        if ($validator->fails()) {
            return response()->json($validator->messages(), 400);
        }

        $userBO = new UserBO();
        $this->retorno = $userBO->executeTransaction($request);
        if(!$this->retorno){
            $this->codigo = 500;
        }

        return response()->json($this->retorno, $this->codigo);  
    }

    private function _rules()
    {
        return [
            'value' => 'required|numeric',
            'payer' => 'required|numeric',
            'payee' => 'required|numeric'
        ];
    }
}
