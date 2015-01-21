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
        $mLabel = $('#mName').val();
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
                alert('Please Add Menu Content.');
                editor.focus();
                return false;
            }
        }else{
            alert('Please Fill Menu Name.');
            return false;
        }
    };

    function editMenu(file){
        startLoading();
        $.post('{{ URL::nccms('menus/getMenu') }}', {file:file}, function(resp){
            stopLoading();
            if(resp.success == true) {
                $('#mName').val(file);
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

    function removeMenu(file){
        var ans = confirm('Delete this menu permanently?');
        if(ans) {
            startLoading();
            $.post('{{ URL::nccms('menus/delMenu') }}', {file: file}, function (resp) {
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
        $('#mName').val('');
        $('#clearMenu').remove();
    };

    function startLoading(){
        if($('#loadingImg').length < 1){
            $('#clearMenu').remove();
            $('#menu-form').append(loadingImg);
            $('#mName').prop('disabled', true);
            editor.setReadOnly(true);
        }
    };

    function stopLoading(){
        $('#loadingImg').remove();
        editor.setReadOnly(false);
        $('#mName').prop('disabled', false);
    };

    function addPost(){
        $('.posts:checkbox:checked').each(function(){
            $label = $(this).attr('name');
            $value = $(this).val();
            $url = '<a href="\{\{ \\URL::post('+$value+') \}\}">'+$label+'</a>';
            editor.insert($url);
        });
        resetForm();
    };

    function addPage(){
        $('.pages:checkbox:checked').each(function(){
            $label = $(this).attr('name');
            $value = $(this).val();
            $url = '<a href="\{\{ \URL::post('+$value+') \}\}">'+$label+'</a>';
            editor.insert($url);
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
</script>