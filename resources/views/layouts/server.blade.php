{!! Form::open(array('route' => 'link','method'=>'POST')) !!}
<div class="modal fade" id="link" tabindex="-1" role="dialog" aria-labelledby="link">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">{{trans('server.link')}}</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name"class="control-label">{{trans('server.ip')}}:</label>
            {!! Form::text('ip', $config['ip'], array('placeholder' => trans('server.ip'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group">
            <label for="recipient-name"class="control-label">{{trans('server.domain')}}:</label>
            {!! Form::text('domain', $config['domain'], array('placeholder' => trans('server.domain'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group">
            <label for="recipient-name"class="control-label">{{trans('server.port')}}:</label>
            {!! Form::text('port', $config['port'], array('placeholder' => trans('server.port'),'class' => 'form-control')) !!}
          </div>
          <div class="form-group">
            <label for="recipient-name"class="control-label">{{trans('server.path')}}:</label>
            {!! Form::text('path', $config['path'], array('placeholder' => trans('server.path'),'class' => 'form-control')) !!}
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('server.close')}}</button>
        <button type="submit" class="btn btn-primary">{{trans('server.apply')}}</button>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}

{!! Form::open(array('route' => 'time','method'=>'POST')) !!}
<div class="modal fade" id="time" tabindex="-1" role="dialog" aria-labelledby="time">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">{{trans('server.time')}}</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name"class="control-label">{{trans('server.second')}}:</label>
            {!! Form::text('gap', $config['gap'] , array('placeholder' => trans('server.second'),'class' => 'form-control')) !!}
          </div>
          <em>(單位:秒)</em>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('server.close')}}</button>
        <button type="submit" class="btn btn-primary">{{trans('server.apply')}}</button>
      </div>
    </div>
  </div>
</div>
{!! Form::close() !!}