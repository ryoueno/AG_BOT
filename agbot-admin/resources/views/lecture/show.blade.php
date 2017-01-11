@extends('layouts.app')

@section('content')
<script>
    alert("上野 涼(18114035) が呼んでます");
</script>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $lecture->name }}
                    <div class="text-right">教室番号：{{ $lecture->room_id }}</div>
                </div>

                <div class="panel-body">
                    <div class="panel-body">
                        <a href="{{ 'change/' . $lecture->id }}">
                            @if($lecture->receptable)
                                <button class="btn btn-warning">出席受付中</button>
                            @else
                                <button class="btn btn-info">出席者を受け付ける</button>
                                <div>
                                    <small class="text-muted">※現在出席できません</small>
                                </div>
                            @endif
                        </a>
                    </div>
                    <table class="table">
                        <h4>出席なう</h4>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>
                                    {{ $attendance->student_id }}
                                </td>
                            </tr>
                        @empty
                            <tr><td>出席者はいません</td></tr>
                        @endforelse
                    </table>
                    <div class="panel-body">
                        <a href="{{ 'reset/' . $lecture->id }}">
                            <button class="btn btn-primary">出席者をリセット</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
