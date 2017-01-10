<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Http\Requests\AttendanceStoreRequest;

class AttendanceController extends Controller
{

    public function store(AttendanceStoreRequest $request)
    {
        $input = $request->only(['lecture_id', 'student_id']);
        $input['is_active'] = true;
        return Attendance::create($input);
    }
}
