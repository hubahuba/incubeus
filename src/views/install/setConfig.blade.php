@extends('nccms::layouts.install')
@section('content')

    <div class="post-list">
        <div class="post-list-title">
            <h4>Application Configuration</h4>
            <hr>
        </div>
        <div class="post-list-excerpt">
            {{ \Form::open(['url' => \URL::current(), 'id' => 'form']) }}
                <div class="form-group{{{ $errors->first('url') ? ' has-error':'' }}}">
                    <label class="control-label">Debug Mode</label>
                    <select name="debug" class="form-control">
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                    {{ $errors->first('debug') ? '<code>' . $errors->first('debug') . '</code>':'<code>Set True For Development Only.</code>' }}
                </div>
                <div class="form-group{{{ $errors->first('url') ? ' has-error':'' }}}">
                    <label class="control-label">Site URL</label>
                    <input type="text" name="url" class="form-control" value="{{ isset($site['url']) ? $site['url']:Input::old('url') }}" placeholder="Site URL, eg :http://web.narrada.com">
                    {{ $errors->first('url') ? '<code>' . $errors->first('url') . '</code>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('timezone') ? ' has-error':'' }}}">
                    <label class="control-label">Timezone</label>
                    <select name="timezone" class="form-control">
                        @foreach($timezones as $timezone)
                        <option value="{{ $timezone }}" {{ (Input::old('timezone')) ? ((Input::old('timezone') == $timezone) ? 'selected="selected"':''):($timezone==date_default_timezone_get()) ? 'selected="selected"':'' }}>{{ $timezone }}</option>
                        @endforeach
                    </select>
                    {{ $errors->first('timezone') ? '<code>' . $errors->first('timezone') . '</code>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('eKey') ? ' has-error':'' }}}">
                    <label class="control-label">Encription Key</label>
                    <input type="text" name="eKey" class="form-control" value="{{ Input::old('eKey') ? Input::old('eKey'):\Format::generateFilename(20) }}">
                    {{ $errors->first('eKey') ? '<code>' . $errors->first('eKey') . '</code>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('prefix') ? ' has-error':'' }}}">
                    <label class="control-label">Backend Prefix</label>
                    <input type="text" name="prefix" class="form-control" value="{{ Input::old('prefix') ? Input::old('prefix'):'admin' }}">
                    {{ $errors->first('prefix') ? '<code>' . $errors->first('prefix') . '</code>':'' }}
                </div>

                <div class="form-group">
                    <nav>
                        <ul class="pager">
                            <li class="previous"><a href="{{ URL::to('installation/media') }}"><span class="wi-angle-circle-left">&nbsp;</span>Back</a></li>
                            <li class="next"><a href="javascript:;" onclick="$('#form').submit();">Next &nbsp;<span class="wi-angle-circle-right"></span></a></li>
                        </ul>
                    </nav>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@stop