@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 24px; flex-wrap: wrap;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.2); color:rgba(255, 255, 255, 0.4); font-size:0.9rem; cursor:not-allowed; background: transparent;">&laquo;</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.9rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">&laquo;</a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; color:rgba(255, 255, 255, 0.5); font-size:0.9rem;">…</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; background:#1d4ed8; color:#ffffff; font-weight:700; font-size:0.95rem; border:1px solid #1d4ed8; box-shadow: 0 4px 6px -1px rgba(29, 78, 216, 0.5);">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.95rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.3); color:#3b82f6; font-size:0.9rem; text-decoration:none; transition:all 0.2s; background: transparent;" onmouseover="this.style.background='rgba(59, 130, 246, 0.1)';this.style.borderColor='#3b82f6';" onmouseout="this.style.background='transparent';this.style.borderColor='rgba(255, 255, 255, 0.3)';">&raquo;</a>
        @else
            <span style="display:inline-flex; align-items:center; justify-content:center; width:38px; height:38px; border-radius:8px; border:1px solid rgba(255, 255, 255, 0.2); color:rgba(255, 255, 255, 0.4); font-size:0.9rem; cursor:not-allowed; background: transparent;">&raquo;</span>
        @endif

    </div>
@endif
