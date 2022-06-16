<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages\ApiMessages;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealStateRequest;
use App\Models\RealState;

class RealStateController extends Controller
{
    private $realState;

    public function __construct(RealState $realState){
        $this->realState = $realState;
    }

   public function index(){
       $realState = $this->realState->paginate('10');

       return response()->json($realState, 200);
   }

   public function show($id){

        try {

            $realState = $this->realState->findOrFail($id);

             return response()->json([
                'data' => $realState
             ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }

   }

   public function store(RealStateRequest $request){ //Lembrar de adicionar no cabeçalho da requisição o "Accept application/json"

        $data = $request->all();

        try {

            $realState = $this->realState->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'imóvel cadastrado com sucesso'
                ]
            ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }


   }

   public function update($id, RealStateRequest $request){

    $data = $request->all();

    try {

        $realState = $this->realState->findOrFail($id);
        $realState->update($data);

        return response()->json([
            'data' => [
                'msg' => 'Imóvel atualizado com sucesso'
            ]
        ]);

    } catch (\Throwable $th) {

        $message = new ApiMessages($th->getMessage());
        return response()->json($message->getMessege(), 401);
    }
   }

   public function destroy($id){

    try {

        $realState = $this->realState->findOrFail($id);
        $realState->delete();

        return response()->json([
            'data' => [
                'msg' => 'Ímóvel removido com sucesso'
            ]
        ]);

    } catch (\Throwable $th) {

        $message = new ApiMessages($th->getMessage());
        return response()->json($message->getMessege(), 401);
    }
   }
}
