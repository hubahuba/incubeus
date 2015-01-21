{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/spin.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/ace/ace.js')) }}
<script type="text/javascript">
    var clearBTN = '<button id="clearPartial" onclick="javascript:clearForm();" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
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
        $pLabel = $('#pName').val();
        if($pLabel) {
            var contents = editor.getSession().getValue();
            if(contents) {
                startLoading();
                $.post("{{ \URL::current() }}", {label: $pLabel, content: contents}, function (resp) {
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
                alert('Please Add Partial Content.');
                editor.focus();
                return false;
            }
        }else{
            alert('Please Fill Partial Name.');
            $('#pName').focus();
            return false;
        }
    };

    function editPartial(file){
        startLoading();
        $.post('{{ URL::nccms('partials/getPartial') }}', {file:file}, function(resp){
            stopLoading();
            if(resp.success == true) {
                $('#pName').val(file);
                editor.setValue(resp.content, 1);
                if($('#clearPartial').length < 1){
                    $('#partial-form').append(clearBTN);
                }
            }else{
                for(i=0;i<resp.errors.length;i++) {
                    alert(resp.errors[i]);
                }
            }
        });
    };

    function removePartial(file){
        var ans = confirm('Delete this partial permanently?');
        if(ans) {
            startLoading();
            $.post('{{ URL::nccms('partials/delPartial') }}', {file: file}, function (resp) {
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
        $('#pName').val('');
        $('#clearPartial').remove();
    };

    function startLoading(){
        if($('#loadingImg').length < 1){
            $('#clearPartial').remove();
            $('#partial-form').append(loadingImg);
            $('#pName').prop('disabled', true);
            editor.setReadOnly(true);
        }
    };

    function stopLoading(){
        $('#loadingImg').remove();
        editor.setReadOnly(false);
        $('#pName').prop('disabled', false);
    };

    function addCss(){
        $('.styles:checkbox:checked').each(function(){
            $value = $(this).val();
            $url = '\{\{ HTML::style(asset(\''+$value+'\')) \}\}';
            editor.insert($url);
        });
        resetForm();
    };

    function addJS(){
        $('.script:checkbox:checked').each(function(){
            $value = $(this).val();
            $url = '\{\{ HTML::script(asset(\''+$value+'\')) \}\}';
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