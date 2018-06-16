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
        $alert = Alert::findOrFail($id);
        return $alert;
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
            'title' => 'required|string',
            'description' => 'required|string',
            'source' => 'required|string',
            'pubDate' => 'required',
            'category' =>'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $alert = Alert::findOrFail($id);
            $alert->title = $request->get('title');
            $alert->category = $request->get('category');
            $alert->description = $request->get('description');
            $alert->source = $request->get('source');
            $alert->pub_date = $request->get('pubDate');
            $alert->update();

            return response()->json(['msg' => 'Alerta criado com sucesso', 'error' => false]);
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
        $news = Alert::findOrFail($id);
        $news->delete();

        return response()->json(['msg' => 'Alerta apagado']);
    }

    public function createXML(Request $request) {
        $xmlString = '
        <rss xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" version="2.0">
            <channel>
                <title>IPLeiria - Cibersegurança</title>
                <link>https://www.ipl.test</link>
                <description>Alertas</description>
                <language>pt-PT</language>
                <copyright>@2018 IPLeiria - Cibersegurança</copyright>';
                foreach ($request->get('alerts') as $item) {
                    $alert = (object)$item;
                    $dateTime = new \DateTime($alert->pubDate[0]); 
                    echo $dateTime->format('U'); 
                    $date = \Date ('l, d F o 00:00:00 +0100', $dateTime->format('U'));
                    $xmlString = $xmlString.'
                    <item>
                        <title><![CDATA['.$alert->title[0].']]></title>
                        <description><![CDATA['.$alert->description[0].']]></description>
                        <description><![CDATA['.$alert->category[0].']]></description>
                        <pubDate>'.$date.'</pubDate>
                        <link>http://ipl.test/#/resources/alerts/'.html_entity_decode($alert->title[0]).'</link>
                    </item>';
                }

        $xmlString = $xmlString.'
            </channel>
        </rss>';

        $dom = new \DOMDocument;
        $dom->preserveWhiteSpace = FALSE;
        $dom->loadXML($xmlString);

        //Save XML as a file
        $dom->save(public_path('feedAlerts.xml'));

        //View XML document
        $dom->formatOutput = TRUE;
        echo $dom->saveXml();
    }
}
