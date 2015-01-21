{{ \Nccms::partial('header') }}
<div class="col-sm-8 post-detail-container">
    <div class="post-detail">
        <div class="post-detail-title">
            <h4>{{ \App::make('\Ngungut\Components\Controller\Components')->showTitle() }}</h4>
            <p><small>{{ \App::make('\Ngungut\Components\Controller\Components')->showDate() }}.</small></p>
            <hr>
        </div>
        <div class="post-detail-image">
            {{ \App::make('\Ngungut\Components\Controller\Components')->showImage() }}
        </div>
        <div class="post-detail-content">
            {{ \App::make('\Ngungut\Components\Controller\Components')->showContent() }}
        </div>
    </div>
</div>
{{ \Nccms::menu('sidebar') }}
{{ \Nccms::partial('footer') }}