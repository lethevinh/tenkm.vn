<div class="section-title">
    <h2 class="title">{{trans('site.recommended')}}</h2>
    <a class="btn-view-all" href="{{route('product.index')}}">{{trans('site.view_all')}}</a>
</div>
<div class="row">
    @foreach($products as $product)
    <div class="col-lg-3 col-sm-6">
        @include('item.product')
    </div>
   @endforeach
</div>
