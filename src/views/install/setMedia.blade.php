@extends('nccms::layouts.install')
@section('content')

    <div class="post-list">
        <div class="post-list-title">
            <h4>Image Media Configuration</h4>
            <hr>
        </div>
        <div class="post-list-excerpt">
            {{ \Form::open(['url' => \URL::current(), 'id' => 'form']) }}
            <div class="form-group{{{ $errors->first('mediaThumbW') || $errors->first('mediaThumbH') ? ' has-error':'' }}}">
                <label class="control-label">Thumbnail Size</label>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="mediaThumbW" class="form-control" value="{{{ isset($media['mediaThumbWidth']) ? $media['mediaThumbWidth']:Input::old('mediaThumbW') }}}" placeholder="Width">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="mediaThumbH" class="form-control" value="{{{ isset($media['mediaThumbHeight']) ? $media['mediaThumbHeight']:Input::old('mediaThumbH') }}}" placeholder="Height">
                    </div>
                </div>
                {{ $errors->first('mediaThumbW') ? '<code>'.$errors->first('mediaThumbW').'</code>':'' }}
                {{ $errors->first('mediaThumbH') ? '<code>'.$errors->first('mediaThumbH').'</code>':'' }}
            </div>
            <div class="form-group{{{ $errors->first('mediumW') || $errors->first('mediumH') ? ' has-error':'' }}}">
                <label class="control-label">Max Medium Size</label>
                <div class="row">
                    <div class="col-md-3">
                        <input type="text" name="mediumW" class="form-control" value="{{{ isset($media['mediaMediumWidth']) ? $media['mediaMediumWidth']:Input::old('mediumW') }}}" placeholder="Width">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="mediumH" class="form-control" value="{{{ isset($media['mediaMediumHeight']) ? $media['mediaMediumHeight']:Input::old('mediumH') }}}" placeholder="Height">
                    </div>
                </div>
                {{ $errors->first('mediumW') ? '<code>'.$errors->first('mediumW').'</code>':'' }}
                {{ $errors->first('mediumH') ? '<code>'.$errors->first('mediumH').'</code>':'' }}
            </div>
                <div class="form-group">
                    <nav>
                        <ul class="pager">
                            <li class="previous"><a href="{{ URL::to('installation/setting') }}"><span class="wi-angle-circle-left">&nbsp;</span>Back</a></li>
                            <li class="next"><a href="javascript:;" onclick="$('#form').submit();">Next &nbsp;<span class="wi-angle-circle-right"></span></a></li>
                        </ul>
                    </nav>
                </div>
            {{ Form::close() }}
        </div>
    </div>

@stop