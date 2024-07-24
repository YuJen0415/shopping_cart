<nav>
    <ul class="pagination">
        {{-- 第一頁連結 --}}
        @if ($paginator->onFirstPage())
            <li class="disabled" aria-disabled="true"><span>&laquo;</span></li>
        @else
            <li><a href="{{ $paginator->url(1) }}" rel="prev">&laquo;</a></li>
        @endif

        {{-- 頁碼 --}}
        @php
            $start = 1;
            $end = max($paginator->lastPage(), 1);  // 確保至少顯示一頁
        @endphp

        @for ($i = $start; $i <= $end; $i++)
            @if ($i == $paginator->currentPage())
                <li class="active" aria-current="page"><span>{{ $i }}</span></li>
            @else
                <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
            @endif
        @endfor

        {{-- 最後一頁連結 --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->url($paginator->lastPage()) }}" rel="next">&raquo;</a></li>
        @else
            <li class="disabled" aria-disabled="true"><span>&raquo;</span></li>
        @endif
    </ul>
</nav>