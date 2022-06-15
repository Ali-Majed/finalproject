<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use App\Models\User;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tweets = Tweet::all();
        $tweets=$tweets->map(function ($tweet){

            return[

                'Tweet' => $tweet->content,
                'date' => $tweet->created_at
            ];

        });
        return response()->json($tweets);

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
        $tweet=Tweet::create([
            'content'=>$request->input('content'),
            'user_id'=> app('auth')->user()->id
        ]);
        return response()->json([
            'message' => 'Successfully created tweet!',
            ['tweet'=>$tweet]
        ], 201);
//        return response()->json(['tweet'=>$tweet]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tweet_data = Tweet::with('likes')
            ->withCount('likes')
                ->find($id);
        $tweets = $tweet_data->likes;

        $tweets= $tweets->map(function ($tweet) use ($tweet_data){

            return[
                'tweet'=>$tweet_data,
                'user'=>$tweet->name
            ];
        });

        return response()->json(['data'=>$tweets]);

//        $tweet = Tweet::with('likes')
//            ->withCount('likes')
//            ->find($id);
//        return response()->json(['tweet'=>$tweet]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function edit(Tweet $tweet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tweet = Tweet::where('id',$id)
            ->first();
        if (isset($tweet)) {
            Tweet::where('id','=',$tweet->id)
                ->update([
                    'content'=>$request->get('content'),
                ]);

        if (!$tweet) {
            return response()->json([
                'success' => false,
                'message' => 'Tweet Not Found.'
            ], 404);
        }

        $tweet->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Tweet Updated Successfully.',
            'tweet'=>$tweet]);}

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tweet  $tweet
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tweet = Tweet::find($id);

        if (!$tweet) {
            return response()->json([
                'success' => false,
                'message' => 'Tweet Not Found.'
            ], 404);
        }

        $tweet->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tweet Deleted Successfully.'
        ], 200);
    }
}
