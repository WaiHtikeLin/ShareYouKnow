<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Notification;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Reply::class, 'reply');
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        $reply->words=request('words');
        $reply->save();
        return $this->updateCommentRepliesData($reply);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        $id=$reply->id;
        $reply->delete();
        $reply->likes()->delete();
        Notification::where('data','like','%{"name":"reply","id":'.$id.'}%')->delete();
        return $this->updateCommentRepliesData($reply);

    }

    public function updateCommentRepliesData($reply)
    {   
        $comment=$reply->comment;
        $stat=$comment->getStats();
        $replies=$comment->getReplies();
        $html=view("reply",['post'=>$comment->post,'id'=>$comment->id])->with('replies',$replies)->render();

        return ['stat'=>$stat,'replies'=>$html];
    }

    public function displayStats(Reply $reply)
    {
        $likes=$reply->likes()->with('liker')->get();

        $html=view('commentstats',['likes'=>$likes,'id'=>$reply->id])->render();

        return [$html];

    }
}
