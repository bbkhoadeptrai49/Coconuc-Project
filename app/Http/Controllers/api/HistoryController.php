<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Histories;

class HistoryController extends Controller
{
    public function getHistory($userid){
    	$history = Histories::where('histories_user_id_foreign', $userid)->get();
    	return response()->json($history);
    }
    
}
