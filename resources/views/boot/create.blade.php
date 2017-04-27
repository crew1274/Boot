@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('boot.new')</div>
                <div class="panel-body">
                        {!! Form::open(array('route' => 'boot.store','method'=>'POST')) !!}
                        {{ csrf_field() }}
                        <label for="model" class="col-md-4 cntrol-label">@lang('boot.model') :</label>
                        <div class="col-md-6">
                        <select name="parent" id="parent" class="form-control">
                        <option disabled selected value>@lang('boot.select')</option>
                        <option value="多功能電表">多功能電表</option>
                        <option value="多迴路電表">多迴路電表</option>
                        <option value="other">其他</option></select>
                        </div>
                        <label for="model" class="col-md-4 cntrol-label"></label>
                        <div class="col-md-6">
                        <select name="model" id="model" class="form-control"> </select>                        
                        </div>

                            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                            <label for="address" class="col-md-4 control-label">@lang('boot.address') :</label>
                            <div class="col-md-6">
                            {!! Form::text('address', null, array('placeholder' => '1~255','class' => 'form-control')) !!}
                                @if ($errors->has('address'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('address') }}</strong>
                                    </span>
                                @endif
                                <em>@lang('boot.unique')</em>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('ch') ? ' has-error' : '' }}">
                            <label for="ch" class="col-md-4 control-label">@lang('boot.channel') :</label>

                            <div class="col-md-6">
                  {!! Form::text('ch', null, array('placeholder' => '1~15','class' => 'form-control')) !!}
                                @if ($errors->has('ch'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('ch') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('speed') ? ' has-error' : '' }}">
                            <label for="speed" class="col-md-4 control-label">@lang('boot.baud_rate') :</label>

                            <div class="col-md-6">
                  {!!
                Form::select('speed', array('1200' => '1200'
                , '2400' => '2400'
                , '4800' => '4800'
                , '9600' => '9600'),null,['class'=>'form-control'])!!}
                                @if ($errors->has('speed'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('speed') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('circuit') ? ' has-error' : '' }}">
                            <label for="circuit" class="col-md-4 control-label">@lang('boot.circuit') :</label>

                            <div class="col-md-6">
                {!! Form::text('circuit', null, array('placeholder' => '1~72','class' => 'form-control')) !!}
                
                                @if ($errors->has('circuit'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('circuit') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                    <label class="text-danger">@lang('boot.vaild_info')</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-plus" aria-hidden="true"> @lang('boot.create')</i>
                                </button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('javascript')
<script>
$('#parent').change(function(e) {
    console.log('change')
		var parent = e.target.value;
		$.get('/api/type?type='+parent, function(data) {
            console.log(data)
			$('#model').empty();
			$.each(data, function(key, value) {
				var option = $("<option></option>")
	                  .attr("value", key)		                  
	                  .text(value);
                console.log(option)
				$('#model').append(option);
			});
		});
	});
</script>
@endpush
