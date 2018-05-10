<?php

namespace App\Http\Controllers;

use App\UsefulLink;
use Illuminate\Http\Request;
use App\Http\Resources\UsefulLinkResource;
use Illuminate\Support\Facades\DB;
use Validator;

class UsefulLinksControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $glossary = UsefulLink::all();

            return UsefulLinkResource::collection($glossary);
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
        $validator = Validator::make($request->all(), [
            'description' => 'required|string|max:200',
            'link' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $usefulLink = new UsefulLink;
            $usefulLink->description = $request->get('description');
            $usefulLink->link = $request->get('link');

            $usefulLink->save();
            return response()->json(['msg' => 'Link útil criado com sucesso', 'error' => false]);
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
        $usefulLink = UsefulLink::findOrFail($id);
        return $usefulLink;
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
            'description' => 'required|string|max:200',
            'link' => 'required|url',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $usefulLink = UsefulLink::findOrFail($id);

            $usefulLink->description = $request->get('description');
            $usefulLink->link = $request->get('link');

            $usefulLink->save();

            return response()->json(['msg' => 'Link útil editado com sucesso.']);
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
        $usefulLink = UsefulLink::findOrFail($id);

        $usefulLink->delete();

        return response()->json(['msg' => 'Link útil apagado com sucesso.']);
    }
}
