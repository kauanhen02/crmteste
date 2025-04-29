<option value="">{{$texto}}</option>
@foreach ($itens as $item)
    <option value="{{$item->id}}" >{{$item->$campo}}</option>
@endforeach