<div class="properties-area pd-top-90">
    <div class="container">
        <div class="section-title">
            <h2 class="title">Popular Property</h2>
            <a class="btn-view-all" href="#">View All</a>
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
