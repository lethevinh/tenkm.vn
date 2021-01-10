<div class="properties-area pd-top-90">
    <div class="container">
        <div class="section-title">
            <h2 class="title">{{tran('site.properties_for_sell')}}</h2>
            <a class="btn-view-all" href="http://tenkm.vn/properties-for-sells.html">{{tran('site.view_all')}}</a>
        </div>
        <div class="row">
            @foreach($products as $product)
            <div class="col-lg-3 col-sm-6">
                @include('item.product-feature')
            </div>
            @endforeach
        </div>
    </div>
</div>
