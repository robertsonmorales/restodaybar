<label for="pageSize" class="mb-0 mr-2 font-size-sm">Show</label>
<select name="pageSize" id="pageSize" class="custom-select mr-2 font-size-sm">
    @for($i=0;$i < count($pagesize['options']); $i++)
    <option value="{{ $pagesize['options'][$i] }}">{{ $pagesize['options'][$i] }}</option>
    @endfor
</select>
<label for="pageSize" class="mb-0 font-size-sm">entries</label>