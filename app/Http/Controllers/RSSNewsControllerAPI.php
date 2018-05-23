<?php

namespace App\Http\Controllers;

use App\RSSNews;
use Illuminate\Http\Request;
use App\Http\Resources\RSSNewsResource;
use Illuminate\Support\Facades\DB;
use Validator;

class RSSNewsControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $rssNews = RSSNews::all();

            return RSSNewsResource::collection($rssNews);
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
            'website' => 'required|string|max:200',
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $rssNews = new RSSNews;
            $rssNews->website = $request->get('website');
            $rssNews->url = $request->get('url');

            $rssNews->save();
            return response()->json(['msg' => 'RSS de notícias adicionado com sucesso', 'error' => false]);
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
        $rssNews = RSSNews::findOrFail($id);
        return $rssNews;
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
        $validator = Validator::make($request->all(), [
            'website' => 'required|string|max:200',
            'url' => 'required|url',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $rssNews = RSSNews::findOrFail($id);

            $rssNews->website = $request->get('website');
            $rssNews->url = $request->get('url');

            $rssNews->update();

            return response()->json(['msg' => 'RSS editado com sucesso.']);
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
        $rssNews = RSSNews::findOrFail($id);

        $rssNews->delete();

        return response()->json(['msg' => 'RSS apagado com sucesso.']);
    }
}
