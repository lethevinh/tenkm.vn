@foreach($posts as $post)
    @includeFirst(['item.'.$template,'item.default'])
@endforeach
