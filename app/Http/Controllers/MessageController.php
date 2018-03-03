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

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::all();
        return view("messages")->with('messages',$messages);
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
        $message = Message::where("id",$id)->first();
        $answers= Sentence::where("message_id",$id)->get();
        return view("messagedetail")->with('message',$message)->with("answers",$answers);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = Message::where("id",$id)->first();
        return view("messageedit")->with('message', $message);
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
        $rules = array(
            'answer'      => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('messages/'.$id."/edit")
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $message = Message::find($id);
            $message->answer = Input::get('answer');
            $message->save();
            return Redirect::to('messages/'.$id);
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
        $message = Message::find($id);
        $message->delete();
        $sentences=Sentence::where("message_id",$id)->get();
        foreach ($sentences as $sentence)
        {
            $sentence->delete();
        }
        return Redirect::to('messages');
    }
}
