<?php

namespace App\Http\Controllers;

use App\Api\ApiMessages;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
//use Facade\FlareClient\Api;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
         $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = $this->category->paginate('10');

        return response()->json($category, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();


        try {

            $this->category->create($data);

            return response()->json([
                'data' => [
                    'msg' => 'Categoria cadastrada com sucesso'
                ]
            ]);

        } catch (\Throwable $th) {
            //return response()->json($th->getMessage());
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

            $category = $this->category->findOrFail($id);

             return response()->json([
                'data' => $category
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
    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();

        try {

            $category = $this->category->findOrFail($id);
            $category->update($data);

            return response()->json([
                'data' => [
                    'msg' => 'Categoria atualizada com sucesso'
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

            $category = $this->category->findOrFail($id);
            $category->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Categoria removida com sucesso'
                ]
            ]);

        } catch (\Throwable $th) {

            $message = new ApiMessages($th->getMessage());
            return response()->json($message->getMessege(), 401);
        }
    }
}
