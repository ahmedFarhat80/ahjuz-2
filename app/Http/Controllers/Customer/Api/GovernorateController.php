<?php

namespace App\Http\Controllers\Customer\Api;

use App\Models\Governorate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GovernorateController extends Controller
{
    public function index()
    {
        return Governorate::all();
    }
    
    public function regions(Governorate $governorate)
    {
        return response()->json($governorate->regions, 200); 
    }
}
