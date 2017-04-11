@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@import(boot.new)</div>
                <div class="panel-body">
                        {!! Form::open(array('route' => 'boot.store','method'=>'POST')) !!}
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('model') ? ' has-error' : '' }}">
                            <label for="model" class="col-md-4 cntrol-label">@import(boot.model) :</label>

                            <div class="col-md-6">
                                {!! Form::select('model', $models , null,['class'=>'form-control']) !!}
                                @if ($errors->has('model'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('model') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">@import(boot.address) :</label>

                            <div class="col-md-6">
                                <input id="address" type="text" class="form-control" name="address" required autofocus>

                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('ch') ? ' has-error' : '' }}">
                            <label for="ch" class="col-md-4 control-label">@import(boot.channel) :</label>

                            <div class="col-md-6">
                                <input id="ch" type="text" class="form-control" name="ch" required autofocus>

                                @if ($errors->has('ch'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ch') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>@import(boot.vaild_info)</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    @import(boot.create)
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
@endsection
