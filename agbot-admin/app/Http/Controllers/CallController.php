<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Call;
use App\Models\Student;
use App\Http\Requests\CallStoreRequest;


class CallController extends Controller
{
    public function store(CallStoreRequest $request)
    {
        $r = $request->only(['line_id', 'name']);
        $input['student_id'] = Student::where('line_id', $line_id)->first()->id;
        $input['name'] = $r['name'];
        return Call::create($input);
    }
}
