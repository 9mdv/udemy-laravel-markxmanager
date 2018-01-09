<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;


class BookmarksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $bookmarks = Bookmark::where('user_id', auth()->user()->id)->get();
        return view('home', compact('bookmarks'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'url' => 'required'
        ]);

        //Create bookmark
        $bookmark = new Bookmark;
        $bookmark->name = $request->name;
        $bookmark->url = $request->url;
        $bookmark->description = $request->description;
        $bookmark->user_id = auth()->user()->id;
        $bookmark->save();

        return redirect('/home')->with('success', 'Bookmark Added');
    }

    public function destroy($id)
    {
        $bookmark = Bookmark::find($id);
        $bookmark->delete();

        return;
    }
}
