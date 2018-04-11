<?php

namespace App\Http\Controllers;

use App\News;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Validator;

class NewsControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get all news
        $news = News::all();

        if ($request->wantsJson()) {
            $news = News::all();

            return DeckResource::collection($decks);
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'text' => 'required|string',
            'image' => 'image64:jpeg,jpg,png',
            'video' => 'string'    
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $fileName = $request->get('title') . '.png';

            $news = new News;
            $news->title = $request->get('title');
            $news->text = $request->get('text');

            $news->id_user = Auth::id();

            // MUDAR O RESIZE DEPOIS DE FAZER A VIEW
            if ($request->hasFile('image')) {
                Image::make($request->get('image'))->resize(75, 125)->save($public_path('img/news/') . '/' . $fileName);
                $news->image = 'img/news/' . $fileName;
            }
            
            if ($request->has('video')) {
                $news->video = $request->get('video');
            }

            $news->save();
            return response()->json(['msg' => 'Notícia criada com sucesso', 'error' => false]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $news = News::findOrFail($id);
        if (!empty($news->image)) {
            File::deleteDirectory('img/news/' . $news->image);
        }

        $news->delete();

        return response()->json(['msg' => 'Notícia apagada']);
    }
}
