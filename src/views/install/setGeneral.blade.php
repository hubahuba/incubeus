@extends('nccms::layouts.install')
@section('content')

    <div class="post-list">
        <div class="post-list-title">
            <h4>Website Configuration</h4>
            <hr>
        </div>
        <div class="post-list-excerpt">
            {{ \Form::open(['url' => \URL::current(), 'id' => 'form']) }}
                <div class="form-group{{{ $errors->first('siteTitle') ? ' has-error':'' }}}">
                    <label class="control-label">Site Title</label>
                    <input type="text" name="siteTitle" class="form-control" value="{{ isset($site['siteTitle']) ? $site['siteTitle']:Input::old('siteTitle') }}" placeholder="Site Title">
                    {{ $errors->first('siteTitle') ? '<code>' . $errors->first('siteTitle') . '</code>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('siteTagline') ? ' has-error':'' }}}">
                    <label class="control-label">Site Tagline</label>
                    <textarea rows="4" class="form-control" name="siteTagline" placeholder="Site Tagline">{{ isset($site['siteTagline']) ? $site['siteTagline']:Input::old('siteTagline') }}</textarea>
                    {{ $errors->first('siteTagline') ? '<code>' . $errors->first('siteTagline') . '</code>':'' }}
                </div>
                <div class="form-group{{{ $errors->first('siteGA') ? ' has-error':'' }}}">
                    <label class="control-label">Google Tracking ID</label>
                    <input type="text" name="siteGA" class="form-control" value="{{ isset($site['siteGA']) ? $site['siteGA']:Input::old('siteGA') }}" placeholder="Google Traking ID">
                    {{ $errors->first('siteGA') ? '<code>' . $errors->first('siteGA') . '</code>':'' }}
                </div>
                <div class="form-group{{{ ($errors->first('dateFormat') || $errors->first('dateCustom')) ? ' has-error':'' }}}">
                    <label class="control-label">Date Format</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="dateFormat" id="optionsRadios1" value="F j, Y" {{ (isset($site['siteDate']) && $site['siteDate'] == 'F j, Y') ? 'checked':'' }}>
                            {{{ date('F j, Y') }}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="dateFormat" id="optionsRadios2" value="m/d/Y" {{ (isset($site['siteDate']) && $site['siteDate'] == 'm/d/Y') ? 'checked':'' }}>
                            {{{ date('m/d/Y') }}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="dateFormat" id="optionsRadios3" value="d/m/Y" {{ (isset($site['siteDate']) && $site['siteDate'] == 'd/m/Y') ? 'checked':'' }}>
                            {{{ date('d/m/Y') }}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="dateFormat" id="customDate" value="custom" {{ (isset($site['siteDate']) && $site['siteDate'] != 'F j, Y' && $site['siteDate'] != 'd/m/Y' && $site['siteDate'] != 'm/d/Y') ? 'checked':'' }}>
                            Custom
                        </label>
                        <input type="text" class="custFormat" name="dateCustom" for="customDate" value="{{ (isset($site['siteDate']) && $site['siteDate'] != 'F j, Y' && $site['siteDate'] != 'd/m/Y' && $site['siteDate'] != 'm/d/Y') ? $site['siteDate']:'F j, Y' }}">
                        <span id="dateDisplay">{{{ date('F j, Y') }}}</span>
                    </div>
                    {{ $errors->first('dateFormat') ? '<code>' . $errors->first('dateFormat') . '</code>':'' }}
                    {{ $errors->first('dateCustom') ? '<code>' . $errors->first('dateCustom') . '</code>':'' }}
                </div>
                <div class="form-group{{{ ($errors->first('timeFormat') || $errors->first('customTime')) ? ' has-error':'' }}}">
                    <label class="control-label">Time Format</label>
                    <div class="radio">
                        <label>
                            <input type="radio" name="timeFormat" id="optionsRadios1" value="H:i a" {{ (isset($site['siteTime']) && $site['siteTime'] == 'H:i a') ? 'checked':'' }}>
                            {{{ date('H:i a') }}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="timeFormat" id="optionsRadios2" value="H:i A" {{ (isset($site['siteTime']) && $site['siteTime'] == 'H:i A') ? 'checked':'' }}>
                            {{{ date('H:i A') }}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="timeFormat" id="optionsRadios3" value="H:i" {{ (isset($site['siteTime']) && $site['siteTime'] == 'H:i') ? 'checked':'' }}>
                            {{{ date('H:i') }}}
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="timeFormat" id="customTime" value="custom" {{ (isset($site['siteTime']) && $site['siteTime'] != 'H:i a' && $site['siteTime'] != 'H:i A' && $site['siteTime'] != 'H:i') ? 'checked':'' }}>
                            Custom
                        </label>
                        <input type="text" class="custFormat" name="timeCustom" for="customTime" value="{{ (isset($site['siteTime']) && $site['siteTime'] != 'H:i a' && $site['siteTime'] != 'H:i A' && $site['siteTime'] != 'H:i') ? $site['siteTime']:'H:i a' }}">
                        <span id="timeDisplay">{{{ date('H:i a') }}}</span>
                    </div>
                    {{ $errors->first('timeFormat') ? '<code>' . $errors->first('timeFormat') . '</code>':'' }}
                    {{ $errors->first('timeCustom') ? '<code>' . $errors->first('timeCustom') . '</code>':'' }}
                </div>
                <div class="form-group">
                    <nav>
                        <ul class="pager">
                            <li class="previous"><a href="{{ URL::to('installation/user') }}"><span class="wi-angle-circle-left">&nbsp;</span>Back</a></li>
                            <li class="next"><a href="javascript:;" onclick="$('#form').submit();">Next &nbsp;<span class="wi-angle-circle-right"></span></a></li>
                        </ul>
                    </nav>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@stop