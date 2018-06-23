<?php

namespace App\Http\Controllers;

use App\Event;
use App\User;
use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Mail\TransportManager;
use App\Http\Resources\SmallerUserResource;
use Auth;
use Validator;
use Storage;

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
            $events = Event::all()->sortBy('date')->reverse();

            return EventResource::collection($events);
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
            'name' => 'required|string|max:100',
            'organizer' => 'required|string|max:100',
            'localization' => 'required|string|max:100',
            'description' => 'required|string',
            'date' => 'required',
            'max_inscritos' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $event = new Event;
            $event->name = $request->get('name');
            $event->localization = $request->get('localization');
            $event->description = $request->get('description');
            $event->date = $request->get('date');
            $event->max_inscritos = $request->get('max_inscritos');
            $event->organizer = $request->get('organizer');

            if (is_null($request->get('file'))) {
                $event->path = null;
            } else {
                $event->path = $request->get('file');
            }

            if (is_null($request->get('image'))) {
                $event->image_path = null;
            } else {
                // image
                $fileName = $event->name.'.png';
                File::makeDirectory(public_path('img/eventos'), $mode = 0777, true, true);
                $path = public_path('img/eventos');
                Image::make($request->get('image'))->save($path . '/' . $fileName);
                $event->image_path = 'img/eventos/' . $fileName;
            }           

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
        $event = Event::findOrFail($id);
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
            'name' => 'required|string|max:100',
            'organizer' => 'required|string|max:100',
            'localization' => 'required|string|max:100',
            'description' => 'required|string',
            'max_inscritos' => 'required|integer',
            'date' => 'required',
            'status' => 'required',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $event = Event::findOrFail($id);

            if (!empty($request->get('image'))) {
                // apagar caso o nome seja alterado
                $fileName = $event->name.'.png';
                File::makeDirectory(public_path('img/eventos'), $mode = 0777, true, true);
                $path = public_path('img/eventos');
                File::delete($path . '/' . $fileName);
            } 

            // caso a imagem nao seja alterada mas o nome sim
            if (empty($request->get('image')) && $event->name != $request->get('name')) {
                $path = public_path('img/eventos');
                $fileNameNew = $path .'/'. $request->get('name').'.png';
                $fileNameOld =  $path .'/'. $event->name.'.png';
                
                Image::make(public_path($event->image_path))->save($fileNameNew);
                File::delete($fileNameOld);
            }

            $event->name = $request->get('name');
            $event->localization = $request->get('localization');
            $event->description = $request->get('description');
            $event->date = $request->get('date');
            $event->status = $request->get('status');
            $event->organizer = $request->get('organizer');
            $event->max_inscritos = $request->get('max_inscritos');
            $event->path = $request->get('path');
            if (!empty($request->get('image'))) {
                // image
                $fileName = $event->name.'.png';
                File::makeDirectory(public_path('img/eventos'), $mode = 0777, true, true);
                $path = public_path('img/eventos');
                Image::make($request->get('image'))->save($path . '/' . $fileName);
                $event->image_path = 'img/eventos/' . $fileName;
            } else {
                $fileName = $event->name.'.png';
                $event->image_path = 'img/eventos/' . $fileName;
            }
            
            $event->save();

            return response()->json(['msg' => 'Evento editado.']);
        } else {
            return response()->json(['errorCode' => -1, 'msg' => $validator->errors()], 400);
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
        $event = Event::findOrFail($id);

        $event->delete();

        return response()->json(['msg' => 'Evento apagado']);
    }

    public function getEventosPorRealizar(Request $request)
    {
        if ($request->wantsJson()) {
            $events = Event::where('status', 0)->get();

            return EventResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    public function getEventosADecorrer(Request $request)
    {
        if ($request->wantsJson()) {
            $events = Event::where('status', 1)->get();

            return EventResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    public function getEventosConcluidos(Request $request)
    {
        if ($request->wantsJson()) {
            $events = Event::where('status', 2)->get();

            return EventResource::collection($events);
        } else {
            return response()->json(['message' => 'Request inválido.'], 400);
        }
    }

    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'events_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $event = Event::find($request->get('events_id'));
            $user = User::find($request->get('user_id'));

            $user->event()->save($event);

            $event->total_interested = $event->subscribers->count('user_id');
            $event->save();

            return response()->json(['msg' => 'Inscrição realizada com sucesso.', ]);
        }
    }

    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'events_id' => 'required|integer',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $event = Event::find($request->get('events_id'));
            $user = User::find($request->get('user_id'));

            $user->event()->detach($event);
            $event->total_interested = $event->subscribers->count('user_id');
            $event->save();

            return response()->json(['msg' => 'Anulação da inscrição realizada com sucesso.', ]);
        }
    }

    public function isSubscribed(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $user = User::find($request->get('user_id'));
            $events = Event::all();

            $arrayOfEventsId = [];

            foreach ($events as $event) {
                if ($user->event->contains($event)) {
                    if(!in_array($event->id, $arrayOfEventsId)){
                        $arrayOfEventsId[]=$event->id;
                    }
                }
            }

            return $arrayOfEventsId;
        }
    }

    public function getUsersSubscribed($id)
    {
        $event = Event::findOrFail($id);
        $users = $event->subscribers;
        return SmallerUserResource::collection($users);
    }

}
