<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class MasterApiController extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){

        $data = $this->model->all();
        return response()->json($data);
    }


    public function store(Request $request)
    {
        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if($request->hasFile($this->upload) && $request->file($this->upload)->isValid()){ //Vai  verificar se tem imagem
            $extension = $request->image->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}"; //retorna os valores para o banco de dados

            $upload = Image::make($dataForm[$this->upload])->resize(177, 236)->save(storage_path("app/public/{$this->path}/$nameFile", 70));

            if(!upload){
                return response()->json(['error'=> 'Falha ao fazer upload'], 500);
            }else{
                $dataForm[$this->upload] = $nameFile;
            }

        }

        $data = $this->model->create($dataForm); //Criando novo cadastro

        return response()->json($data, 201);
    }


    public function show($id)
    {
        if (!$data = $this->model->find($id)) {
            return response()->json(['nada foi encontrado'], 404);
        }
        else {

            return response()->json($data);
        }
    }


    public function update(Request $request, $id)
    {
        if (!$data = $this->model->find($id))
            return response()->json(['error' => 'Nada foi encontrado'], 404);

        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if($request->hasFile($this->upload) && $request->file($this->upload)->isValid()){ //Vai  verificar se tem imagem

            if ($data->image)
            {
                Storage::disk('local')->delete("/{$this->path}/$data->image");
            }

            $extension = $request->file($this->upload)->extension();

            $name = uniqid(date('His'));

            $nameFile = "{$name}.{$extension}"; //retorna os valores para o banco de dados

            $upload = Image::make($dataForm[$this->upload])->resize(177, 236)->save(storage_path("app/public/clientes/$nameFile", 70));

            if(!upload){
                return response()->json(['error'=> 'Falha ao fazer upload'], 500);
            }else{
                $dataForm[$this->upload] = $nameFile;
            }

        }

        $data->update($dataForm);

        return response()->json($data);
    }


    public function destroy($id)
    {
        if (!$data = $this->model->find($id))
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        if ($data->image)
        {
            Storage::disk('local')->delete("/cliente/$data->image");
        }
        $data->delete();
        return response()->json(['sucess' => 'Deletado com sucesso']);
    }

}

