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
    {{ Form::open([
        'url' => URL::current()
    ]) }}
    <div class="row">
        <div class="col-lg-8 col-xs-12">
            <div class='box box-info'>
                <div class='box-body pad'>
                    <!--title-->
                    <div class="form-group{{{ $errors->first('p-title') ? ' has-error':'' }}}">
                        <input type="text" name="p-title" onkeyup="javascript:slug(this.value);" placeholder="Post Title Here" class="form-control" value="{{ isset($post['title']) ? $post['title']:Input::old('p-title') }}" />
                        {{ $errors->first('p-title') ? '<code>'.$errors->first('p-title').'</code>':'' }}
                    </div>
                    <!--slug-->
                    <div class="form-group{{{ $errors->first('p-slug') ? ' has-error':'' }}}">
                        <input type="text" name="p-slug" id="p-slug" placeholder="Post Slug" class="form-control" value="{{ isset($post['slug']) ? $post['slug']:Input::old('p-slug') }}" />
                        {{ $errors->first('p-slug') ? '<code>'.$errors->first('p-slug').'</code>':'' }}
                    </div>
                    <!--content-->
                    <textarea id="editor" name="p-content" rows="10" cols="80">{{ isset($post['post']) ? $post['post']:Input::old('p-content') }}</textarea>
                    <!--excerpt-->
                    <br>
                    <div class="form-group">
                        <textarea class="form-control" name="p-excerpt" rows="3" cols="80" placeholder="Post Excerpt Here (Max 200 Char.)">{{ isset($post['excerpt']) ? $post['excerpt']:Input::old('p-excerpt') }}</textarea>
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- ./col -->
        <div class="col-lg-4 col-xs-12">
            <!-- Publish -->
            <div class='box box-warning'>
                <div class='box-header'>
                    <h3 class='box-title'>
                        Publish
                    </h3>
                    <div class="pull-right box-tools">
                        <button class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save Changes</button>
                    </div><!-- /. tools -->
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" id="p-status" class="form-control">
                            <option value="dr" {{ (isset($post['status']) && ($post['status'] == 'dr')) ? 'selected=selected':((\Input::old('status') == 'dr') ? 'selected=selected':''); }}>Draft</option>
                            <option value="pub" {{ (isset($post['status']) && ($post['status'] == 'pub')) ? 'selected=selected':((\Input::old('status') == 'pub') ? 'selected=selected':''); }}>Publish</option>
                        </select>
                    </div>
                    <div class="form-group{{{ $errors->first('p-publish') ? ' has-error':(isset($post['publish_date']) ? '':' hide') }}}">
                        <input type="text" id="datemask" name="p-publish" class="form-control" value="{{isset($post['publish_date']) ? Format::formats_date($post['publish_date'], 'd/m/Y H:i'):Input::old('p-publish') }}">
                        {{ $errors->first('p-publish') ? '<code>'.$errors->first('p-publish').'</code>':'' }}
                    </div>
                    <div class="form-group{{{ $errors->first('template') ? ' has-error':'' }}}">
                        <label>Template</label>
                        <select name="template" class="form-control">
                            <option></option>
                            @foreach($templates as $id => $name)
                            <option value="{{ $id }}"{{ (isset($post['template']) && ($post['template'] == $id)) ? ' selected=selected':''; }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        {{ $errors->first('template') ? '<code>'.$errors->first('template').'</code>':'' }}
                    </div>
                </div>
            </div><!-- /.box -->
            <!-- Categories -->
            <div class='box box-success'>
                <div class='box-header'>
                    <h3 class='box-title'>
                        Categories
                    </h3>
                </div><!-- /.box-header -->
                <div class='box-body pad'>
                    <div class="form-group{{{ $errors->first('categories') ? ' has-error':'' }}}">
                        <label>Select Category</label>
                        <select name="categories[]" class="form-control" multiple="multiple">
                            @foreach($categories as $category)
                            <option value="{{{ $category['id'] }}}"{{ ((!empty($post_categories) && in_array($category['id'], $post_categories)) ? ' selected="selected"':'') }}>{{{ $category['name'] }}}</option>
                            @endforeach
                        </select>
                        {{ $errors->first('categories') ? '<code>'.$errors->first('categories').'</code>':'' }}
                    </div>
                </div>
            </div><!-- /.box -->
            <!-- Feature Image -->
            <div class='box box-green'>
                <div class='box-header' id="f-image-header">
                    <h3 class='box-title'>
                        Feature Image
                    </h3>
                </div><!-- /.box-header -->
                <div class='box-body pad' id="f-image-holder">
                    {{ isset($post['feature_image']) ? '<img class="img-rounded" src="'.\Config::get('app.url') . $post['feature_image'].'">':(Input::old('f-image') ? '<img class="img-rounded" src="'.\Config::get('app.url') . Input::old('f-image').'">':'') }}
                    <div class="form-group" style="margin-top: 10px;">
                        <input type="hidden" name="f-image" id="f-image" value="{{ isset($post['feature_image']) ? $post['feature_image']:Input::old('f-image') }}">
                        <input type="hidden" name="p-id" value="{{ isset($post['id']) ? $post['id']:'' }}">
                        <button type="button" class="btn btn-primary btn-block" onclick="javascript:openFeature();">Select Image</button>
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- ./col -->
    </div><!-- /.row -->
    {{ Form::close() }}
</section><!-- /.content -->

@stop