$.extend({
  loadHtml: function(_selectors, _url, done) {
    var selectors = typeof _selectors === 'string' ? [_selectors] : _selectors;
    var url       = _url || window.location.href;

    $.get(url).always(function(response) {
      var $root = $('<div></div>').html(response);

      $.each(selectors, function(i, selector) {
        var $selector = $root.find(selector);

        if ($selector.length) {
          $(selector).html($selector.html());
        }
      });

      if (done) {
        done($root);
      }
    });
  },

  formatMoney: function(value) {
    var $input = $('<input />');

    $input.maskMoney({precision: 2, decimal: ',', thousands: '.'});
    $input.val(value.toString().replace('.', ','));
    $input.maskMoney('mask');

    return $input.val();
  }
});

$(function() {
  $(document).on('click', 'a[href="#"]', function(event) {
    event.preventDefault();
  });

  $(document).on('click', '.js-search-order-by[data-column]', function(event) {
    event.preventDefault();
    var column   = $(this).data('column');
    var $orderBy = $('[name=order_by]');

    if (column === $orderBy.val()) {
      if (column.substring(0, 1) === '-') {
        column = column.substring(1, column.length - 1);
      } else {
        column = '-' + column;
      }
    }

    $orderBy.val(column);
    $orderBy.parents('form').submit();
  });

  $(document).on('click', '.js-submit-confirm[data-target]', function(event) {
    event.preventDefault();
    var data = $(this).data();

    $.confirmation(data.message || 'Confirmar ação?', function(result) {
      if (!result) {
        return;
      }

      $(data.target).submit();
    });
  });

  $(document).on('click', '.js-destroy-confirm', function(event) {
    event.preventDefault();
    var data    = $(this).data();
    var message = data.message || 'Deseja realmente excluir?';
    var target  = data.target || '#formDestroy';

    $.confirmation(message, function(result) {
      if (!result) {
        return;
      }

      var $form = $(target);

      if ($form.length === 0) {
        $form = $('<form method="post" />');
        $form.append('<input type="hidden" name="_token" value="' + window.CSRF_TOKEN + '">');
        $form.append('<input type="hidden" name="_method" value="DELETE">');
        $form.appendTo('body');
      }

      if (data.hasOwnProperty('url')) {
        $form.attr('action', data.url);
      }

      $form.submit();
    });
  });

  $(document).on('change', '.js-toggle-active[data-url]', function() {
    $.post($(this).data('url'), {active: 'toggle', '_method': 'PUT'}).always(function(response) {
      $.notification(
        response.message || 'error-1',
        response.hasOwnProperty('success') ? 'success' : 'error'
      );
    });
  });

  $(document).on('click', '.js-modal-ajax', function() {
    var data    = $(this).data();
    var $target = $(data.target);

    $target.find('.modal-body').html('');

    $.get(data.url).always(function(response) {
      if (typeof response === 'object' && response.status === 500) {
        console.log('error:', response.responseJSON || response);
        return $.notification('error-1', 'error');
      }

      $target.html(response);
      $target.modal('show');
    });
  });

  /**
   * API busca dados do CEP
   */
  (function() {
    var $cep = $('.js-cep-autocomplete');

    function getData(cep, cb) {
      delete $.ajaxSettings.headers['X-CSRF-TOKEN'];

      $.getJSON('https://viacep.com.br/ws/' + cep + '/json/').always(function(response) {
        $.ajaxSettings.headers['X-CSRF-TOKEN'] = window.CSRF_TOKEN;

        cb(response);
      });
    }

    function handler() {
      var data = $cep.data();
      var cep  = $cep.val().toString().replace('-', '');

      if (cep.length === 8 && window.cepAutocompleteValue !== cep) {
        window.cepAutocompleteValue = cep;

        $.blockUI();

        getData(cep, function(response) {
          if (typeof response !== 'object' || !response.hasOwnProperty('cep')) {
            return $.notification('CEP inválido.', 'error');
          }

          $.each(response, function(k, v) {
            var $input = $('[data-cep="' + k + '"]');

            $input.val(v);

            if (data.hasOwnProperty('focus') && data.focus === k) {
              $input.focus();
            }
          });

          $('.js-select2').select2init();

          $.unblockUI();
        });
      }
    }

    $cep.on('keyup blur', handler);
  })();

  /**
   * Upload ajax
   */
  (function() {
    $('input[type=file][id^="upload-image-"]').each(function() {
      var $this = $(this);

      $this.fileupload({
        dataType : 'json',
        formData : {_method: 'POST'},
        paramName: 'image',
        add      : function(e, data) {
          var file  = data.originalFiles[0];
          var types = /^image\/(jpg|jpeg|png|gif)$/i;
          var size  = 2 * (1024 * 1024);
          var error = null;

          if (!types.test(file.type)) {
            error = 'Tipo de arquivo não permitido.';
          } else if (file.size > size) {
            error = 'Arquivo muito grande, no máximo 2MB.';
          }

          if (error) {
            $.notification(error, 'error');
          } else {
            data.submit();
          }
        },
        complete : function(data) {
          var response = data.responseJSON || data;

          if (typeof response !== 'object') {
            return $.notification('error-1', 'error');
          }

          if (response.status === 'success') {
            handlerSuccess($this.attr('id'), response);

            return $.notification(response.message);
          }

          $.notification(response.message || 'error-1', 'error');
        }
      });
    });

    function handlerSuccess(inputId, response) {
      var $input   = $('#' + inputId);
      var $parent  = $input.closest('.form-upload');
      var $empty   = $parent.find('.input-upload-empty');
      var $preview = $parent.find('.input-upload-preview');

      $('[name="' + $input.data('key') + '"]').val(response.path);
      $preview.find('[data-src]').attr('data-src', response.url);

      $empty.fadeOut('fast', function() {
        $preview.fadeIn('fast');
      });
    }

    $(document).on('click', '.js-upload-image-remove', function() {
      var $parent  = $(this).closest('.form-upload');
      var $empty   = $parent.find('.input-upload-empty');
      var $preview = $parent.find('.input-upload-preview');

      $preview.fadeOut('fast', function() {
        $empty.fadeIn('fast');
      });
    });
  })();
});