$(function() {
  /**
   * Laravel CSRF token
   */
  window.CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $.ajaxSetup({headers: {'X-CSRF-TOKEN': window.CSRF_TOKEN}});

  /**
   * Bootstrap
   *
   * https://getbootstrap.com/docs/4.5/components/tooltips/
   */
  (function() {
    $('[data-toggle="tooltip"]').tooltip();
  })();

  /**
   * jQuery mask
   *
   * https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html
   */
  (function() {
    if (typeof $.jMaskGlobals !== 'object') {
      return;
    }

    $('[data-input-mask=date]').mask('00/00/0000');
    $('[data-input-mask=date_en]').mask('00-00-0000');
    $('[data-input-mask=time]').mask('00:00:00');
    $('[data-input-mask=time_basic]').mask('00:00');
    $('[data-input-mask=date_time]').mask('00/00/0000 00:00:00');
    $('[data-input-mask=cep]').mask('00000-000');
    $('[data-input-mask=cpf]').mask('000.000.000-00', {reverse: true});
    $('[data-input-mask=cnpj]').mask('00.000.000/0000-00', {reverse: true});
    $('[data-input-mask=numeric]').mask('###', {reverse: true});

    var maskBehavior = function(val) {
      return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
    };

    $('[data-input-mask=phone]').mask(maskBehavior, {
      onKeyPress: function(val, e, field, options) {
        field.mask(maskBehavior.apply({}, arguments), options);
      }
    });
  })();

  /**
   * jQuery maskMoney
   *
   * https://github.com/plentz/jquery-maskmoney
   */
  (function() {
    if (typeof $.fn.maskMoney !== 'function') {
      return;
    }

    $('[data-input-mask=money]').maskMoney({precision: 2, decimal: ',', thousands: '.'}).attr('maxlength', 12);
    $('[data-input-mask=percent]').maskMoney({precision: 2, decimal: ','}).attr('maxlength', 6);
    $('[data-input-mask=percent2]').maskMoney({precision: 4, decimal: ','}).attr('maxlength', 8);
  })();

  /**
   * Select2
   *
   * https://select2.org/
   */
  if (typeof $.fn.select2 === 'function') {
    $.fn.select2init = function() {
      $('select').each(function() {
        var $this = $(this);
        var width = $this.data('width');

        console.log($this.data('allow-clear') || true);

        $this.select2({
          minimumResultsForSearch: 6,
          theme                  : 'bootstrap4',
          width                  : width ? width : $this.hasClass('w-100') ? '100%' : 'style',
          placeholder            : $this.data('placeholder') || 'Selecione uma opção',
          allowClear             : Boolean($this.data('allow-clear') || true)
        });
      });
    };

    $('.js-select2').select2init();
  }

  /**
   * jQuery BlockUI
   *
   * http://jquery.malsup.com/block/
   */
  if (typeof $.blockUI === 'function') {
    $.blockUI.defaults = $.extend($.blockUI.defaults, {
      baseZ  : 99999,
      message: '<div class="lds-dual-ring"></div><div class="text-wait">Aguarde...</div>'
    });

    $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    $(document).on('submit', 'form', $.blockUI);
    $(document).on('click', '.pagination .page-link', $.blockUI);
  }

  /**
   * Noty
   *
   * https://ned.im/noty/#/options
   */
  if (typeof Noty === 'function') {
    $.notification = function(text, type, timeout) {
      timeout = timeout || true;

      if (typeof timeout === 'number') {
        timeout = timeout * 1000;
      } else if (timeout === true) {
        timeout = 3000;
      }

      if (text === 'error-1') {
        text = 'Ops! ocorreu um erro, tente novamente.';
      }

      new Noty({
        type     : type || 'success',
        text     : text || '',
        theme    : 'nest',
        layout   : 'topRight',
        closeWith: ['click', 'button'],
        timeout  : timeout || false,
        killer   : true
      }).show();

      return true;
    };
  }

  /**
   * jQuery Confirm
   *
   * https://craftpip.github.io/jquery-confirm/
   */
  if (typeof $.confirm === 'function') {
    $.confirmation = function(text, callback) {
      $.confirm({
        theme    : 'bootstrap',
        title    : 'Confirmação',
        content  : text || '',
        draggable: false,
        buttons  : {
          confirm: {
            text    : 'Confirmar',
            btnClass: 'btn-success',
            action  : function() {
              callback(true);
            }
          },
          cancel : {
            text    : 'Cancelar',
            btnClass: 'btn-danger',
            action  : function() {
              callback(false);
            }
          }
        }
      });
    };
  }

  /**
   * Datepicker
   *
   * https://fengyuanchen.github.io/datepicker/
   */
  if (typeof $.fn.datepicker === 'function') {
    $.fn.datepickerInit = function(options) {
      $(this).datepicker($.extend({
        autoHide: true,
        language: 'pt-BR'
      }, options || {}));
    };

    $('.js-datepicker').datepickerInit({language: 'pt-BR', format: 'dd/mm/yyyy'});
  }
});