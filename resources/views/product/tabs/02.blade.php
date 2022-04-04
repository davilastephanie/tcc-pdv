<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <h4 class="mb-0 pt-1" id="countStock">
                Estoque atual: <strong>{{ $product->stock }}</strong>
            </h4>
        </div>
    </div>
    <div class="col-12 col-md-6 text-right">
        <div class="form-group">
            <button type="button"
                    class="btn btn-success btn-icon"
                    data-toggle="modal"
                    data-target="#modalStock"
            >
                <i class="c-icon cil-balance-scale"></i> Adicionar movimentação
            </button>
        </div>
    </div>
</div>

<div class="table-responsive-sm" id="tableStock">
    <table class="table table-bordered table-striped table-records">
        <thead class="bg-dark">
        <tr class="text-nowrap">
            <td width="150">Data</td>
            <td width="150">Ação</td>
            <td width="150">Quantidade</td>
            <td>Descrição</td>
            <td>Usuário</td>
        </tr>
        </thead>
        <tbody>
        @foreach ($product->stocks()->orderBy('created_at', 'desc')->get() as $stock)
            <tr>
                <td>{{ $stock->created_at_show }}</td>
                <td>{{ $stock->action_show }}</td>
                <td>{{ $stock->quantity }}</td>
                <td>{{ $stock->description }}</td>
                <td>{{ $stock->user->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

@push('modal')
    <form method="post" action="{{ route('product.stock', $product->id) }}" id="formStock">
        @csrf

        <div class="modal" tabindex="-1" id="modalStock">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Movimentação de estoque</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stock_action">
                                Ação <span class="text-danger">*</span>
                            </label>
                            <select class="form-control"
                                    id="stock_action"
                                    name="stock_action"
                            >
                                @selectOption(['items' => $actions])
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stock_action">
                                Quantidade <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="stock_quantity"
                                   name="stock_quantity"
                                   data-input-mask="numeric"
                                   maxlength="6"
                            >
                        </div>
                        <div class="form-group">
                            <label for="stock_description">
                                Descrição
                            </label>
                            <input type="text"
                                   class="form-control"
                                   id="stock_description"
                                   name="stock_description"
                            >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary js-confirm-payment">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endpush

@push('script')
    <script>
      $(function() {
        $('#modalStock').on('hidden.bs.modal', function() {
          $(this).find('select').val(null).trigger('change');
          $(this).find('input').val('');
        });

        $('#formStock').on('submit', function(event) {
          event.preventDefault();

          $.post($(this).attr('action'), $(this).serialize()).always(function(data) {
            var response = data.responseJSON || data;

            if (typeof response !== 'object') {
              return $.notification('error-1', 'error');
            }

            if (response.status === 'success') {
              $.loadHtml(['#tableStock', '#countStock']);
              $('#modalStock [data-dismiss]').trigger('click');
              $.notification(response.message, 'success');
              return false;
            }

            $.notification(response.message || 'error-1', 'error');
          });
        });
      });
    </script>
@endpush