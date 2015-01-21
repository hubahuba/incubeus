{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-ui-1.10.3.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/iCheck/icheck.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
<!--uploader-->
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/fileupload/jquery.iframe-transport.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/fileupload/jquery.fileupload.js')) }}
<script>
    var mainURL = '{{ \Config::get('app.url') }}';
$(function () {
    $('#fileupload').fileupload({
        autoUpload: true,
        url: '{{ URL::current() }}',
        progressall: function (e, data) {
            $('.progress').removeClass('hide');
            $('.progress-bar').removeClass('progress-bar-green');
            $('.progress-bar').addClass('progress-bar-yellow');
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('.progress .progress-bar').css(
                'width',
                progress + '%'
            );
        },
        done: function (e, data) {
            $('.progress-bar').addClass('progress-bar-green');
            $('.progress-bar').removeClass('progress-bar-yellow');
            var json = $.parseJSON(data.result);
            $.each(json.media, function (index, file) {
                if(file.error){
                    alert(file.error);
                }else{
                    if(file.type.indexOf("image") > -1){
                        var preview = '<p>';
                        preview += '<img src="'+mainURL+file.thumbnailUrl+'" /> ';
                        preview += file.name;
                        preview += '</p>';
                        $(preview).appendTo('#uploadPreview');
                    }else{
                        var preview = '<p>';
                        preview += file.name;
                        preview += '</p>';
                        $(preview).appendTo('#uploadPreview');
                    }
                }
            });
            setTimeout(function(){
                $('.progress').addClass('hide');
            }, 5000);
        },
        fail: function(e, data){
            alert('Upload Failed.');
        }
    });
});
</script>