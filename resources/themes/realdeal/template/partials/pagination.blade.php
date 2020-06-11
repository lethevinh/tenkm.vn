<nav aria-label="...">
    <ul class="pagination">
        <li class="disabled"><a href="#" aria-label="Previous"><i
                    class="ion-android-arrow-back"></i></a></li>
        <li class="active"><a href="#">{{$courses->currentPage()}} <span class="sr-only">(current)</span></a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">...</a></li>
        <li><a href="#">10</a></li>
        <li>
            <a href="#" aria-label="Next">
                <i class="ion-android-arrow-forward"></i>
            </a>
        </li>
    </ul>
</nav>
