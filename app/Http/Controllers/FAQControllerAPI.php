<?php

namespace App\Http\Controllers;

use App\FAQ;
use App\UserQuestion;
use Illuminate\Http\Request;
use App\Http\Resources\FAQResource;
use Illuminate\Support\Facades\DB;
use Validator;

class FAQControllerAPI extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $faqs = FAQ::all();

            return FAQResource::collection($faqs);
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

    public function cleanStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $faq = new FAQ;
            $faq->question = $request->get('question');
            $faq->answer = $request->get('answer');
            $faq->save();

            return response()->json(['msg' => 'FAQ criada com sucesso', 'error' => false]);
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
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['msg' => $validator->errors()]);
        } else {
            $faq = new FAQ;
            $faq->question = $request->get('question');
            $faq->answer = $request->get('answer');
            $faq->save();

            $userQuestion = UserQuestion::findOrFail($request->get('id'));
            $userQuestion->isFAQ = 1;
            $userQuestion->update();

            return response()->json(['msg' => 'FAQ criada com sucesso', 'error' => false]);
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
        $usefulLink = FAQ::findOrFail($id);
        return $usefulLink;
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
            'question' => 'required|string',
            'answer' => 'required|string',
        ]);

        if ($request->wantsJson() && !$validator->fails()) {

            $faq = FAQ::findOrFail($id);

            $faq->question = $request->get('question');
            $faq->answer = $request->get('answer');

            $faq->update();

            return response()->json(['msg' => 'FAQ editada com sucesso.']);
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
        $faq = FAQ::findOrFail($id);

        $faq->delete();

        return response()->json(['msg' => 'FAQ apagada com sucesso.']);
    }
}
