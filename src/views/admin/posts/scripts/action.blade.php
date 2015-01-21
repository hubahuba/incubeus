{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-ui-1.10.3.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/iCheck/icheck.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/ckeditor/ckeditor.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/jquery.datetimepicker.js')) }}
<script type="text/javascript">
    var mURL = '{{ \Config::get('app.url') }}';
    function openFeature(){
        window.open("{{ URL::nccms('media/feature-image') }}", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=100, width=1136, height=500");
    }

    function setFeature($url){
        $('#f-image').val($url);
        $img = '<img class="img-rounded" src="'+mURL+$url+'">';
        $rembtn = '<div class="box-tools pull-right"><button class="btn btn-danger btn-xs" onclick="javascript:remFeature();"><i class="fa fa-times"></i></button></div>'
        $old = $('#f-image-holder').find('.img-rounded').first();
        if($old[0]){
            $old[0].remove();
        }
        $checkbtn = $('#f-image-header').find('.box-tools').first();
        if(!$checkbtn[0]){
            $('#f-image-header').append($rembtn);
        }
        $('#f-image-holder').prepend($img);
    }

    function remFeature(){
        $old = $('#f-image-holder').find('.img-rounded').first();
        if($old[0]){
            $('#f-image').val('');
            $old[0].remove();
            $('#f-image-header').find('.box-tools').first().remove();
        }
    }

    function slug(input)
    {
        $('#p-slug').val(
                input.toLowerCase() // Camel case is bad
                    .replace(/[^a-z0-9\s]+/g, ' ') // Exchange invalid chars
                    .replace(/^\s\s*/, '') // Trim start
                    .replace(/\s\s*$/, '') // Trim end
                    .replace(/[\s]+/g, '-')
        );
    }

    $(function() {
        CKEDITOR.replace('editor', {
            filebrowserBrowseUrl: '{{ URL::nccms('media/ckeditor/libraries') }}',
            filebrowserImageBrowseUrl : '{{ URL::nccms('media/ckeditor/image') }}',
        });
        //Datemask dd/mm/yyyy
        $('#datemask').datetimepicker({
            mask:true,
            format: 'd/m/Y H:i'
        });

        $('#p-status').on('change', function(){
            if($(this).val() == 'pub'){
                $("#datemask").parent().removeClass('hide');
            }else{
                $("#datemask").parent().addClass('hide');
            }
        });
    });
</script>