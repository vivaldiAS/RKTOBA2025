@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" style="margin-top:10px;">
        <div align="center" id="more">
            @if ($paginator->hasMorePages())
                <button id="more_button" class="btns btns-outline" style="padding:8px 12px;">
                    Muat Lebih Banyak 
                </button> 
            @else
                <span class="font-medium text-gray-700 bg-white">
                    Tidak Ada Produk Lain
                </span>
            @endif
        </div>
    </nav>
@else
    @if($paginator->count() > 0)
    <nav role="navigation" style="margin-top:10px;">
        <div align="center">
            <span class="font-medium text-gray-700 bg-white">
                Tidak Ada Produk Lain
            </span>
        </div>
    </nav>
    @endif
@endif

<!-- Usability Testing Maze -->
<script src="{{ URL::asset('asset/js/maze.js') }}"></script>