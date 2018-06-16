<?php

namespace App\Http\Controllers;

use App\News;
use App\Http\Resources\NewsResource;
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
    public function index(Request $request)
    {
        // get all news
        if ($request->wantsJson()) {
            $news = News::all();

            return NewsResource::collection($news);
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
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $news = new News;
            $news->title = $request->get('title');
            $news->description = $request->get('description');
            $news->source = $request->get('source');
            $news->pub_date = $request->get('pubDate');
            $news->save();

            return response()->json(['msg' => 'Notícia criada com sucesso', 'error' => false]);
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
        $news = News::findOrFail($id);
        return $news;
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
            'title' => 'required|string|max:100',
            'source' => 'required|string|max:100',
            'description' => 'required|string',
            'date' => 'required',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $news = News::findOrFail($id);
         
            $news->title = $request->get('title');
            $news->source = $request->get('source');
            $news->description = $request->get('description');
            $news->pub_date = $request->get('date');
            
            $news->save();

            return response()->json(['msg' => 'Notícia editada.']);
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
        $news = News::findOrFail($id);
        $news->delete();

        return response()->json(['msg' => 'Notícia apagada']);
    }

    public function createXML(Request $request) {
        $xmlString = '
        <rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" version="2.0">
            <channel>
                <title>IPLeiria - Cibersegurança</title>
                <link>https://www.ipl.test</link>
                <description>Notícias</description>
                <language>pt-PT</language>
                <copyright>@2018 IPLeiria - Cibersegurança</copyright>';
                foreach ($request->get('news') as $item) {
                    $singleNews = (object)$item;
                    $dateTime = new \DateTime($singleNews->pubDate[0]); 
                    echo $dateTime->format('U'); 
                    $date = \Date ('l, d F o 00:00:00 +0100', $dateTime->format('U'));
                    $xmlString = $xmlString.'
                    <item>
                        <title><![CDATA['.$singleNews->title[0].']]></title>
                        <description><![CDATA['.$singleNews->description[0].']]></description>
                        <pubDate>'.$date.'</pubDate>
                        <link>http://ipl.test/#/resources/news/'.html_entity_decode($singleNews->title[0]).'</link>
                    </item>';
                }

        $xmlString = $xmlString.'
            </channel>
        </rss>';

        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlString);

        //Save XML as a file
        $dom->save(public_path('feedNews.xml'));

        //View XML document
        $dom->formatOutput = TRUE;
        echo $dom->saveXml();
    }
}
