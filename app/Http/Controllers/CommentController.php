<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Reply;
use App\Notification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Comment::class, 'comment');
    }

    public function index()
    {
        //
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
    public function store()
    {  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $html=view('form')->with('comment',$comment)->render();

        return [$html];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function validatecomment(Request $request)
    {
        return $request->validate([
            'words' => 'required'
        ]
        );
    }

    public function update(Comment $comment,Request $request)
    {
        $this->validatecomment($request);

        $comment->words=request('words');
        $comment->save();
        return $this->updatePostCommentsData($comment);
    }

    public function updatePostCommentsData($comment)
    {
        $stat=$comment->post->getStats();
        $comments=$comment->post->getComments();
        $html=view("comment",['post'=>$comment->post,'id'=>$comment->post_id])->with('comments',$comments)->render();

        return ['stat'=>$stat,'comments'=>$html];
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {   
        $id=$comment->id;

        $comment->delete();
        $comment->likes()->delete();
        
        Notification::where('data','like','%{"name":"comment","id":'.$id.'}%')->delete();
        return $this->updatePostCommentsData($comment);

    }

    public function like(Comment $comment)
    {
        return ['stat'=>$comment->like()];
    }

    public function unlike(Comment $comment)
    {
        
        return ['stat'=>$comment->unlike()];
    }

    public function likeReply(Reply $reply)
    {
        return ['stat'=>$reply->like()];
    }

    public function unlikeReply(Reply $reply)
    {
        
        return ['stat'=>$reply->unlike()];
    }


    public function showReplies(Comment $comment)
    {   
        $stat=$comment->getStats();
        $replies=$comment->getReplies();
        $post=$comment->post;
       //return response()->json(['comments'=>$comments[0]->words]);
        
        $html=view("reply",['post'=>$post,'id'=>$comment->id])->with('replies',$replies)->render();
        //$html=$comment->words;    
        return ['stat'=>$stat,'replies'=>$html];
    }

    public function saveReply(Comment $comment)
    {
        $reply=new Reply;
        $reply->user_id=auth()->id();
        $reply->words=request('words');

        $comment->replies()->save($reply);

        $comment->notifyWithMsg("replied to");
        
        $stat=$comment->getStats();
        $replies=$comment->getReplies();

        $post=$comment->post;
        $html=view("reply",['post'=>$post,'id'=>$comment->id])->with('replies',$replies)->render();

        return ['stat'=>$stat,'replies'=>$html];


    }

    public function displayStats(Comment $comment)
    {
        $likes=$comment->likes()->with('liker')->get();

        $html=view('commentstats',['likes'=>$likes])->render();

        return [$html];

    }
}
