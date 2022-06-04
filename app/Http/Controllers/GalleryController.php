<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Models\Gallery;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $title = $request->query('title');
        $galleries = Gallery::search($title)->with('user','images','comments')->orderBy('created_at','desc')->paginate(10);
        return response()->json($galleries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateGalleryRequest $request)
    {
        $data = $request->validated();
        $gallery = new Gallery();
        $gallery->title=$data['title'];
        $gallery->description=$data['description'];
        $gallery->user()->associate(Auth::user());
        $gallery->save();

        $images = $data['images'];
        foreach($images as $image){
           Image::create([
            'image_url'=>$image,
            'gallery_id'=>$gallery->id
           ]);
        }
        return response()->json($gallery);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        $gallery->load(['images','comments.user','user.galleries']);
        return response()->json($gallery);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();
        $gallery->update($data);
        return response()->json([
            'gallery'=>$gallery,
            'message'=>'The gallery has been updated successfully!'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return response()->json([
            'message'=>'The gallery has been deleted successfully!'
        ],200);
    }
    public function getMyGalleries($user_id){
        $myGalleries = Gallery::with('images','comments')->where('user_id',$user_id)->orderBy('created_at','desc')->paginate(10);
        return response()->json($myGalleries);
    }
}
