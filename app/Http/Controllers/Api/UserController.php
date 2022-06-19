<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = $this->user->paginate('10');

        return response()->json($user, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if(!$request->has('password') && !$request->get('password')){

            $message = new ApiMessages('É necessário informar uma senha para o usuário');
            return response()->json($message->getMessege(), 401);
        }

        Validator::make($data, [
            'profile.phone' => 'required', //o profile.phone é usado por que a chave phone está dentro de um array
            'profile.mobile_phone' => 'required]'
        ]);

        try {

            $data['password'] = bcrypt($data['password']);
            $user = $this->user->create($data);

            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user->profile()->create($profile);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário cadastrado com sucesso'
                ]
            ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $user = $this->user->findOrFail($id);

             return response()->json([
                'data' => $user
             ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
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
        $data = $request->all();

        //dd($data);

        if(!$request->has('password') && !$request->get('password'))
        {
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']); //A função unset anula uma variável
        }

        Validator::make($data, [
            'profile.phone' => 'required', //o profile.phone é usado por que a chave phone está dentro de um array
            'profile.mobile_phone' => 'required]'
        ]);

        try {
            $profile = $data['profile'];
            $profile['social_networks'] = serialize($profile['social_networks']);

            $user = $this->user->findOrFail($id);
            $user->update($data);


            $user->profile()->update($profile);

            //dd($profile);

            return response()->json([
                'data' => [
                    'msg' => 'Usuário atualizado com sucesso'
                ]
            ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = $this->user->findOrFail($id);
            $user->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Usuário removido com sucesso'
                ]
            ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
    }
}
