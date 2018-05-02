<?php

namespace App\Http\Controllers;

use App\Events;
use App\Http\Resources\EventsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Auth;
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

            return EventsResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'localization' => 'required|string',
            'description' => 'required|string',
            'date' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $event = new Events;
            $event->name = $request->get('name');
            $event->localization = $request->get('localization');
            $event->description = $request->get('description');
            $event->date = $request->get('date');

            // image
            $fileName = $event->name.'.png';
            File::makeDirectory(public_path('img/eventos'), $mode = 0777, true, true);
            $path = public_path('img/eventos');
            Image::make($request->get('image'))->save($path . '/' . $fileName);
            $event->image_path = 'img/eventos/' . $fileName;

            $event->id_user = Auth::id();
            // 0 - por realizar
            // 1 - a ser realizado
            // 2 - concluido
            $event->status = 0;

            $event->save();
            return response()->json(['msg' => 'Evento criado com sucesso', 'error' => false]);
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
        $event = Events::findOrFail($id);
        return $event;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'localization' => 'required|max:255',
            'description' => 'required',
            'date' => 'required',
            'status' => 'required',
            'image' => 'required',

        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $event = Events::findOrFail($id);

            // apagar caso o nome seja alterado
            $fileName = $event->name.'.png';
            File::makeDirectory(public_path('img/eventos'), $mode = 0777, true, true);
            $path = public_path('img/eventos');
            File::delete($path . '/' . $fileName);

            $event->name = $request->get('name');
            $event->localization = $request->get('localization');
            $event->description = $request->get('description');
            $event->date = $request->get('date');
            $event->status = $request->get('status');

            // image
            $fileName = $event->name.'.png';
            File::makeDirectory(public_path('img/eventos'), $mode = 0777, true, true);
            $path = public_path('img/eventos');
            Image::make($request->get('image'))->save($path . '/' . $fileName);
            $event->image_path = 'img/eventos/' . $fileName;

            $event->save();

            return response()->json(['msg' => 'Evento editado.']);
        } else {
            return response()->json(['errorCode' => -1, 'msg' => 'Request Invalido.'], 400);
        }
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
