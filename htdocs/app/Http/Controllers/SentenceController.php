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
    /**
     * SentenceController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:editor,admin');
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
        }
        else
        {
            if($this->checkIfSimilarSentence(Input::get('sentence')))
            {
                return Redirect::to('sentences/create/' . Input::get("messageid"))
                    ->withErrors("Er is al een andere zin die te hard op deze zin lijkt! Dit kan voor conflicten zorgen.")
                    ->withInput();
            }
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
    public function edit($id,$messageid)
    {
        $sentence = Sentence::where("id",$id)->first();
        return view("sentenceedit")->with('messageid', $messageid)->with("sentence",$sentence);
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
            'sentence'      => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('sentences/edit/'.$id.'/message/'.Input::get("messageid"))
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            if($this->checkIfSimilarSentence(Input::get('sentence')))
            {
                return Redirect::to('sentences/create/' . Input::get("messageid"))
                    ->withErrors("Er is al een andere zin die te hard op deze zin lijkt! Dit kan voor conflicten zorgen.")
                    ->withInput();
            }
            $sentence = Sentence::find($id);
            $sentence->sentence = Input::get('sentence');
            $sentence->message_id=Input::get("messageid");
            $sentence->save();
            return Redirect::to('messages/'.Input::get("messageid"));
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$messageid)
    {
        Sentence::where("id",$id)->delete();
        return Redirect::to('/messages/'.$messageid);
    }
    //HELPER FUNCTIONS BELOW
    /**
     * @param $sentencetocheck
     * @return bool indicating if result similar to param is found.
     */
    private function checkIfSimilarSentence($sentencetocheck)
    {
        $sentences=Sentence::all();
        foreach ($sentences as $sentence => $value)
        {
            similar_text($sentencetocheck,$value->sentence,$percent);
            if($percent>70)
            {
                return true;
            }
        }
        return false;
    }
}
