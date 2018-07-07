<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\User;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get users
        $users = User::paginate(15);

        // Return collection of users as a resource
        return UserResource::collection($users);
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
        $email = $request->input('email');
        $password = $request->input('password');

        $users =  DB::select('select * from users where email = ?', [$email]);

        $isPresent=0;
        $userID=null;
        foreach ($users as $user) {
            if(Hash::check($password,$user->password)){
                $isPresent=1;
                $userID=$user->id;
            }
        }

        if($isPresent==1){
            session(['user'=>$users]);
            return response()->json(['response' => 'success','data'=>$users,'sessionID'=>session('user')]);
        }
        else{
            return response()->json(['response' => 'fail']);
        }
        
    }

    public function register(Request $request)
    {
        $article =  new User;

        $article->firstname = $request->input('firstname');
        $article->middlename = $request->input('middlename');
        $article->lastname = $request->input('lastname');
        $article->email = $request->input('email');
        $article->password = bcrypt($request->input('password'));

        echo $article;
        if($article->save()) {
            return new UserResource($article);
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
        //
    }

    public function fetch(){
        return  response()->json(['response' => session('user')]);
    }

    public function logout(){
        session()->flush();

        if(session()->has('users')){
            return  response()->json(['message' => 'failed']);
        }
        else{
            return  response()->json(['message' => 'success']);
        }
    }

}
