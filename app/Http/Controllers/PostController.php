<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::latest()
            ->with('author', 'tags')
            ->filter(request(['year', 'month', 'tag']))
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::orderBy('name')->get();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|min:5|max:255',
            'body' => 'required|min:10',
            'tags' => 'required',
        ]);

        if ( isset($validatedData['tags'] ) ) {
            foreach ($validatedData['tags'] as $key => $value) {
                $validatedData['tags'][$key] = is_numeric($value)
                    ? Tag::findOrFail($value)->id
                    : Tag::firstOrCreate(['name' => $value])->id;
            }
        }

        $post = Post::make($validatedData);
        $post->author()->associate( auth()->user() );
        $post->save();
        $post->tags()->attach( isset($validatedData['tags']) ? $validatedData['tags'] : [] );

        return redirect()->route( 'posts.show', $post );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize( 'update', $post );

        $tags = Tag::orderBy('name')->get();
        
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize( 'update', $post );

        $validatedData = $request->validate([
            'title' => 'required|min:5|max:255',
            'body' => 'required|min:10',
            'tags' => 'array',
        ]);

        if ( isset($validatedData['tags']) ) {
            foreach ($validatedData['tags'] as $key => $value) {
                $validatedData['tags'][$key] = is_numeric($value)
                    ? Tag::findOrFail($value)->id
                    : Tag::firstOrCreate(['name' => $value])->id;
            }
        }

        $post->update($validatedData);
        $post->save();
        $post->tags()->sync( isset($validatedData['tags']) ? $validatedData['tags'] : [] );

        return redirect()->route( 'posts.show', $post );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize( 'update', $post );

        $post->delete();

        return redirect()->route('posts.index');
    }
}
