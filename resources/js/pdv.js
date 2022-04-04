var PdvPayment = (function() {
  var $form     = $('#formPayment');
  var $template = $('#templatePaymentItem');
  var $list     = $('#listPaymentItems');
  var $empty    = $('#emptyPaymentItems');
  var $count    = $('#countPaymentItems');
  var template  = Handlebars.compile($template.html());
  var items     = [];
  var index     = 0;

  function _update() {
    if (items.length === 0) {
      $empty.removeClass('d-none');
    } else {
      $empty.addClass('d-none');
    }

    $count.html(items.length);

    var total = 0;

    $list.find('.payment-item').each(function() {
      var price    = Number($(this).find('[name*=price]').val());
      var quantity = Number($(this).find('[name*=quantity]').val());
      var _total   = price * quantity;

      total += _total;

      $(this).find('.text-price').html($.formatMoney(_total));
    });

    $('#totalPaymentItems').html('R$ ' + $.formatMoney(total));

    $('[name=total]').val(total);
  }

  function _add(product) {
    var exists = $.grep(items, function(item) {
      return item.id === product.id;
    });

    if (exists.length > 0) {
      return $.notification('Produto já adicionado.', 'error');
    }

    index++;

    product.index      = index;
    product.price_show = $.formatMoney(product.price);

    var html = template(product);

    items.push(product);

    $list.find('tr:first').before(html);

    _update();
  }

  function _remove(idx) {
    items = $.grep(items, function(item) {
      return item.index !== idx;
    });

    $list.find('tr[data-index=' + idx + ']').fadeOut('fast', function() {
      $(this).remove();

      _update();
    });
  }

  function _submit() {
    $.post($form.attr('action'), $form.serialize()).always(function(response) {
      if (typeof response !== 'object') {
        return $.notification('error-1', 'error');
      }

      if (response.status === 'success') {
        _reset();

        return $.notification(response.message);
      }

      $.notification(response.message || 'error-1', 'error');
    });
  }

  function _reset() {
    items = [];
    index = 0;

    $('#modalPayment').modal('hide');

    $('#client, #product, #payment_type').val('');
    $('[name=client_id], [name=total], [name=status], [name=payment_type]').val('');

    $list.find('tr[data-index]').fadeOut('fast', function() {
      $(this).remove();

      _update();
    });

    $(document).trigger('hook.emptyPayment');
  }

  function _init() {
    _reset();

    $(document).on('click', '.js-remove-payment-item', function() {
      var index = $(this).closest('tr').data('index');

      $.confirmation('Remover produto?', function(result) {
        if (result === true) {
          _remove(index);
        }
      });
    });

    $(document).on('keyup', '.js-change-qty-payment-item', function() {
      var value = Number($(this).val());

      if (value === 0) {
        $(this).val(1);
      }

      _update();
    });

    $(document).on('click', '.js-checkout[data-status]', function() {
      var status   = $(this).data('status');
      var clientId = Number($('[name=client_id]').val());
      var products = $('[name^=product_][name$=_id]').length;

      if (clientId === 0) {
        $.notification('Selecione o cliente.', 'error');
        $('#client').focus();

        return false;
      } else if (products === 0) {
        $.notification('Informe ao menos 1 produto.', 'error');
        $('#product').focus();

        return false;
      }

      $('[name=status]').val(status);

      if (status === 'pay') {
        $('#modalPayment').modal('show');
      } else {
        _submit();
      }
    });

    $(document).on('click', '.js-confirm-payment', function() {
      var paymentType = $('#payment_type').val();

      if (!paymentType || Number(paymentType) === 0) {
        $.notification('Selecione uma forma de pagamento.', 'error');
        return false;
      }

      $('[name=payment_type]').val(paymentType);

      _submit();
    });

    /**
     * https://jqueryui.com/autocomplete/#custom-data
     */

    $('#client').autocomplete({
      source   : window.APP_URL + '/api/autocomplete/client',
      minLength: 2,
      select   : function(event, ui) {
        $('#client').val(ui.item.label);
        $('[name=client_id]').val(ui.item.value);

        return false;
      }
    });

    $('#product').autocomplete({
      source   : window.APP_URL + '/api/autocomplete/product',
      minLength: 2,
      select   : function(event, ui) {
        $('#product').val('').focus();

        _add(ui.item.product);

        return false;
      }
    });
  }

  return {
    init : _init,
    reset: _reset,
    _add : _add
  };
})();

var PdvSearch = (function() {
  var $template = $('#templateSearchItem');
  var $input    = $('#inputSearch');
  var $list     = $('#listSearchItems');
  var $empty    = $('#emptySearchItems');
  var template  = Handlebars.compile($template.html());
  var items     = [];

  function _render() {
    $list.find('.search-item').remove();

    if (items.length === 0) {
      $empty.removeClass('d-none');
    } else {
      $empty.addClass('d-none');
      $list.append(template(items));
    }
  }

  function _request(q) {
    $.get(window.APP_URL + '/api/products', {name: q}).always(function(response) {
      if (typeof response === 'object' && response.length > 0) {
        items = response;
      } else {
        items = [];
      }

      _render();
    });
  }

  function _reset() {
    items = [];

    $input.val('');

    _render();
  }

  function _init() {
    _reset();

    $(document).on('hook.emptyPayment', function() {
      _reset();
    });

    $(document).on('keyup', '.js-input-search', function(event) {
      if (event.which === 13) {
        var value = $(this).val();

        if (value.length > 0) {
          _request(value);
        } else {
          _reset();
        }
      }
    });

    $(document).on('click', '.js-add-product-search', function() {
      var productId = $(this).data('id');
      var product   = {};

      $.each(items, function(i, item) {
        if (item.id === productId) {
          product = item;
        }
      });

      if (product.hasOwnProperty('id')) {
        PdvPayment._add(product);
      }
    });
  }

  return {
    init : _init,
    reset: _reset
  };
})();

$(function() {

  if (!$('.page-pdv').length) {
    return;
  }

  PdvPayment.init();
  PdvSearch.init();

});