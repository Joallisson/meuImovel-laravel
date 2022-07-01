<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
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
        $realState = auth('api')->user()->real_state();

        return response()->json($realState->paginate(50), 200);
   }

   public function show($id){

        try {

            $realState = auth('api')->user()->real_state->with('photos')->findOrFail($id); //buscando os imovóveis com as fotos se o usuário estiver autenticado

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

        $images = $request->file('images');

        try {

            $data['user_id'] = auth('api')->user()->id; //Se o usuário passar o id no frontend então ele vai ser sobreescrito pelo id do usuário autenticado

            $realState = $this->realState->create($data);

            if (isset($data['categories']) && $data['categories'] > 0) { //se $data['categories'] existir e for maior que 0
                $realState->categories()->attach($data['categories']); //então insere na tabela pivot intermediária category_real_state os iIDs da categoria e do real state
            }

            if($images){
                $imagesUploaded = [];

                foreach($images as $image){
                    $path = $image->store('images', 'public');

                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => 0];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

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

        $realState = $data = $request->all();
        $images = $request->file('images');

        try {

            $realState = auth('api')->user()->real_state()->findOrFail($id);
            $realState->update($data);

            if (isset($data['categories']) && $data['categories'] > 0) { //se $data['categories'] existir e for maior que 0
                $realState->categories()->sync($data['categories']); //então atualioza na tabela pivot intermediária category_real_state os iIDs da categoria e do real state
            }

            if($images){
                $imagesUploaded = [];

                foreach($images as $image){
                    $path = $image->store('images', 'public');

                    $imagesUploaded[] = ['photo' => $path, 'is_thumb' => 0];
                }

                $realState->photos()->createMany($imagesUploaded);
            }

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

        $realState = auth('api')->user()->real_state()->findOrFail($id);

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
