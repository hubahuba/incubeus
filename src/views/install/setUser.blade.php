@extends('nccms::layouts.install')
@section('content')

    <div class="post-list">
        <div class="post-list-title">
            <h4>Administrator Creation</h4>
            <hr>
        </div>
        <div class="post-list-excerpt">
            {{ \Form::open(['url' => \URL::current(), 'id' => 'form']) }}
                <div class="form-group{{{ $errors->first('username') ? ' has-error':'' }}}">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" value="{{ Input::old('username') ? Input::old('username'):(isset($user['username']) ? $user['username']:'') }}" placeholder="Username">
                    {{ $errors->first('username') ? '<p class="help-block">'.$errors->first('username').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('password') ? ' has-error':'' }}}">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" value="{{ Input::old('password') }}" placeholder="Password">
                    {{ $errors->first('password') ? '<p class="help-block">'.$errors->first('password').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('repassword') ? ' has-error':'' }}}">
                    <label>Re-Password</label>
                    <input type="password" name="repassword" class="form-control" value="{{ Input::old('repassword') }}" placeholder="Confirmation Password">
                    {{ $errors->first('repassword') ? '<p class="help-block">'.$errors->first('repassword').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('firstname') ? ' has-error':'' }}}">
                    <label>Firstname</label>
                    <input type="text" name="firstname" class="form-control" value="{{ Input::old('firstname') ? Input::old('firstname'):(isset($user['firstname']) ? $user['firstname']:'') }}" placeholder="Firstname">
                    {{ $errors->first('firstname') ? '<p class="help-block">'.$errors->first('firstname').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('lastname') ? ' has-error':'' }}}">
                    <label>Lastname</label>
                    <input type="text" name="lastname" class="form-control" value="{{ Input::old('lastname') ? Input::old('lastname'):(isset($user['lastname']) ? $user['lastname']:'') }}" placeholder="Lastname">
                    {{ $errors->first('lastname') ? '<p class="help-block">'.$errors->first('lastname').'</p>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('nickname') ? ' has-error':'' }}}">
                    <label>Nickname</label>
                    <input type="text" name="nickname" class="form-control" value="{{ Input::old('nickname') ? Input::old('nickname'):(isset($user['nickname']) ? $user['nickname']:'') }}" placeholder="Nickname">
                    {{ $errors->first('nickname') ? '<p class="help-block">'.$errors->first('nickname').'</p>':'' }}
                </div>
                <div class="form-group">
                    <nav>
                        <ul class="pager">
                            <input type="hidden" name="id" value="{{ isset($user['id']) ? $user['id']:'' }}">
                            <li class="previous"><a href="{{ URL::to('installation') }}"><span class="wi-angle-circle-left">&nbsp;</span>Back</a></li>
                            <li class="next"><a href="javascript:;" onclick="$('#form').submit();">Next &nbsp;<span class="wi-angle-circle-right"></span></a></li>
                        </ul>
                    </nav>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@stop