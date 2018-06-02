<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=User::paginate(5);
        return view("users")->with("users",$users);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where("id",$id)->first();
        if(isset($user))
        {
            return view("useredit")->with('user', $user);
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
        $validator = Validator::make($request->all(),[
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'role'  => 'required|max:255'
        ]);
        if($validator->fails())
        {
            return Redirect::to('users/'.$id.'/edit')
                ->withErrors($validator)
                ->withInput();
        }
        else
        {
            $user = User::find($id);
            $user->name=Input::get('name');
            $user->email=Input::get('email');
            $user->role=Input::get('role');
            $user->save();
            return Redirect::to('users/');
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
        User::where("id",$id)->delete();
        return Redirect::to('/users');
    }
}
