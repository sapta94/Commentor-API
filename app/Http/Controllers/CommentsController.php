<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use App\Comment;
use App\Http\Resources\Comment as CommentResource;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments =  DB::select('select cm.*,um.firstname,um.Lastname from comments cm inner join users um on cm.userID=um.id');
        if($comments)
            return response()->json(['response' => 'success','data'=>$comments]);
        else
            return response()->json(['response' => 'fail']);

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
        $article =  new Comment;

        $article->content = $request->input('content');
        $article->userID = $request->input('userID');

        if($article->save()) {
            return new CommentResource($article);
        }
    }

    public function update(Request $request)
    {
        $type=$request->input('type');
        $commentID=$request->input('commentID');
        $userID=$request->input('userID');

        if($type=='upvote'){
            $query="update comments set upvotes=upvotes+1 where commentID=?";
        }
        else{
            $query="update comments set downvotes=downvotes+1 where commentID=?";
        }
        $comments =  DB::update($query,[$commentID]);

        if($comments){
            $vote = 
            DB::insert('insert into votes (commentID, userID, type) values (?, ?, ?)', [$commentID,$userID ,$type]);
            if($vote){
                return response()->json(['response' => 'success','data'=>$comments]);
            }
            else{
                return response()->json(['response' => 'fail']);
            }
        }
            
        else
            return response()->json(['response' => 'fail from update','data'=>$comments]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $comments =  DB::select('select cm.*,um.firstname,um.Lastname from comments cm inner join users um on cm.userID=um.id where cm.userID = ?', [$id]);
        if($comments)
            return response()->json(['response' => 'success','data'=>$comments]);
        else
            return response()->json(['response' => 'fail']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get comment
        $article = 
        DB::delete('delete from comments where commentID = ?', [$id]);
        
        

        if($article) {
            return  response()->json(['response' => 'success','data'=>$article]);
        }    
    }
}
