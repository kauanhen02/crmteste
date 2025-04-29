<option value="">{{$texto}}</option>
@foreach ($itens as $item)
    <option value="{{$item->id}}" @if (old($select, $original->$select ?? '') == $item->id) selected @endif>{{$item->$campo}}</option>
@endforeach