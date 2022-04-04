@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item active">Gráficos</li>
@endsection

@section('content')
    <div class="row">

        @foreach ($charts as $id => $chart)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div id="{{ $id }}">
                            Aguarde...
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

@push('script')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript">
      window.CHARTS = JSON.parse('@json($charts)');
    </script>
    <script src="{{ asset('/dist/graph.js') }}"></script>
@endpush
