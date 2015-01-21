{{ \Nccms::partial('header') }}
<div class="col-sm-8 post-detail-container">
    {{ \App::make('\Ngungut\Components\Controller\Components')->recentPost(1) }}
</div>
{{ \Nccms::menu('sidebar') }}
{{ \Nccms::partial('footer') }}