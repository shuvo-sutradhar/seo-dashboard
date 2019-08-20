<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Tag;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tag::latest()->paginate(15);
        return view('tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'tagName'=>'required|unique:tags,name|max:255',
        ]);

        $tag = Tag::create([

            'name' => $request->tagName,
            'note' => $request->tagNote,

        ]);


        activity()->performedOn($tag)->causedBy(auth()->user())->withProperties(['customProperty' => 'customValue'])->log($tag->name .' created', 'A new tag was created');
   
        return redirect()->route('tag.index')->with('success', 'Tag added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('tag.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        
        $tag = Tag::where('slug', $slug)->firstOrFail();
        return view('tags.edit', compact('tag'));

        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $request->validate([
            'tagName'=>'required|max:255|unique:tags,name,'.$tag->id,
        ]);

        
        $tagUpdate = $tag->update([
            'name' => $request->tagName,
            'note' => $request->tagNote,
        ]);

        activity()->performedOn($tag)->causedBy(auth()->user())->log('edited', 'Tag edited successfully');

        return redirect()->route('tag.index')->with('success', 'Tag updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $tag->delete();
    }
}
