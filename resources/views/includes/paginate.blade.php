<div class="row">
    <div class="col-12 col-md-6">
        {{ $items->appends(request()->except('page'))->links() }}
    </div>
    <div class="col-12 col-md-6 text-right">
        Exibindo {{ $items->count() }} {{ $items->count() == 1 ? 'registro' : 'registros' }}
        @if ($items->lastPage() > 1)
            | página <strong>{{ $items->currentPage() }}</strong> / {{ $items->lastPage() }}
            | total {{ $items->total() }} {{ $items->total() == 1 ? 'registro' : 'registros' }}
        @endif
    </div>
</div>