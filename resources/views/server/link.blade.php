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
                {!! Form::open(array('route' => 'link','method'=>'POST')) !!}
                {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('ip') ? ' has-error' : '' }}">
                            <label for="ip" class="col-md-4 control-label">{{trans('server.ip')}}:</label>
                            <div class="col-md-6">
                            {!! Form::text('ip', $config['ip'], array('placeholder' => trans('server.ip'),'class' => 'form-control')) !!}
                                @if ($errors->has('ip'))
                                <span class="help-block">
                                <strong>{{ $errors->first('ip') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('domain') ? ' has-error' : '' }}">
                            <label for="domain" class="col-md-4 control-label">@lang('server.domain') :</label>
                            <div class="col-md-6">
                            {!! Form::text('domain', $config['domain'], array('placeholder' => trans('server.domain'),'class' => 'form-control')) !!}
                                @if ($errors->has('domain'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('domain') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('port') ? ' has-error' : '' }}">
                            <label for="port" class="col-md-4 control-label">@lang('server.port') :</label>
                            <div class="col-md-6">
                            {!! Form::text('port', $config['port'], array('placeholder' => trans('server.port'),'class' => 'form-control')) !!}
                                @if ($errors->has('port'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('port') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('path') ? ' has-error' : '' }}">
                            <label for="path" class="col-md-4 control-label">@lang('server.path') :</label>
                            <div class="col-md-6">
                            {!! Form::text('path', $config['path'], array('placeholder' => trans('server.path'),'class' => 'form-control')) !!}
                                @if ($errors->has('path'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('path') }}</strong>
                                    </span>
                                @endif
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