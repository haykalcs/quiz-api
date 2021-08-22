<?php

namespace App\Http\Controllers;

use App\Models\Feed;
use App\Models\FeedReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedController extends Controller
{
    public function feedIndex()
    {
        $data = Feed::with(['user:id,name,email', 'replies.user' => function($q) {
            $q->select('id', 'name', 'email');
        }])->get();

        return $this->responseSuccess('Data', ($data ?? null));
    }

    public function feedStore(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->responseFailed('Validasi error', $validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
            $input['image'] = time().'.'.request()->image->getClientOriginalExtension();
            
            \Image::make(request()->image)->save(public_path('assets/images/feed/').$input['image']);
        }
        
        $data = Feed::create([
            'user_id' => auth()->user()->id,
            'message' => $input['message'],
            'image' => $input['image'] ?? null
        ]);

        return $this->responseSuccess('Data berhasil dibuat', $data, 201);
    }

    public function replyStore(Request $request, $feedId)
    {
        $feed = Feed::find($feedId);
        if(!$feed) return $this->responseFailed('Data feed tidak ditemukan', '', 404);

        $input = $request->all();
        $validator = Validator::make($input, [
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($validator->fails()) {
            return $this->responseFailed('Validasi error', $validator->errors(), 400);
        }

        if ($request->hasFile('image')) {
            $input['image'] = time().'.'.request()->image->getClientOriginalExtension();
            
            \Image::make(request()->image)->save(public_path('assets/images/feed/').$input['image']);
        }
        
        $data = FeedReply::create([
            'user_id' => auth()->user()->id,
            'feed_id' => +$feedId,
            'message' => $input['message'],
            'image' => $input['image'] ?? null
        ]);

        return $this->responseSuccess('Data berhasil dibuat', $data, 201);
    }
}