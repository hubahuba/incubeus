@extends('nccms::layouts.install')
@section('content')

    <div class="post-list">
        <div class="post-list-title">
            <h4>Database Configuration</h4>
            <hr>
        </div>
        <div class="post-list-excerpt">
            {{ \Form::open(['url' => \URL::current(), 'id' => 'form']) }}
                <div class="form-group{{{ $errors->first('connection') ? ' has-error':'' }}}">
                    <label>Database Type</label>
                    <input type="text" class="form-control" value="MySQL" readonly>
                    {{ $errors->first('connection') ? '<p class="help-block">'.$errors->first('connection').'</p>':'' }}
                </div>
                <div class="form-group{{{ ($errors->first('host') || $errors->first('port')) ? ' has-error':'' }}}" id="host">
                    <label>Database Host</label>
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="host" class="form-control" value="{{ (Input::old('host')) ? Input::old('host'):(isset($config['host']) ? $config['host']:Input::old('host')) }}" placeholder="localhost">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="port" class="form-control" value="{{ (Input::old('port')) ? Input::old('port'):(isset($config['port']) ? $config['port']:Input::old('port')) }}" placeholder="3306">
                        </div>
                    </div>
                    {{ $errors->first('host') ? '<p class="help-block">'.$errors->first('host').'</p>':'' }}
                    {{ $errors->first('port') ? '<p class="help-block">'.$errors->first('port').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('username') ? ' has-error':'' }}}" id="username">
                    <label>Database Username</label>
                    <input type="text" name="username" class="form-control" value="{{ (Input::old('username')) ? Input::old('username'):(isset($config['username']) ? $config['username']:Input::old('username')) }}" placeholder="root">
                    {{ $errors->first('username') ? '<p class="help-block">'.$errors->first('username').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('password') ? ' has-error':'' }}}" id="password">
                    <label>Database Password</label>
                    <input type="text" name="password" class="form-control" value="{{ (Input::old('password')) ? Input::old('password'):(isset($config['password']) ? $config['password']:Input::old('password')) }}" placeholder="secret">
                    {{ $errors->first('password') ? '<p class="help-block">'.$errors->first('password').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('database') ? ' has-error':'' }}}" id="database">
                    <label>Database Name</label>
                    <input type="text" name="database" class="form-control" value="{{ (Input::old('database')) ? Input::old('database'):(isset($config['database']) ? $config['database']:Input::old('database')) }}" placeholder="nccms">
                    {{ $errors->first('database') ? '<p class="help-block">'.$errors->first('database').'</p<p class="help-block">Make sure database already created on you\'re server (NCCMS won\'t create the database for you).</zp>>':'' }}
                </div>
                <div class="form-group" id="prefix">
                    <label>Database Prefix</label>
                    <input type="text" name="prefix" class="form-control" value="{{ (Input::old('prefix')) ? Input::old('prefix'):(isset($config['prefix']) ? $config['prefix']:'nc_') }}" placeholder="nc_">
                </div>
                <div class="form-group">
                    <nav>
                        <ul class="pager">
                            <li class="next"><a href="javascript:;" onclick="$('#form').submit();">Next &nbsp;<span class="wi-angle-circle-right"></span></a></li>
                        </ul>
                    </nav>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@stop