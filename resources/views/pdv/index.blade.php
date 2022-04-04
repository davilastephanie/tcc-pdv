@extends('layouts.app')

@section('bodyClass', 'c-app')

@section('breadcrumb')
    <li class="breadcrumb-item active">PDV</li>
@endsection

@section('content')
    <div class="row page-pdv">
        <div class="col-left col-12 col-xl-6">
            <div class="card card-pdv">
                <div class="card-body">
                    <form method="post"
                          action="{{ route('pdv.store') }}"
                          id="formPayment"
                          class="h-100 w-100"
                    >
                        @csrf
                        <input type="hidden" name="total">
                        <input type="hidden" name="status">
                        <input type="hidden" name="payment_type">

                        <div class="position-relative h-100 w-100">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-people"></i>
                                        </div>
                                    </div>
                                    <input type="text"
                                           class="form-control"
                                           id="client"
                                           placeholder="Selecionar cliente"
                                    >
                                </div>
                                <input type="hidden" name="client_id">
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-barcode"></i>
                                        </div>
                                    </div>
                                    <input type="text"
                                           class="form-control"
                                           id="product"
                                           placeholder="Procure o produto pelo código de barras"
                                           data-input-mask="numeric"
                                    >
                                </div>
                            </div>
                            <div class="form-group div-table-products">
                                <div class="table-responsive-sm">
                                    <table class="table table-sm table-bordered table-striped table-records">
                                        <thead class="bg-dark">
                                        <tr class="text-nowrap text-center">
                                            <th>Produto</th>
                                            <th style="width: 100px;">Preço</th>
                                            <th style="width: 70px;">Qtde</th>
                                            <th style="width: 100px;">Subtotal</th>
                                            <th style="width: 40px;"></th>
                                        </tr>
                                        </thead>
                                        <tbody id="listPaymentItems">
                                        <tr id="emptyPaymentItems">
                                            <td colspan="5">
                                                <strong>Nenhum produto adicionado.</strong>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group mb-0 div-table-total">
                                <table class="table table-sm table-bordered font-weight-bold table-total">
                                    <tr class="bg-dark">
                                        <td class="text-right" style="width: 25%;">Total de itens:</td>
                                        <td class="text-right" style="width: 25%;">
                                            <strong id="countPaymentItems">0</strong>
                                        </td>
                                        <td class="text-right" style="width: 25%;" colspan="3">Total a pagar:</td>
                                        <td class="text-right" style="width: 25%;">
                                            <strong id="totalPaymentItems">R$ 0,00</strong>
                                        </td>
                                    </tr>
                                </table>

                                <ul class="list-buttons">
                                    <li>
                                        <button type="button"
                                                class="btn btn-danger btn-icon js-checkout"
                                                data-status="cancel"
                                        >
                                            <i class="c-icon cil-ban"></i> Cancelar
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                                class="btn btn-warning btn-icon js-checkout"
                                                data-status="budget"
                                        >
                                            <i class="c-icon cil-paperclip"></i> Orçamento
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button"
                                                class="btn btn-success btn-icon js-checkout"
                                                data-status="pay"
                                        >
                                            <i class="c-icon cil-dollar"></i> Pagar
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-right col-12 col-xl-6">
            <div class="card card-pdv">
                <div class="card-body">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="c-icon cil-search"></i>
                                </div>
                            </div>
                            <input type="text"
                                   class="form-control js-input-search"
                                   id="inputSearch"
                                   placeholder="Procure pelo nome do produto"
                            >
                        </div>
                    </div>

                    <div class="div-search-products">
                        <ul class="list-products" id="listSearchItems">
                            <li class="text-nowrap" id="emptySearchItems">
                                Nenhum produto encontrado.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal" tabindex="-1" id="modalPayment">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Pagamento</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-0">
                        <label for="payment_type">
                            Forma de pagamento <span class="text-danger">*</span>
                        </label>
                        <select class="form-control" id="payment_type">
                            @selectOption(['items' => $paymentTypes])
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary js-confirm-payment">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('script')
    <script type="text/x-handlebars-template" id="templatePaymentItem">
        <tr class="payment-item" data-index="@{{index}}">
            <td>
                <input type="hidden" name="products[]" value="@{{index}}">
                <input type="hidden" name="product_@{{index}}_id" value="@{{id}}">
                <span class="text-product bg-dark rounded px-2">@{{name}}</span>
            </td>
            <td class="text-right">
                <input type="hidden" name="product_@{{index}}_price" value="@{{price}}">
                @{{price_show}}
            </td>
            <td>
                <input type="text"
                       class="form-control form-control-sm text-center js-change-qty-payment-item"
                       name="product_@{{index}}_quantity"
                       value="1"
                       maxlength="3"
                       data-input-mask="numeric"
                >
            </td>
            <td class="text-right">
                <span class="text-price">@{{price_show }}</span>
            </td>
            <td class="text-center">
                <button type="button" class="btn text-danger p-0 js-remove-payment-item">
                    <i class="c-icon cil-trash"></i>
                </button>
            </td>
        </tr>
    </script>
    <script type="text/x-handlebars-template" id="templateSearchItem">
        @{{#each this}}
            <li class="search-item">
                <span class="card-product rounded js-add-product-search" data-id="@{{id}}">
                    <span class="card-image" style="background-image: url(@{{image}})">
                        <img src="{{ asset("/img/150x150.jpg") }}">
                    </span>
                    <span class="card-title">
                        @{{name}}
                    </span>
                </span>
            </li>
        @{{/each}}
    </script>

    <script src="{{ asset('/vendors/handlebars.min.js') }}"></script>
    <script src="{{ asset('/dist/pdv.js') }}"></script>
@endpush