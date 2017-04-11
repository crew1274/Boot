@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('home.boot')</div>
                <div class="row">
                <div class="col-lg-12 margin-tb">
                <div class="pull-right">
                <a class="btn btn-success" href="{{ url('/boot/create') }}">
                @lang('home.create')</a>
                </div>

                <table class="table table-bordered">
        <tr>
            <th>@lang('home.model')</th>
            <th>@lang('home.address')</th>
            <th>@lang('home.channel')</th>
            <th>@lang('home.baud_rate')</th>
            <th>@lang('home.circuit')</th>
            <th>@lang('home.action')</th>
        </tr>
    @foreach ($settings as $key => $setting)
    @if  ($setting->token == false)
    <tr class="danger">
        <td><p class="text-danger">{{ $setting->model }}</p></td>
        <td><p class="text-danger">{{ $setting->address }}</p></td>
        <td><p class="text-danger">{{ $setting->ch }}</p></td>
        <td><p class="text-danger">{{ $setting->speed }}</p></td>
        <td><p class="text-danger">{{ $setting->circuit }}</p></td>
        <td>
            <a class="btn btn-primary" href="{{ route('boot.edit',$setting->id) }}">@lang('home.edit')</a>
            <a class="btn btn-danger" href="{{ route('boot.delete',$setting->id) }}">@lang('home.delete')</a>
            <a class="btn btn-warning" href="{{ route('boot.show',$setting->id) }}">@lang('home.vaild')</a>
        </td>
    </tr>
    @else
    <tr class="info">
        <td><p class="text-info">{{ $setting->model }}</p></td>
        <td><p class="text-info">{{ $setting->address }}</p></td>
        <td><p class="text-info">{{ $setting->ch }}</p></td>
        <td><p class="text-info">{{ $setting->speed }}</p></td>
        <td><p class="text-danger">{{ $setting->circuit }}</p></td>
        <td>
            <a class="btn btn-primary" href="{{ route('boot.edit',$setting->id) }}">@lang('home.edit')</a>
            <a class="btn btn-danger" href="{{ route('boot.delete',$setting->id) }}">@lang('home.delete')</a>
        </td>
    </tr>

    @endif
    @endforeach
    </table>

        </div>
    </div>

                
            </div>
        </div>
    </div>
</div>
@endsection
