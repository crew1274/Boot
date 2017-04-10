@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @elseif ($message = Session::get('dangerous'))
    <div class="alert alert-dangerous">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">開機設定</div>

                
            </div>
        </div>
    </div>
</div>
@endsection
