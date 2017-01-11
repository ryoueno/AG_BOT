<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

// Lecture
Route::resource(
    'lecture',
    'LectureController',
    [
        'only' => ['index', 'show', 'create', 'store'],
    ]
);
Route::get('/lecture/reset/{id}', 'LectureController@reset');
Route::get('/lecture/change/{id}', 'LectureController@changeReceptable');

// // Attendance
// Route::resource(
//     'attendance',
//     'AttendanceController',
//     [
//         'only' => ['store'],
//     ]
// );
Route::post('/attendance', 'AttendanceController@store');
Route::post('/student', 'StudentController@store');
Route::post('/student/set', 'StudentController@set');
Route::get('/student/status/{id}', 'StudentController@getStatus');