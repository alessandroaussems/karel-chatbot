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
        $this->middleware('role:editor,admin');
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
        return view("messageadd");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //CLEANING VALUE OF WYSIWYG OF SPACES FOR CHECKING
        $cleananswer=preg_replace('/[\s]+/','',str_replace("&nbsp;","",strip_tags(Input::get("answer"))));
        if(!isset($cleananswer) || $cleananswer == '')
        {
            return Redirect::to('messages/create')
                ->withErrors("Het antwoord veld is verplicht!")
                ->withInput();
        }
        else
        {
            $message = new Message();
            $message->answer = Input::get('answer');
            $message->save();
            return Redirect::to('messages/');
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
        $message = Message::where("id",$id)->first();
        $answers= Sentence::where("message_id",$id)->get();
        if(isset($message))
        {
            return view("messagedetail")->with('message',$message)->with("answers",$answers);
        }
        else
        {
            abort(404);
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
        $message = Message::where("id",$id)->first();
        if(isset($message))
        {
            return view("messageedit")->with('message', $message);
        }
        else
        {
            abort(404);
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
        //CLEANING VALUE OF WYSIWYG OF SPACES FOR CHECKING
        $cleananswer=preg_replace('/[\s]+/','',str_replace("&nbsp;","",strip_tags(Input::get("answer"))));
        if(!isset($cleananswer) || $cleananswer == '')
        {
            return Redirect::to('messages/'.$id.'/edit')
                ->withErrors("Het antwoord veld is verplicht!")
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
        Message::where("id",$id)->delete();
        Sentence::where("message_id",$id)->delete();
        return Redirect::to('messages');
    }
}
