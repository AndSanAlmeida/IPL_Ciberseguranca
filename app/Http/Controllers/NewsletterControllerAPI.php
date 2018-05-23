<?php

namespace App\Http\Controllers;

use App\User;
use App\Newsletter;
use App\NewsletterSubscription;
use App\Http\Resources\NewsletterResource;
use App\Notifications\newNewsletter;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;

use Notification;
use Validator;
use Swift_Mailer;

class NewsletterControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $documents = Newsletter::all();

            return NewsletterResource::collection($documents);
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
            'file' => 'required',
            'date' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $newsletter = new Newsletter;
            $newsletter->description = $request->get('description');
            $newsletter->path = $request->get('file');
            $newsletter->date = $request->get('date');
            $newsletter->save();
            return response()->json(['msg' => 'Newsletter criada com sucesso', 'error' => false]);
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
        $newsletter = Newsletter::findOrFail($id);
        return $newsletter;
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
            'description' => 'required|string|max:200',
            'path' => 'required',
            'date' => 'required',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $newsletter = Newsletter::findOrFail($id);

            $newsletter->description = $request->get('description');
            $newsletter->path = $request->get('path');
            $newsletter->date = $request->get('date');
            $newsletter->update();

            return response()->json(['msg' => 'Newsletter editada com sucesso.']);
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
        $newsletter = Newsletter::findOrFail($id);

        $newsletter->delete();

        return response()->json(['msg' => 'Newsletter apagada com sucesso.']);
    }

    // subscribe to newsletter
    public function subscribe(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $subscribe = new NewsletterSubscription;
            $subscribe->name = $request->get('name');
            $subscribe->email = $request->get('email');

            $subscribe->save();
            return response()->json(['msg' => 'Subscrição à newsletter realizada com sucesso', 'error' => false]);
        }
    }

    // unsubscribe to newsletter
    public function unsubscribe($email) {

    }

    // check if user is logged
    public function subscribed(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $subscription = NewsletterSubscription::where('email', '=', $request->get('email'))->first();
            if ($subscription === null) {
                return response()->json(['isSubscribed' => false]);;
            }
            return response()->json(['isSubscribed' => true]);;
        }
    }

    public function publish($id) {
        try {
            $newsletter = Newsletter::findOrFail($id);
            $newsletter->isPublished = 1;

            $subscriptions = NewsletterSubscription::all();

            $config = DB::table('config')->first();
            $mailConfigs = json_decode($config->platform_email_properties);
            config([
                'mail.host' => $mailConfigs->host,
                'mail.port' => $mailConfigs->port,
                'mail.encryption' => $mailConfigs->encryption,
                'mail.username' => $config->platform_email,
                'mail.password' => $mailConfigs->password
            ]);

            $app = App::getInstance();
            $app->singleton('swift.transport', function ($app) {
                return new TransportManager($app);
            });
            $mailer = new Swift_Mailer($app['swift.transport']->driver());
            Mail::setSwiftMailer($mailer);

            foreach ($subscriptions as $subscription) {
                Notification::route('mail', $subscription->email)->notify(new newNewsletter($newsletter));
            } 

            $newsletter->update();  

            return response()->json(['msg' => 'Newsletter publica e enviada para os subscritores'], 200);

        } catch (\Exception $e) {
            return response()->json(['errorCode' => -1, 'msg' => 'Problema a enviar o email. Tente mais tarde novamente.', 'exc' => $e->getMessage()], 400);
        }
    }
}
