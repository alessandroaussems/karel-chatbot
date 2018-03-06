<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Sentence;
use Collective\Html\HtmlFacade;
use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SentenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($messageid)
    {
        return view("sentenceadd")->with("messageid",$messageid);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'sentence' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('sentences/create/' . Input::get("messageid"))
                ->withErrors($validator)
                ->withInput();
        } else {
            $sentence = new Sentence();
            $sentence->sentence = Input::get('sentence');
            $sentence->message_id = Input::get("messageid");
            $sentence->save();
            return Redirect::to('messages/'.Input::get("messageid"));
        }
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
}
