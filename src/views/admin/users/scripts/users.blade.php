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
            var firstname = $(this).attr('data-firstname');
            var lastname = $(this).attr('data-lastname');
            var nickname = $(this).attr('data-nickname');
            
            $('input[name="cUserName"]').val(name);
            $('input[name="cFirstName"]').val(firstname);
            $('input[name="cLastName"]').val(lastname);
            $('input[name="cNickname"]').val(nickname);

            $('input[name="cID"]').val(id);
            if($('#cancelIt').length < 1){
                $('.box-footer').append(btnCancel);
            }
        });
    });
</script>