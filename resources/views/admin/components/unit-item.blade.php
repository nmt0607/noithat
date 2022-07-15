@props(['value','key','editId'])

@if($key!=$value->id)
    <option value="{{$value->id}}">
        {!!getTreeUnit("&#xf07b; ".$value->name,$value->depth)!!}
        @foreach($value->children as $keyChild => $subchild)
            @if($key!=$subchild->id)
                <x-unit-item :value="$subchild" :key="$key"/>
            @endif
        @endforeach
    </option>
@endif