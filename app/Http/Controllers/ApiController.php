<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Code;
class ApiController extends Controller
{
    public function type(Request $request)
    {
        if($request->type != 'other')
        {
            return Code::where('type', $request->type)->pluck('model', 'model');
        }
        else
        {
            return Code::where('type', null)->pluck('model', 'model');
        }
    }
}
