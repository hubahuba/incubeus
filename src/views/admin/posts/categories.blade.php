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
                        Category Form
                    </h3>
                </div><!-- /.box-header -->
                {{ Form::open([
                    'url' => URL::current(),
                    'id' => 'cForm'
                ]) }}
                <div class='box-body pad'>
                    <div class="form-group{{{ $errors->first('cName') ? ' has-error':'' }}}">
                        <label>Name</label>
                        <input type="text" name="cName" class="form-control" placeholder="Category Name" value="{{{ Input::old('cName') }}}" />
                        {{ $errors->first('cName') ? '<code>'.$errors->first('cName').'</code>':'' }}
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <textarea rows="4" name="cDescription" class="form-control" placeholder="Category Description"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Icon Class</label>
                        <input type="text" name="cIcon" class="form-control" placeholder="Category Icon Class ex: fa-upload" />
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
                        Category List
                    </h3>
                </div><!-- /.box-header -->
                <div class='box-body table-responsive'>
                    <table id="cList" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($categories[0]))
                                @foreach($categories as $category)
                            <tr>
                                <td>
                                    <a class="cEditor" href="javascript:;" data-name="{{ $category['name'] }}" data-id="{{ $category['id'] }}" data-desc="{{ $category['description'] }}" data-icon="{{ $category['icon'] }}">
                                        {{ $category['name'] }}
                                    </a>
                                </td>
                                <td>{{ $category['description'] }}</td>
                                <td>
                                    {{ Form::open([
                                        'url' => URL::current()
                                    ]) }}
                                    <input type="hidden" name="delete" value="1">
                                    <input type="hidden" name="theID" value="{{ $category['id'] }}">
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