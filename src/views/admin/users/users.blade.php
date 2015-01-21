@extends('nccms::layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{{ $title }}}
        <small><i class="fa fa-paperclip"></i> Posts</small>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <!-- Publish -->
            <div class='box box-warning'>
                <div class='box-header'>
                    <h3 class='box-title'>
                        User Creation Form
                    </h3>
                </div><!-- /.box-header -->
                {{ Form::open([
                    'url' => URL::current(),
                    'id' => 'cForm'
                ]) }}
                <div class='box-body pad'>
                    <div class="form-group{{{ $errors->first('cUsername') ? ' has-error':'' }}}">
                        <label>Username</label>
                        <input type="text" name="cUserName" class="form-control" placeholder="Username" value="{{{ Input::old('cUserName') }}}" />
                        {{ $errors->first('cUserName') ? '<code>'.$errors->first('cUserName').'</code>':'' }}
                    </div>
                    <div class="form-group{{{ $errors->first('cFirstName') ? ' has-error':'' }}}">
                        <label>First Name</label>
                        <input type="text" name="cFirstName" class="form-control" placeholder="First Name" value="{{{ Input::old('cFirstName') }}}" />
                        {{ $errors->first('cFirstName') ? '<code>'.$errors->first('cFirstName').'</code>':'' }}
                    </div>
                    <div class="form-group{{{ $errors->first('cLastName') ? ' has-error':'' }}}">
                        <label>Last Name</label>
                        <input type="text" name="cLastName" class="form-control" placeholder="Last Name" value="{{{ Input::old('cLastName') }}}" />
                        {{ $errors->first('cLastName') ? '<code>'.$errors->first('cLastName').'</code>':'' }}
                    </div>
                    <div class="form-group{{{ $errors->first('cNickname') ? ' has-error':'' }}}">
                        <label>Nickname</label>
                        <input type="text" name="cNickname" class="form-control" placeholder="Nickname" value="{{{ Input::old('cNickname') }}}" />
                        {{ $errors->first('cNickname') ? '<code>'.$errors->first('cNickname').'</code>':'' }}
                    </div>
                    <div class="form-group{{{ $errors->first('password') ? ' has-error':'' }}}">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" value="{{{ Input::old('password') }}}">
                        {{ $errors->first('password') ? '<code>'.$errors->first('password').'</code>':'' }}
                    </div>
                    <div class="form-group{{{ $errors->first('password_confirmation') ? ' has-error':'' }}}">
                        <label>Re Type Password</label>
                        <input type="password" class="form-control" placeholder="Re Password" name="password_confirmation" value="{{{ Input::old('password_confirmation') }}}">
                        {{ $errors->first('password_confirmation') ? '<code>'.$errors->first('password_confirmation').'</code>':'' }}
                    </div>
                    <div class="form-group">
                        <label>Level</label>
                        <select class="form-control" name="user_level">
                            <option value="1">Administrator</option>
                            <option value="2">Editor</option>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <input type="hidden" name="cID" id="cID" />
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
                {{ Form::close() }}
            </div><!-- /.box -->
        </div><!-- ./col -->
        <div class="col-lg-8 col-xs-12">
            <div class='box box-info'>
                <div class='box-header'>
                    <h3 class='box-title'>
                        User List
                    </h3>
                </div><!-- /.box-header -->
                <div class='box-body table-responsive'>
                    <table id="cList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>First Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($users[0]))
                                @foreach($users as $users_temp)
                            <tr>

                                <td>
                                    <a class="cEditor" href="javascript:;" data-firstname="{{$users_temp['firstname']}}" data-lastname="{{$users_temp['lastname']}}" data-nickname="{{$users_temp['nickname']}}" data-name="{{ $users_temp['username'] }}" data-id="{{ $users_temp['id'] }}">
                                        {{ $users_temp['username'] }}
                                    </a>
                                </td>
                                <td>{{ $users_temp['firstname'] }}</td>
                                <td>
                                    {{ Form::open([
                                        'url' => URL::current()
                                    ]) }}
                                    <input type="hidden" name="delete" value="1">
                                    <input type="hidden" name="theID" value="{{ $users_temp['id'] }}">
                                    <button class="btn btn-xs btn-danger" onclick="return confirm('Delete this category?');">delete</button>
                                    {{ Form::close() }}
                                </td>
                            </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div><!-- /.box -->
        </div><!-- ./col -->
    </div><!-- /.row -->
</section><!-- /.content -->

@stop