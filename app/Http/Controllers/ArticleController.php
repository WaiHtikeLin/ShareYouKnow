<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;
use App\Notification;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->middleware('auth');
        $this->authorizeResource(Post::class, 'article');
    }

    public function index($category=null)
    {
        
        if($category)
        {
            if($category=='myarticles') 
             
                $posts=Post::where('user_id',auth()->id())->with('owner:id,name')->orderBy('created_at','desc')->get();
         
            else

                if($category=='saves')
                
                    $posts=auth()->user()->saves()->with('owner:id,name')->orderBy('created_at','desc')->get();
                
                else

                $posts=Post::where([['category',$category],['user_id','<>',auth()->id()],])->with('owner:id,name')->orderBy('created_at','desc')->get();

        } 
        else

            $posts=Post::where('user_id','<>',auth()->id())->with('owner:id,name')->orderBy('created_at','desc')->get();
        
        return view('latest',['posts'=>$posts]);
    }

    protected function validatearticle(Request $request)
    {
        return $request->validate([
            'title' => 'required|string',
            'description' => 'required|string'
        ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('articleform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validatearticle($request);

        $article=new Post;
        $article->user_id=auth()->id();
        $article->category=request('category');
        $article->title=request('title');
        $article->description=request('description');
        $article->save();

        return redirect('/articles/myarticles');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $article)
    {   
        return view('latest',['posts'=>[$article]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $article)
    {
        return view('posteditform',['post'=>$article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $article, Request $request)
    {
        $this->validatearticle($request);

        $article->category=request('category');
        $article->title=request('title');
        $article->description=request('description');

        $article->save();
        return redirect('/articles/myarticles');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $article)
    {
        $id=$article->id;
        $article->delete();
        $article->likes()->delete();
        Notification::where('data','like','%{"name":"post","id":'.$id.'}%')->delete();
        return redirect('/articles/myarticles');

    }

    public function like(Post $article)
    {
        return ['stat'=>$article->like()];
    }

    public function unlike(Post $article)
    {
        return ['stat'=>$article->unlike()];
    }

    public function save(Post $article)
    {
    $this->authorize('save',$article);    
    
    return ['stat'=>$article->savepost()];
    }

    public function unsave(Post $article)
    {   $this->authorize('save',$article);
        return ['stat'=>$article->unsave()];
    }

    public function showComments(Post $article)
    {   
        $stat=$article->getStats();
        $comments=$article->getComments();
       //return response()->json(['comments'=>$comments[0]->words]);
        
        $html=view("comment",['post'=>$article])->with('comments',$comments)->render();
        //$html=$comment->words;    
        return ['stat'=>$stat,'comments'=>$html];
    }

    public function validatecomment(Request $request)
    {
        return $request->validate([
            'words' => 'required'
        ]
        );
    }

    public function saveComment(Post $article, Request $request)
    {
        $this->validatecomment($request);

        $comment=new Comment;
        $comment->user_id=auth()->id();

        $comment->words=request('words');

        $article->comments()->save($comment);

        $article->notifyWithMsg('commented on');

        
        $stat=$article->getStats();
        $comments=$article->getComments();
        $html=view("comment",['post'=>$article])->with('comments',$comments)->render();

        return ['stat'=>$stat,'comments'=>$html];


    }

    public function displayStats(Post $article)
    {
        $likes=$article->likes()->with('liker')->get();
        $saves=$article->savers;

        $html=view('poststats',['likes'=>$likes,'saves'=>$saves,'id'=>$article->id])->render();

        return [$html];

    }

    public function search($q)
    {   
        // $posts=Post::where('user_id','<>',auth()->id())
        // ->where(function ($query,$q) {
        //         $query->where('title', 'like', "%".$q."%")
        //               ->orWhere('description', 'like', "%".$q."%");
        //     })->with('owner:id,name')->orderBy('created_at','desc')->get();

        $posts=Post::where([['title', 'like', "%".$q."%"],['user_id','<>',auth()->id()]])->orWhere([['description', 'like', "%".$q."%"],['user_id','<>',auth()->id()]])->with('owner:id,name')->orderBy('created_at','desc')->get();



        return view('latest',['posts'=>$posts]);

    }

    public function updateRating(Post $article)
    {
        
        $this->authorize('rate',$article);

        $type=request('type');
        $value;
        switch ($type) {
            case 'Bad':
                $value=1;
                break;
            case 'Poor':
                $value=2;
                break;
             case 'Nice':
                $value=3;
                break;
             case 'Good':
                $value=4;
                break;
             case 'Great':
                $value=5;
                break;
            
            default:
                # code...
                break;
        }
        if($article->raters()->where('id',auth()->id())->exists())
        $article->raters()->updateExistingPivot(auth()->id(),["rate_type"=>$type,"rate_value"=>$value]);

        else

          {  $article->raters()->attach(auth()->id(),["rate_type"=>$type,"rate_value"=>$value]);
            $article->notifyWithMsg("rated '$type' on");

}
        $avg=$article->getAvgRating();

        return $avg;
    }

    public function deleteRating(Post $article)
    {
        $this->authorize('rate',$article);
        
        $article->raters()->detach(auth()->id());

        $avg=$article->getAvgRating();

        return $avg;
    }




}
