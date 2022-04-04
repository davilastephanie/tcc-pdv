<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <strong>Venda #{{ $order->id_show }}</strong>
            </h5>
            <button type="button" class="close" data-dismiss="modal">
                <span>&times;</span>
            </button>
        </div>
        <div class="modal-body">

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Data</label>
                        <input type="text" class="form-control" value="{{ $order->created_at_show }}" readonly>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="form-group">
                        <label>Cliente</label>
                        <input type="text" class="form-control" value="{{ $order->client->name }} - {{ $order->client->cpf }}" readonly>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Total</label>
                        <input type="text" class="form-control" value="R$ {{ $order->total_show }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Forma de pagamento</label>
                        <input type="text" class="form-control" value="{{ $order->payment_type_show }}" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control" value="{{ $order->status_show }}" readonly>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label>Vendedor</label>
                        <input type="text" class="form-control" value="{{ $order->user->name }}" readonly>
                    </div>
                </div>
            </div>

            <hr>

            <h4>Produtos</h4>

            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped">
                    <thead class="bg-dark">
                    <tr class="text-nowrap">
                        <td>Produto</td>
                        <td>Valor</td>
                        <td>Qtde</td>
                        <td>Total</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($order->products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td width="120">R$ {{ $product->pivot_price_show }}</td>
                            <td width="100">{{ $product->pivot->quantity }}</td>
                            <td width="150">R$ {{ $product->pivot_total_show }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        </div>
    </div>
</div>