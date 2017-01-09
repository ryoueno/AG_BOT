@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">新規講義作成</div>
                <div class="panel-body">
                    <form action="{{ route('lecture.store') }}" method="post">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            @if($errors->first('name'))
                                <small class="text-muted validation-error-message">{{ $errors->first('name') }}</small>
                            @endif
                            <input type="text" class="form-control" name="name" placeholder="講義名" value="{{ old('name', $lecture->name) }}">
                        </div>
                        <div>
                            <button class="btn btn-primary" type="submit">保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
