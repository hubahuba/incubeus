<section class="image-choose">
    <div class="box box-solid box-primary" style="margin-bottom: 0; display: none;">
        <div class="box-header">
            <h3 class="box-title">Image Size Selection</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-primary btn-sm" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div id="thumb-choose" class="text-center">
                <img id="choose-preview" class="img-rounded" src="" style="vertical-align: top; width: 100px;">
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="radio">
                        <label>
                            <input type="radio" style="margin-left: 0;" id="radio-thumbnail" name="selected-image" value="" class="simple option-image"> <b>Thumbnail Size</b> : <span id="thum-sz"></span>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" style="margin-left: 0;" id="radio-medium" name="selected-image" value="" class="simple option-image"> <b>Medium Size</b> : <span id="med-sz"></span>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" style="margin-left: 0;" id="radio-large" name="selected-image" value="" class="simple option-image"> <b>Original Size</b> : <span id="lg-sz"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary" onclick="javascript:selImage(this);">Select</button>
        </div>
    </div>
</section>

{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-ui-1.10.3.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/iCheck/icheck.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
<script>
    function setImage(url){
        window.opener.CKEDITOR.tools.callFunction(<?= Session::get('FuncNum')?>,url);
        window.close();
    }

    function selImage(that){
        $parent = $(that).parents('.box').first();
        $url = $parent.find('input[name="selected-image"]:checked').val();
        if($url){
            window.opener.CKEDITOR.tools.callFunction(<?= Session::get('FuncNum')?>, $url);
            window.close();
        }
    }

    function showOption(that){
        var thumbSize = '', medSize = '', lgSize = '';
        $thumbnail = $(that).attr('data-thumbnail');
        if($thumbnail){
            $('#radio-thumbnail').val($thumbnail);
            $('#choose-preview').attr('src', $thumbnail);
            var $tmpThumb = new Image();
            $tmpThumb.src = $thumbnail;
            $($tmpThumb).on('load',function(){
                thumbWidth = $tmpThumb.width;
                thumbHeight = $tmpThumb.height;
                thumbSize = thumbWidth + 'x' + thumbHeight;
                $('#thum-sz').html(thumbSize);
            });
        }
        $medium = $(that).attr('data-medium');
        if($medium){
            $('#radio-medium').val($medium);
            var $tmpMed = new Image();
            $tmpMed.src = $medium;
            $($tmpMed).on('load',function(){
                medWidth = $tmpMed.width;
                medHeight = $tmpMed.height;
                medSize = medWidth + 'x' + medHeight;
             $('#med-sz').html(medSize);
            });
        }
        $large = $(that).attr('data-origin');
        if($large){
            $('#radio-large').val($large);
            var $tmpLg = new Image();
            $tmpLg.src = $large;
            $($tmpLg).on('load',function(){
                lgWidth = $tmpLg.width;
                lgHeight = $tmpLg.height;
                lgSize = lgWidth + 'x' + lgHeight;
                $('#lg-sz').html(lgSize);
            });
        }

        $chooser = $('.image-choose').find('.box').first();
        $chooser.slideDown();
    }
</script>