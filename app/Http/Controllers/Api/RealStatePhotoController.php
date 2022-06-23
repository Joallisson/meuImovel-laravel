<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\RealStatePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealStatePhotoController extends Controller
{
    protected $realStatePhoto;
    public function __construct(RealStatePhoto $realStatePhoto)
    {
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb($photoId, $realStateId){ //Atualizar thum
        try{
            $photo = $this->realStatePhoto
                ->where('real_state_id', $realStateId)
                ->where('is_thumb', true);

            if($photo->count()){
                $photo = $photo->update(['is_thumb' => false]); //se tiver uma thumb ativa no banco de dados então vai desativar ela
            }

            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);

            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso!'
                ]
            ]);

        }catch(\Throwable $th){
            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
    }

    public function remove($photoId){ //Apagar imagem do db e do Storage
        try{

            $photo = $this->realStatePhoto->find($photoId);

            if($photo->is_thumb){ //se a foto a ser removida for a tumbmail
                $message = new ApiMessages('Não é possível remover foto de thumb, selecione outra thumb e remova a imagem desejada!');
                return response()->json($message->getMessege(), 401);
            }

            if($photo){
                Storage::disk('public')->delete($photo->photo); //Apagando foto no driver local// Caminho local de onde a foto está armazenada: storage/app/public/images
                $photo->delete(); //Apagando foto na tabela
            }

            return response()->json([
                'data' => [
                    'msg' => 'Foto removida com sucesso!'
                ]
            ]);

        }catch(\Throwable $th){
            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
    }
}
