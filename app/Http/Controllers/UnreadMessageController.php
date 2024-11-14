<?php

namespace App\Http\Controllers;
use App\Models\ChMessage;
use Illuminate\Http\Request;

class UnreadMessageController extends Controller
{
    //

    public function getUnreadMessageCount(Request $request)
    {

        return ChMessage::where('id', auth()->id())
                      ->whereNull('created_at')
                      ->count();
    }
}
