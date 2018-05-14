<?php

namespace App\Http\Controllers;

use App\NewsletterSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class NewsletterControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
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
}
