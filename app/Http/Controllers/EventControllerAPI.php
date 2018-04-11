<?php

namespace App\Http\Controllers;

use App\Events;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

use Validator;



class EventControllerAPI extends Controller
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
            $events = Events::all();

            return NewsResource::collection($events);
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
            'localization' => 'required|string',
            'video' => 'required|date'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $event = new Events;
            $event->title = $request->get('title');
            $event->text = $request->get('text');

            $event->id_user = Auth::id();
            // 0 - por realizar
            // 1 - a ser realizado
            // 2 - concluido
            $event->status = 0;

            $event->save();
            return response()->json(['msg' => 'Evento criada com sucesso', 'error' => false]);
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
        $event = Events::findOrFail($id);

        $event->delete();

        return response()->json(['msg' => 'Evento apagado']);
    }

    public function getEventosPorRealizar(Request $request)
    {
        if ($request->wantsJson()) {
            $events = Events::where('status', 0)->get();

            return EventsResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    public function getEventosADecorrer(Request $request)
    {
        if ($request->wantsJson()) {
            $events = Events::where('status', 1)->get();

            return EventsResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    public function getEventosConcluidos(Request $request)
    {
        if ($request->wantsJson()) {
            $events = Events::where('status', 2)->get();

            return EventsResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }
}
