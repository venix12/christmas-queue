@if($paginator->lastPage() > 1)
    <nav class="paginator">
        <ul class="paginator__background">
            @for($page = 1; $page <= $paginator->lastPage(); $page++)
                <li class="paginator__page">
                    @if($paginator->currentPage() === $page)
                        <span class="paginator__link paginator__link--current">{{$page}}</span>
                    @else
                        <a class="paginator__link" href="{{ $paginator->url($page) }}">{{$page}}</a>
                    @endif
                </li>
            @endfor
        </ul>
    </nav>
@endif
