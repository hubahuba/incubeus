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
        <div class="col-lg-5 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    <div class="box">
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody id="ff-holder">
                                    @if(!empty($files))
                                        @foreach($files['dirs'] as $dir)
                                    <tr>
                                        <td>
                                            <a style="display: block;" onclick="javascript:changeFolder('{{ $dir }}');" href="javascript:;">{{ $dir }}</a>
                                        </td>
                                    </tr>
                                        @endforeach
                                        @foreach($files['files'] as $file)
                                            <tr>
                                                <td>
                                                    @if( in_array(\File::extension($file), \Config::get('nccms::ace')))
                                                        <div class="btn btn-block btn-social btn-default">
                                                            <i class="fa fa-times" onclick="javascript:removeAsset('{{ $file }}');"></i>
                                                            <a href="javascript:;" style="display: block" onclick="editAsset('{{ $file }}')">{{ $file }}</a>
                                                        </div>
                                                    @else
                                                        {{ $file }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                No Files/Folder Found.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <div class="box">
                        <div class="box-body">
                            <button type="button" onclick="javascript:publishAsset();" class="btn btn-success">Publish Asset</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-7 col-xs-12">
            <div class='box box-warning'>
                <div class='box-header' id="partial-form" style="padding: 5px 0 0 5px;">
                    <div class="col-xs-9">
                        <input type="text" name="label" id="pName" placeholder="Partial Name" class="form-control" />
                    </div>
                    <button type="button" onclick="javascript:saveFile();" class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save Changes</button>
                </div>
                <div class='box-body pad' style="min-height: 530px">
                    <div id="editor"></div>
                </div>
            </div>
        </div>

    </div><!-- /.row -->
</section><!-- /.content -->

@stop