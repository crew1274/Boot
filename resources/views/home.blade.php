@extends('layouts.app')
@push('css')
@LaravelSweetAlertCSS
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"> @lang('home.boot')</div>
                <div class="row">
                <div class="col-lg-12 margin-tb">

                <table class="table table-bordered">
        <thead>
        <tr>
            <th>@lang('home.model')</th>
            <th>@lang('home.address')</th>
            <th>@lang('home.circuit')</th>
            <th>@lang('home.baud_rate')</th>
            <th>@lang('home.action')</th>
        </tr>
        </thead>
    <tbody>
    @foreach ($setting as $setting )
    @if  ($setting-> vaild == '0' )
    <tr class="danger">
        <td><p class="text-danger">{{ $setting->model }}</p></td>
        <td><p class="text-danger">{{ $setting->address }}</p></td>
        <td><p class="text-danger">{{ $setting->circuit }}</p></td>
        <td><p class="text-danger">{{ $setting->speed }}</p></td>
        <td>
            <a class="btn btn-primary" href="{{ route('boot.edit',$setting->id) }}">@lang('home.edit')</a>
            {!! Form::open(['method' => 'DELETE','route' => ['boot.destroy', $setting->id],'style'=>'display:inline']) !!}
            {!! Form::submit(trans('home.delete'), ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}            
            <a class="btn btn-warning" href="{{ route('boot.show',$setting->id) }}">@lang('home.valid')</a>
        </td>
    </tr>
    @else
    <tr class="info">
        <td><p class="text-info">{{ $setting->model }}</p></td>
        <td><p class="text-danger">{{ $setting->address }}</p></td>
        <td><p class="text-info">{{ $setting->circuit }}</p></td>
        <td><p class="text-info">{{ $setting->speed }}</p></td>
        <td>
            <a class="btn btn-primary" href="{{ route('boot.edit',$setting->id) }}">@lang('home.edit')</a>
            {!! Form::open(['method' => 'DELETE','route' => ['boot.destroy', $setting->id],'style'=>'display:inline']) !!}
            {!! Form::submit(trans('home.delete'), ['class' => 'btn btn-danger']) !!}
            {!! Form::close() !!}
        </td>
    </tr>
    @endif
    @endforeach
    </tbody>
    </table>
                </div>  
            </div>
        </div>
    <div class="pull-right">
        <a class="btn btn-success" href="{{ url('/boot/create') }}">
        <i class="fa fa-plus" aria-hidden="true">  @lang('home.create')</a></i>
    </div>
</div>
@endsection
@push('javascript')
@LaravelSweetAlertJS
@endpush