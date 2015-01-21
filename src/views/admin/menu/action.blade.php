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
                                    @if(!empty($menus))
                                        @foreach($menus as $id => $name)
                                    <tr>
                                        <td>
                                            <a class="btn btn-block btn-social btn-default" onclick="editMenu('{{ $name }}')">
                                                {{ $name }} <i class="fa fa-times" onclick="javascript:removeMenu('{{ $name }}');"></i>
                                            </a>
                                        </td>
                                    </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td>
                                                No Menu Found.
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
                            <li class="active"><a href="#page" data-toggle="tab">Page</a></li>
                            <li><a href="#post" data-toggle="tab">Post</a></li>
                            <li><a href="#media" data-toggle="tab">Media</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="page">
                                @if(isset($pages[0]))
                                    @foreach($pages as $page)
                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" class="pages" name="{{{ $page['title'] }}}" value="{{{ $page['id'] }}}"/>
                                            {{{ $page['title'] }}}
                                        </label>
                                    </div>
                                </div>
                                    @endforeach
                                <div class="text-right">
                                    <button type="button" class="btn btn-primary btn-sm" onclick="javascript:addPage();">Add&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                                </div>
                                @else
                                <p>No Page Found.</p>
                                @endif
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane" id="post">
                                @if(isset($posts[0]))
                                    @foreach($posts as $post)
                                        <div class="form-group">
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" class="posts" name="{{{ $post['title'] }}}" value="{{{ $post['id'] }}}"/>
                                                    {{{ $post['title'] }}}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="text-right">
                                        <button type="button" class="btn btn-primary btn-sm" onclick="javascript:addPost();">Add&nbsp;&nbsp;<i class="fa fa-arrow-right"></i></button>
                                    </div>
                                @else
                                    <p>No Page Found.</p>
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
                        <input type="text" name="label" id="mName" placeholder="Menu Name" class="form-control" />
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