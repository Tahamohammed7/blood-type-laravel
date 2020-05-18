<?php

namespace App\Http\Controllers;

use App\Category;
use App\Governorate;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{


    function __construct()
    {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index','show']]);
        $this->middleware('permission:post-create', ['only' => ['create','store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create')->with('categories',Category::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $rules = [
           'title'   => 'required',
           'content' => 'required',
           'image'   => 'required'
       ];
        $message = [
            'title.required'   => 'Title is required',
            'content.required' => 'Content is required',
            'image.required'   => 'Image is required'
        ];
        $this->validate($request,$rules,$message);

        $posts = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image->store('images', 'public'),
            'category_id' => $request->category_id
        ]);
        flash()->success('success');
        return redirect(route('posts.index'));

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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       $post = Post::findOrfail($id);
       return view('admin.posts.edit',['categories' => Category::all()],compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Post $post)
    {

        $data = $request->only(['title','content','category_id']);

        if ($request->image) {
            $image = $request->image->store('images','public');
            Storage::disk('public')->delete($post->image);
            $data['image'] = $image;
        }
        $post->update($data);

        flash()->success('Updated');
        return redirect(route('posts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrfail($id);
        $post->delete();

        flash()->success('Deleted');
        return redirect(route('posts.index'));
    }
}
