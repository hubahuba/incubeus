{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/spin.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/ace/ace.js')) }}
<script type="text/javascript">
    var clearBTN = '<button id="clearMenu" onclick="javascript:clearForm();" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
    var loadingImg = '<img id="loadingImg" src="{{ asset('packages/ngungut/nccms/img/loading-cube.gif') }}">';
    var spiner;
    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.getSession().setMode("ace/mode/php");

    editor.commands.addCommand({
        name: "save",
        bindKey: {
            win: "Ctrl-S",
            mac: "Command-s",
            sender: "editor|cli"
        },
        exec: function() {
            saveFile();
        }
    });

    function resetForm(){
        $('.nav-tabs-custom input').not('[type="checkbox"]').val('');
        $('.nav-tabs-custom input[type="checkbox"]').iCheck('uncheck');
    }

    function saveFile() {
        $mLabel = $('#tName').val();
        if($mLabel) {
            var contents = editor.getSession().getValue();
            if(contents) {
                startLoading();
                $.post("{{ \URL::current() }}", {label: $mLabel, content: contents}, function (resp) {
                    stopLoading();
                    if(resp.success == true) {
                        top.location.reload();
                    }else{
                        for(x in resp.errors) {
                            alert(resp.errors[x]);
                        }
                    }
                });
            }else{
                alert('Please Add Template Content.');
                editor.focus();
                return false;
            }
        }else{
            alert('Please Fill Template Name.');
            return false;
        }
    };

    function editTemplate(file){
        startLoading();
        $.post('{{ URL::nccms('templates/getTemplate') }}', {file:file}, function(resp){
            stopLoading();
            if(resp.success == true) {
                $('#tName').val(file);
                editor.setValue(resp.content, 1);
                if($('#clearMenu').length < 1){
                    $('#menu-form').append(clearBTN);
                }
            }else{
                for(i=0;i<resp.errors.length;i++) {
                    alert(resp.errors[i]);
                }
            }
        });
    };

    function removeTemplate(file){
        var ans = confirm('Delete this template permanently?');
        if(ans) {
            startLoading();
            $.post('{{ URL::nccms('template/delTemplate') }}', {file: file}, function (resp) {
                stopLoading();
                if (resp.success == true) {
                    top.location.reload();
                } else {
                    for (i = 0; i < resp.errors.length; i++) {
                        alert(resp.errors[i]);
                    }
                }
            });
        }
    };

    function clearForm(){
        editor.setValue('');
        $('#tName').val('');
        $('#clearMenu').remove();
    };

    function startLoading(){
        if($('#loadingImg').length < 1){
            $('#clearMenu').remove();
            $('#menu-form').append(loadingImg);
            $('#tName').prop('disabled', true);
            editor.setReadOnly(true);
        }
    };

    function stopLoading(){
        $('#loadingImg').remove();
        editor.setReadOnly(false);
        $('#tName').prop('disabled', false);
    };

    function addPartial(){
        $('.templates:checkbox:checked').each(function(){
            $value = $(this).val();
            $part = $value.split('.');
            $partial = '\{\{ \\Nccms::partial(\''+$part[0]+'\') \}\}';
            editor.insert($partial);
        });
        resetForm();
    };

    function addMenu(){
        $('.menus:checkbox:checked').each(function(){
            $value = $(this).val();
            $part = $value.split('.');
            $menu = '\{\{ \\Nccms::menu(\''+$part[0]+'\') \}\}';
            editor.insert($menu);
        });
        resetForm();
    };

    function openFeature(){
        window.open("{{ URL::nccms('media/feature-image') }}", "_blank", "toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=100, width=1136, height=500");
    };

    function setFeature($url){
        $img = '<img src="\{\{ asset(\''+$url+'\') \}\}">';
        editor.insert($img);
    };

    function addComponent(that){
        selVal = '';
        handler = $(that).attr('data-handler');
        action = $(that).attr('data-action');
        option = $(that).attr('data-option');
        if(option == 'true'){
            select = $(that).parent().find('select').first();
            selVal = select.val();
        }
        $component = '\{\{ \\App::make(\''+handler+'\')->'+action+'('+selVal+') \}\}';
        editor.insert($component);
    }
</script>