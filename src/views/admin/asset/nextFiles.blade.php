@if($files['base'] == false)
<tr>
    <td>
        <a style="display: block;" onclick="javascript:changeFolder('..');" href="javascript:;">..</a>
    </td>
</tr>
@endif
@if(!empty($files))
    @foreach($files['dirs'] as $dir)
<tr>
    <td>
        <a style="display: block;" onclick="javascript:changeFolder('{{ $dir }}');" href="javascript:;">{{ $dir }}</a>
    </td>
</tr>
    @endforeach
    @foreach($files['files'] as $file)
<tr>
    <td>
        @if( in_array(\File::extension($file), \Config::get('nccms::ace')))
        <div class="btn btn-block btn-social btn-default">
            <i class="fa fa-times" onclick="javascript:removeAsset('{{ $file }}');"></i>
            <a href="javascript:;" style="display: block" onclick="editAsset('{{ $file }}')">{{ $file }}</a>
        </div>
        @else
            {{ $file }}
        @endif
    </td>
</tr>
    @endforeach
@else
<tr>
    <td>
        No Files/Folder Found.
    </td>
</tr>
@endif