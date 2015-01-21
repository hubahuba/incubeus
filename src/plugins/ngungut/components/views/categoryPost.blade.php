@if (!empty($newPosts))
    @foreach ($newPosts as $post)
        <div class="post-list">
            <div class="post-list-title">
                <h4>{{ $post['title'] }}</h4>
                <p><small>{{ Format::formats_date($post['publish_date']) }}. posted on: <a href="javascript:;">{{ $post->ofCategory[0]->category->name }}</a></small></p>
                <hr>
            </div>
            <div class="post-list-excerpt">
                <p>{{ $post['excerpt'] }}</p>
            </div>
            <div class="post-list-button">
                <a href="{{ \URL::to($post['slug']) }}" class="btn btn-primary text-uppercase">
                    Read More &nbsp;<span class="wi-angle-circle-right"></span>
                </a>
            </div>
        </div>
    @endforeach
@else
<div class="post-list">
    <div class="post-list-title">
        <h4>No Post Found</h4>
        <p><small>Sorry We Can't find any post this time</small></p>
        <hr>
    </div>
</div>
@endif