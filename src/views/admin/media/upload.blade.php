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
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <!-- small box -->
            <div class="box box-primary">
                <div class='box-body pad'>
                    <span class="btn btn-success fileinput-button">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Upload Media...</span>
                        <!-- The file input field used as target for the file upload widget -->
                        <input id="fileupload" type="file" name="media[]" multiple>
                    </span>
                </div>
                <div class='box-body pad'>
                    <div class="progress xs hide">
                        <div class="progress-bar"></div>
                    </div>
                </div>

                <div class='box-header'>
                    <h3 class='box-title'>
                        Preview Image
                    </h3>
                </div>
                <div class='box-body pad'>
                    <div id="uploadPreview"></div>
                </div>
            </div>
        </div><!-- ./col -->
    </div><!-- /.row -->

</section><!-- /.content -->

@stop