<?php

namespace App\Http\Controllers;

use App\Alert;
use App\Http\Resources\AlertsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;

class AlertsControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // get all news
        if ($request->wantsJson()) {
            $news = Alert::all();

            return AlertsResource::collection($news);
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
            'title' => 'required|string',
            'description' => 'required|string',
            'source' => 'required|string',
            'pubDate' => 'required',
            'category' =>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $alert = new Alert;
            $alert->title = $request->get('title');
            $alert->category = $request->get('category');
            $alert->description = $request->get('description');
            $alert->source = $request->get('source');
            $alert->pub_date = $request->get('pubDate');
            $alert->save();

            return response()->json(['msg' => 'Alerta criado com sucesso', 'error' => false]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = Alert::findOrFail($id);
        $news->delete();

        return response()->json(['msg' => 'Alerta apagado']);
    }
}
