<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Repository\RealStateRepository;
use Illuminate\Http\Request;

class RealStateSearchController extends Controller
{
    protected $realState;

    public function __construct(RealState $realState)
    {
        $this->realState = $realState;
    }

    public function index(Request $request) //exemplo: {{base_url}}/api/v1/search?fields=title,content,price&state=1&city=1
    {

        $repository = new RealStateRepository($this->realState);

        if($request->has('coditions')){
            $repository->selectCoditions($request->get('coditions'));
        }
        if($request->has('fields')){
            $repository->selectFilter($request->get('fields'));
        }

        $repository->setLocation($request->all(['state', 'city']));

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }

    public function show($id)
    {
        //
    }

}
