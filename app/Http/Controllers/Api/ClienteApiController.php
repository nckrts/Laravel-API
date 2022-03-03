<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\MasterApiController;
use App\Models\Models\Cliente;
use Illuminate\Http\Request;


class ClienteApiController extends MasterApiController
{
        protected $model;
        protected $path = 'clientes';
        protected $upload = 'image';

    public function __construct(Cliente $clientes, Request $request){
        $this->model = $clientes;
        $this->request = $request;
   }

}
