{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-2.1.1.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/jquery-ui-1.10.3.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/bootstrap.min.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/datatables/jquery.dataTables.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/plugins/datatables/dataTables.bootstrap.js')) }}
{{ HTML::script(asset('packages/ngungut/nccms/js/AdminLTE/app.js')) }}
<script type="text/javascript">
    $(function() {
        $('#pList').dataTable({
            "bPaginate": true,
            "bLengthChange": false,
            "bFilter": true,
            "bSort": true,
            "bAutoWidth": true
        });
    });
</script>