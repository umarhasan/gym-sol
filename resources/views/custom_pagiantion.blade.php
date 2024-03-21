
<ul class="pagination">
    @if ($paginator->onFirstPage())
        <li class="paginate_button page-item previous disabled" id="order-listing_previous"><a href="#"
                aria-controls="order-listing" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
        </li>
    @else
    <li class="paginate_button page-item previous " id="order-listing_previous"><a href="{{ $paginator->withQueryString()->previousPageUrl() }}"
            aria-controls="order-listing" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
    @endif

    @foreach ($elements as $element)
        
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="paginate_button page-item active"><a href="#" aria-controls="order-listing"
                            data-dt-idx="1" tabindex="0" class="page-link">{{ $page }}</a></li>
                @else
                    <li class="paginate_button page-item"><a href="{{ $url }}" aria-controls="order-listing"
                            data-dt-idx="1" tabindex="0" class="page-link">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    @if ($paginator->hasMorePages())
        <li class="paginate_button page-item next" id="order-listing_next"><a
                href="{{ $paginator->withQueryString()->nextPageUrl() }}" aria-controls="order-listing" data-dt-idx="2"
                tabindex="0" class="page-link">Next</a></li>
    @else
        <li class="paginate_button page-item next disabled" id="order-listing_next"><a href="#"
                aria-controls="order-listing" data-dt-idx="2" tabindex="0" class="page-link">Next</a></li>
    @endif
</ul>
