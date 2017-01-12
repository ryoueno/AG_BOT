<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Http\Requests\CallStoreRequest;


class CallController extends Controller
{
    public function store(CallStoreRequest $request)
    {
        $input = $request->only(['line_id', 'name']);
        return Call::create($input);
    }
}
