<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use App\Keyword;
use Collective\Html\HtmlFacade;
use Collective\Html\FormFacade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    /**
     * MessageController constructor.
     */
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
    public function index(Request $request)
    {
        $error="";
        if($request->get("search"))
        {
            $search=$request->get("search");
            $messages=Message::where('answer', 'LIKE', '%'.$search.'%')->paginate(9);
            if(count($messages)==0)
            {
                $error="Er zijn geen zoekresultaten gevonden...<br><a href='./messages'>Terug naar overzicht</a>";
            }
        }
        else
        {
            $messages = Message::paginate(9);
            $search="";
        }
        return view("messages")->with('messages',$messages)->with("search",$search)->with("error",$error)->with("pagetitle", "Berichten");
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("messageadd")->with("pagetitle", "Bericht toevoegen");
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
            return Redirect::to('messages/'.$message->id);
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
        $message  = Message::where("id",$id)->first();
        $keywords = Keyword::where("message_id",$id)->get();
        if(isset($message))
        {
            return view("messagedetail")->with('message',$message)->with("keywords",$keywords)->with("pagetitle", "Bericht detail");
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
            return view("messageedit")->with('message', $message)->with("pagetitle", "Bericht bewerken");
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
        Keyword::where("message_id",$id)->delete();
        return Redirect::to('messages');
    }
}
