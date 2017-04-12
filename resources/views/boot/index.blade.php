@extends('layouts.app')

@section('content')
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
@endsection