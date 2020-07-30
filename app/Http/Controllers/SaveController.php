<?php

namespace App\Http\Controllers;

use App\Save;
use App\Post;
use Illuminate\Http\Request;

class SaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
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
        $id=request('id');
        $saver=new Save;
        $saver->user_id=auth()->id();
        //$liker->likeable_id=$id;
        //$liker->likeable_type=$type;

        $obj=Post::find($id);
        $obj->saves()->save($saver);

        //$liker->save();

        
        return ['stat'=>$obj->getSaveStats()];

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function show(Save $save)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function edit(Save $save)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Save $save)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Save  $save
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $id=request('id');

        $obj=Post::find($id);
        $obj->saves()->where('user_id',auth()->id())->delete();
        // Like::where([['user_id',auth()->id()],['likeable_id',$id],['likeable_type',$type]])->delete();

        // return response()->json($this->getCounts($id,$type));

        return ['stat'=>$obj->getSaveStats()];
    }
}
