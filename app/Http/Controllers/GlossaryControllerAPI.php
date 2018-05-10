<?php

namespace App\Http\Controllers;

use App\Glossary;
use Illuminate\Http\Request;
use App\Http\Resources\GlossaryResource;
use Illuminate\Support\Facades\DB;
use Validator;



class GlossaryControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $glossary = Glossary::all();

            return GlossaryResource::collection($glossary);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'definition' => 'required|string|max:100',
            'source' => 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $glossary = new Glossary;
            $glossary->name = $request->get('name');
            $glossary->definition = $request->get('definition');
            $glossary->source = $request->get('source');

            $glossary->save();
            return response()->json(['msg' => 'Entrada do glossário criada com sucesso', 'error' => false]);
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
        $glossary = Glossary::findOrFail($id);
        return $glossary;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'definition' => 'required|string|max:100',
            'source' => 'required|string|max:100',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $glossary = Glossary::findOrFail($id);

            $glossary->name = $request->get('name');
            $glossary->definition = $request->get('definition');
            $glossary->source = $request->get('source');

            $glossary->save();

            return response()->json(['msg' => 'Entrada do glossário editada com sucesso.']);
        } else {
            return response()->json(['errorCode' => -1, 'msg' => $validator->errors()], 400);
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
        $glossary = Glossary::findOrFail($id);

        $glossary->delete();

        return response()->json(['msg' => 'Entrada do glossário apagada com sucesso.']);
    }
}
