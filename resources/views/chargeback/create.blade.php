@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">PDV</li>
    <li class="breadcrumb-item"><a href="{{ route('chargeback.index') }}">Devoluções</a></li>
    <li class="breadcrumb-item active">Nova</li>
@endsection

@section('content')
    <form method="post" action="{{ route('chargeback.store') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                <strong>Devolução</strong> <small>Nova</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="client_id">
                                Cliente <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="c-icon cil-people"></i>
                                    </div>
                                </div>
                                <input type="text"
                                       class="form-control @isInvalid(['key' => 'client_id'])"
                                       id="client_name"
                                       name="client_name"
                                       value="{{ old('client_name') }}"
                                       placeholder="Procurar cliente..."
                                >
                            </div>
                            <input type="hidden" name="client_id" value="{{ old('client_id') }}">
                            @invalidFeedback(['key' => 'client_id'])
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="product_id">
                                Produto <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="c-icon cil-cart"></i>
                                    </div>
                                </div>
                                <input type="text"
                                       class="form-control @isInvalid(['key' => 'product_id'])"
                                       id="product_name"
                                       name="product_name"
                                       value="{{ old('product_name') }}"
                                       placeholder="Procurar produto..."
                                >
                            </div>
                            <input type="hidden" name="product_id" value="{{ old('product_id') }}">
                            @invalidFeedback(['key' => 'product_id'])
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="quantity">
                                Quantidade <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @isInvalid(['key' => 'quantity'])"
                                   id="quantity"
                                   name="quantity"
                                   value="{{ old('quantity') }}"
                                   data-input-mask="numeric"
                            >
                            @invalidFeedback(['key' => 'quantity'])
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="note">
                                Observação <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @isInvalid(['key' => 'note'])" id="note" name="note"
                            >{{ old('note') }}</textarea>
                            @invalidFeedback(['key' => 'note'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="c-icon cil-check-alt"></i> Salvar
                </button>
                <a href="@urlBack(['default' => route('chargeback.index')])" class="btn btn-outline-danger btn-icon">
                    <i class="c-icon cil-x"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection

@push('script')
    <script>
        $(function() {
          /**
           * https://jqueryui.com/autocomplete/#custom-data
           */

          $('[name=client_name]').autocomplete({
            source   : window.APP_URL + '/api/autocomplete/client?has=orders',
            minLength: 2,
            select   : function(event, ui) {
              $('[name=client_name]').val(ui.item.label);
              $('[name=client_id]').val(ui.item.value);
              return false;
            }
          });

          $('[name=product_name]').autocomplete({
            source   : window.APP_URL + '/api/autocomplete/product?has=orders',
            minLength: 2,
            select   : function(event, ui) {
              $('[name=product_name]').val(ui.item.label);
              $('[name=product_id]').val(ui.item.value);
              return false;
            }
          });
        });
    </script>
@endpush