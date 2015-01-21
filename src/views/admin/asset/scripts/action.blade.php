{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/ace/ace.js')) }}
<script type="text/javascript">
    var clearBTN = '<button id="clearPartial" onclick="javascript:clearForm();" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></button>';
    var loadingImg = '<img id="loadingImg" src="{{ asset('packages/ngungut/nccms/img/loading-cube.gif') }}">';
    var spiner;
    var editor = ace.edit("editor");
    var xhr = null;
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

    function saveFile() {
        if(xhr) xhr.abort();
        $pLabel = $('#pName').val();
        if($pLabel) {
            var contents = editor.getSession().getValue();
            if(contents) {
                startLoading();
                xhr = $.ajax({
                    type: 'post',
                    dataType: 'json',
                    data: {label: $pLabel, content: contents},
                    url: '{{ \URL::current() }}',
                    success: function(resp) {
                        if(resp.success == true) {
                            getCurrent();
                        }else{
                            for(x in resp.errors) {
                                alert(resp.errors[x]);
                            }
                        }
                        stopLoading();
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

    function editAsset(file){
        if(xhr) xhr.abort();
        startLoading();
        xhr = $.ajax({
            type: 'post',
            dataType: 'json',
            data: {file: file},
            url: '{{ URL::nccms('assets/getFile') }}',
            success: function(resp) {
                if(resp.success == true) {
                    editor.getSession().setMode("ace/mode/"+resp.ext);
                    $('#pName').val(file);
                    editor.setValue(resp.content, 1);
                    if($('#clearPartial').length < 1){
                        $('#partial-form').append(clearBTN);
                    }
                }else{
                    alert(resp.errors);
                }
                stopLoading();
            }
        });
    };

    function publishAsset(){
        if(xhr) xhr.abort();
        startLoading();
        xhr = $.ajax({
            type: 'get',
            url: '{{ URL::nccms('assets/publish') }}',
            success: function(resp) {
                stopLoading();
                if(resp.success == true) {
                    getCurrent();
                }else{
                    alert(resp.errors);
                }
            }
        });
    };

    function removeAsset(file){
        if(xhr) xhr.abort();
        var ans = confirm('Delete this file permanently?');
        if(ans) {
            startLoading();
            xhr = $.ajax({
                type: 'post',
                dataType: 'json',
                data: {file: file},
                url: '{{ URL::nccms('assets/delFile') }}',
                success: function(resp) {
                    if(resp.success == true) {
                        getCurrent();
                    }else{
                        alert(resp.errors);
                    }
                    stopLoading();
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

    function changeFolder(dir){
        if(xhr) xhr.abort();
        startLoading();
        clearForm();
        xhr = $.ajax({
            type: 'post',
            dataType: 'json',
            data: {folder:dir},
            url: '{{ URL::nccms('assets/change') }}',
            success: function(resp) {
                if(resp.success == true) {
                    $('#ff-holder').html(resp.next);
                }else{
                    alert(resp.errors);
                }
                stopLoading();
            }
        });
    };

    function getCurrent(){
        if(xhr) xhr.abort();
        xhr = $.ajax({
            type: 'post',
            dataType: 'json',
            url: '{{ URL::nccms('assets/current') }}',
            success: function(resp) {
                if(resp.success == true) {
                    $('#ff-holder').html(resp.next);
                    clearForm();
                }else{
                    alert(resp.errors);
                }
                stopLoading();
            }
        });
    };
</script>