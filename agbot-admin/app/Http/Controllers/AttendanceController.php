<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Lecture;
use App\Models\Beacon;
use App\Http\Requests\AttendanceStoreRequest;

class AttendanceController extends Controller
{

    public function store(AttendanceStoreRequest $request)
    {
        //beacon_idから教室ID->講義IDを取得
        //$input = $request->only(['beacon_id', 'student_id']);
        $input = $request->only(['student_id']);
        $input['beacon_id'] = '00000000-48A4-1001-B000-001C4D175E4E';
        $beacon = Beacon::find($input['beacon_id']);
        if (!$beacon) return 'beacon_idが有効ではありません';
        $lecture = Lecture::where('room_id', $beacon->room_id)->first();
        $input['lecture_id'] = $lecture->id;
        if ($lecture->receptable) {
            $input['is_active'] = true;
            return Attendance::create($input);
        }
        return '現在出席できません';
    }
}
