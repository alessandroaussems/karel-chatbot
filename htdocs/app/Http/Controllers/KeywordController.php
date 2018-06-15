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

class KeywordController extends Controller
{
    /**
     * KeywordController constructor.
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
        return view("keywordadd")->with("messageid",$messageid)->with("pagetitle", "Sleutelwoord toevoegen");
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
            'keyword' => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return Redirect::to('keywords/create/' . Input::get("messageid"))
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            if($this->checkIfSimilarKeyword(Input::get('keyword')))
            {
                return Redirect::to('keywords/create/' . Input::get("messageid"))
                    ->withErrors("Er is al een ander sleutelwoord dat te hard op het door jou ingegeven lijkt! Dit kan voor conflicten zorgen.")
                    ->withInput();
            }
            $keyword = new Keyword();
            $keyword->keyword = Input::get('keyword');
            $keyword->message_id = Input::get("messageid");
            $keyword->save();
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
        $keyword = Keyword::where("id",$id)->first();
        return view("keywordedit")->with('messageid', $messageid)->with("keyword",$keyword)->with("pagetitle", "Sleutelwoord bewerken");
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
            'keyword'      => 'required',
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails())
        {
            return Redirect::to('keywords/edit/'.$id.'/message/'.Input::get("messageid"))
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            if($this->checkIfSimilarKeyword(Input::get('keyword')))
            {
                return Redirect::to('keyword/create/' . Input::get("messageid"))
                    ->withErrors("Er is al een ander sleutelwoord dat te hard op het door jou ingegeven lijkt! Dit kan voor conflicten zorgen.")
                    ->withInput();
            }
            $keyword = Keyword::find($id);
            $keyword->keyword = Input::get('keyword');
            $keyword->message_id=Input::get("messageid");
            $keyword->save();
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
        Keyword::where("id",$id)->delete();
        return Redirect::to('/messages/'.$messageid);
    }
    //HELPER FUNCTIONS BELOW
    /**
     * @param $keywordtocheck
     * @return bool indicating if result similar to param is found.
     */
    private function checkIfSimilarKeyword($keywordtocheck)
    {
        $keywords=Keyword::all();
        foreach ($keywords as $keyword => $value)
        {
            similar_text($keyword,$value->keyword,$percent);
            if($percent>70)
            {
                return true;
            }
        }
        return false;
    }
}
