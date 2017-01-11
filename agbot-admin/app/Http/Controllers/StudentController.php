<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Requests\StudentStoreRequest;
use App\Http\Requests\StudentStatusRequest;

class StudentController extends Controller
{
    public function store(StudentStoreRequest $request)
    {
        $input = $request->only(['id', 'line_id', 'name', 'img', 'status']);
        return Student::create($input);
    }

    public function set(StudentStatusRequest $request)
    {
        $input = $request->only(['line_id', 'status']);
        $student = Student::where('line_id', $input['line_id'])->first();
        if ($student) {
            $student->status = $input['status'];
            $student->save();
            return "OK";
        } else {
            return "登録されていません";
        }
    }

    public function getStatus($line_id)
    {
        $student = Student::where('line_id', $line_id)->first();
        if ($student) {
            return $student->status;
        } else {
            return [];
        }
    }
}
