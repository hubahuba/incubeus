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
                                <tbody>
                                    @if(!empty($templates))
                                        @foreach($templates as $id => $name)
                                    <tr>
                                        <td>
                                            <a class="btn btn-block btn-social btn-default" onclick="editTemplate('{{ $name }}')">
                                                {{ $name }} <i class="fa fa-times" onclick="javascript:removeTemplate('{{ $name }}');"></i>
                                            </a>
                                        </td>
                                    </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                No Template Found.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div><!-- /.box-body -->
                    </div>
                </div>
                <div class="col-lg-12 col-xs-12">
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#partial" data-toggle="tab">Partial</a></li>
                            <li><a href="#menu" data-toggle="tab">Menu</a></li>
                            <li><a href="#component" data-toggle="tab">Component</a></li>
                            <li><a href="#media" data-toggle="tab">Media</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="partial">
                                @if(!empty($partials))
                                    @foreach($partials as $id => $name)
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="templates" name="{{{ $name }}}" value="{{{ $id }}}"/>
                                            {{{ $name }}}
                                        </label>
                                    </div>
                                </div>
                                    @endforeach
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="javascript:addPartial();">Add&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                                </div>
                                @else
                                <p>No Partial Found.</p>
                                @endif
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane" id="menu">
                                @if(!empty($menus))
                                    @foreach($menus as $id => $name)
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="menus" name="{{{ $name }}}" value="{{{ $id }}}"/>
                                                    {{{ $name }}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript:addMenu();">Add&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                                    </div>
                                @else
                                    <p>No Menu Found.</p>
                                @endif
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane box-group" id="component">
                                @if(isset($components[0]))
                                    <?php $i = 1;?>
                                    @foreach($components as $val)
                                <div class="panel box box-default">
                                    <div class="box-header">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#component" href="#{{ $i }}" class="">
                                                {{{ $val['name'] }}}
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="{{ $i }}" class="panel-collapse collapse">
                                        <div class="box-body">
                                            <p>{{ isset($val['description']) ? '<i>' . $val['description'] . '</i>':'' }}</p>
                                            <p>{{ ($val['options']) ? $val['options']:'' }}</p>
                                            <a href="javascript:;" onclick="javascript:addComponent(this);" class="small-box-footer pull-right"
                                               data-action="{{{ $val['action'] }}}"
                                               data-handler="{{{ $val['handler'] }}}"
                                               data-option="{{ ($val['options']) ? 'true':'false' }}">
                                                Add <i class="fa fa-arrow-circle-right"></i>
                                            </a>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                                        <?php $i++;?>
                                    @endforeach
                                @else
                                    <p>No Component Found.</p>
                                @endif
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane" id="media">
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary btn-block" onclick="javascript:openFeature();">Select Image</button>
                                </div>
                            </div><!-- /.tab-pane -->

                        </div><!-- /.tab-content -->
                    </div><!-- nav-tabs-custom -->
                </div><!-- ./col -->
            </div>
        </div>

        <div class="col-lg-7 col-xs-12">
            <div class='box box-warning'>
                <div class='box-header' id="menu-form" style="padding: 5px 0 0 5px;">
                    <div class="col-xs-9">
                        <input type="text" name="label" id="tName" placeholder="Template Name" class="form-control" />
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