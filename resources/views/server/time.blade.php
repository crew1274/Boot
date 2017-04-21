@extends('layouts.app')
@push('css')
@LaravelSweetAlertCSS
@endpush
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('server.link')</div>
                <div class="panel-body">
                {!! Form::open(array('route' => 'time','method'=>'POST')) !!}
                {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('gap') ? ' has-error' : '' }}">
                            <label for="gap" class="col-md-4 control-label">{{trans('server.second')}}:</label>
                            <div class="col-md-6">
                            {!! Form::text('gap', $config['gap'], array('placeholder' => trans('server.second'),'class' => 'form-control')) !!}
                                @if ($errors->has('gap'))
                                <span class="help-block">
                                <strong>{{ $errors->first('gap') }}</strong>
                                </span>
                                @endif
                                <em>(單位:秒)</em>
                            </div>
                        </div>
                        </div>
                        </div>
                        <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">{{trans('server.apply')}}</button>
                        </div>
                        </div>
                    </form>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
@LaravelSweetAlertJS
@endpush