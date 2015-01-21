@extends('nccms::layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{{ $title }}}
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (tab box) -->
    <div class="row">
        @foreach($themes as $key => $theme)
            <?php $detail = $theme->themeDetails();?>
        <div class="col-md-6">
            <!-- Info box -->
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title">{{ $detail['name'] }}</h3>
                    <div class="box-tools pull-right">
                        @if(\Nccms::getActiveTheme() == $key)
                        <div class="label bg-green">Active</div>
                        @else
                        {{ Form::open([
                            'url' => URL::current()
                        ]) }}
                        <input type="hidden" name="theme" value="{{$key}}">
                        <button class="btn btn-primary btn-xs" data-toggle="tooltip" data-original-title="Activate"><i class="fa fa-check"></i></button>
                        {{ Form::close() }}
                        @endif
                    </div>
                </div>
                <div class="box-body">
                    <p>
                        Author: <a target="_blank" href="{{ $detail['author_url'] }}">{{ $detail['author'] }}</a>
                    </p>
                    <p>
                        {{ $detail['description'] }}
                    </p>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
        @endforeach
    </div><!-- /.row -->
</section><!-- /.content -->

@stop