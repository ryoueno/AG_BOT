@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">講義一覧</div>

                <div class="panel-body">
                    <table class="table">
                       @forelse($lectures as $lecture)
                            <tr>
                                <td>
                                    <td>
                                        <a href="{{ route('lecture.show', [$lecture->id]) }}">
                                            {{ $lecture->name }}
                                        </a>
                                    </td>
                                </td>
                                <td>
                                    {{ $lecture->room_id }}
                                </td>
                            </tr>
                        @empty
                            <tr><td>登録されていません</td></tr>
                        @endforelse
                    </table>
                    <div>
                        <a href="{{ route('lecture.create')}}">
                            追加
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
