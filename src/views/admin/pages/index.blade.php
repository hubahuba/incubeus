@extends('nccms::layouts.admin')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        {{{ $title }}}
        <a class="btn btn-primary btn-xs" href="{{ URL::nccms('page/new') }}"><i class="fa fa-plus"></i> New</a>
    </h1>
</section>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class='box box-info'>
                <div class='box-header'>
                    <h3 class='box-title'>
                        Page List
                    </h3>
                </div><!-- /.box-header -->
                <div class='box-body table-responsive'>
                    <table id="pList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Excerpt</th>
                                <th>Status</th>
                                <th>Publish Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($pages[0]))
                                @foreach($pages as $page)
                            <tr>
                                <td>
                                    <a class="cEditor" href="{{ URL::nccms('page/edit/'.$page['id']) }}">
                                        {{ $page['title'] }}
                                    </a>
                                </td>
                                <td>{{ ($page['excerpt']) ? str_limit($page['excerpt']):'' }}</td>
                                <td>{{ ($page['status'] == 'pub') ? '<span class="label label-success">Publish</span>':'<span class="label label-warning">Draft</span>' }}</td>
                                <td>{{ ($page['publish_date']) ? \Format::formats_date($page['publish_date'], 'd/m/Y'):'' }}</td>
                                <td>
                                    <a href="{{ \URL::nccms('page/edit/'.$page['id']) }}" class="btn btn-xs btn-primary">Edit</a>
                                    <a href="{{ \URL::nccms('page/delete/'.$page['id']) }}" onclick="return confirm('Delete This Post?')" class="btn btn-xs btn-danger">Delete</a>
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