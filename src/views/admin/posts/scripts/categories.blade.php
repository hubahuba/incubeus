{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-ui-1.10.3.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/datatables/jquery.dataTables.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/datatables/dataTables.bootstrap.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
<script type="text/javascript">
    var btnCancel = '<button type="button" class="btn btn-danger" id="cancelIt" onclick="javascript:resetForm(\'cForm\')">Cancel</button>'
    function resetForm(form) {
        $form = $('#'+form);
        $form.find('input:text, input:password, input:hidden, textarea').val('');
        $('#cancelIt').remove();
    }

    $(function() {
        $('#cList').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": false,
            "bSort": true,
            "bAutoWidth": true
        });

        $('.cEditor').click(function(){
            var id = $(this).attr('data-id');
            var name = $(this).attr('data-name');
            var desc = $(this).attr('data-desc');
            var icon = $(this).attr('data-icon');
            $('input[name="cName"]').val(name);
            $('textarea[name="cDescription"]').val(desc);
            $('input[name="cIcon"]').val(icon);
            $('input[name="cID"]').val(id);
            if($('#cancelIt').length < 1){
                $('.box-footer').append(btnCancel);
            }
        });
    });
</script>