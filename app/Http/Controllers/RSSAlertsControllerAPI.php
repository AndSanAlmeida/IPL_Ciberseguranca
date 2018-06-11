<?php


namespace App\Http\Controllers;

use App\RSSAlert;
use Illuminate\Http\Request;
use App\Http\Resources\RSSAlertsResource;
use Illuminate\Support\Facades\DB;
use Validator;

class RSSAlertsControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $rssAlerts = RSSAlert::all();

            return RSSAlertsResource::collection($rssAlerts);
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
            $rssAlerts = new RSSAlert;
            $rssAlerts->website = $request->get('website');
            $rssAlerts->url = $request->get('url');

            $rssAlerts->save();
            return response()->json(['msg' => 'RSS de alerta adicionado com sucesso', 'error' => false]);
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
        $rssAlerts = RSSAlert::findOrFail($id);
        return $rssAlerts;
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

            $rssAlerts = RSSAlert::findOrFail($id);

            $rssAlerts->website = $request->get('website');
            $rssAlerts->url = $request->get('url');

            $rssAlerts->update();

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
        $rssAlerts = RSSAlert::findOrFail($id);

        $rssAlerts->delete();

        return response()->json(['msg' => 'RSS apagado com sucesso.']);
    }
}
