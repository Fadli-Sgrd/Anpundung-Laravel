(function () {
  if (!window.jQuery) return;

  function csrf() {
    return $('meta[name="csrf-token"]').attr('content');
  }

  function setMsg($box, type, text) {
    if (!$box || !$box.length) return;

    $box.removeClass('hidden bg-green-100 text-green-700 bg-red-100 text-red-700');
    if (type === 'success') $box.addClass('bg-green-100 text-green-700');
    else $box.addClass('bg-red-100 text-red-700');
    $box.text(text).removeClass('hidden');
  }

  function firstValidationError(xhr, fallback) {
    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
      const errors = xhr.responseJSON.errors;
      const key = Object.keys(errors)[0];
      if (key && errors[key] && errors[key][0]) return errors[key][0];
    }
    if (xhr.responseJSON && xhr.responseJSON.message) return xhr.responseJSON.message;
    return fallback;
  }

  function bindAjaxForm(options) {
    const $form = $(options.form);
    if (!$form.length) return;

    const $msg = $(options.msgBox);
    const $btn = $(options.btn);

    const btnText = options.btnText || $btn.text() || 'Kirim';
    const loadingText = options.loadingText || 'Mengirim...';

    $form.on('submit', function (e) {
      e.preventDefault();

      if ($msg.length) $msg.addClass('hidden').text('');
      if ($btn.length) $btn.prop('disabled', true).text(loadingText);

      const isMultipart = $form.attr('enctype') === 'multipart/form-data';
      const ajaxData = isMultipart ? new FormData(this) : $form.serialize();

      $.ajax({
        url: options.url || $form.attr('action'),
        method: options.method || $form.attr('method') || 'POST',
        data: ajaxData,
        processData: !isMultipart,
        contentType: !isMultipart ? 'application/x-www-form-urlencoded; charset=UTF-8' : false,
        headers: { 'X-CSRF-TOKEN': csrf(), 'Accept': 'application/json' },
        success: function (res) {
          if (options.resetOnSuccess !== false) $form[0].reset();
          setMsg($msg, 'success', res?.message || options.successText || 'Berhasil');
          options.onSuccess && options.onSuccess(res, $form, $msg);
        },
        error: function (xhr) {
          const text = firstValidationError(xhr, options.errorText || 'Gagal');
          setMsg($msg, 'error', text);
          options.onError && options.onError(xhr, $form, $msg);
        },
        complete: function () {
          if ($btn.length) $btn.prop('disabled', false).text(btnText);
        }
      });
    });
  }

  function bindModal(options) {
    const $modal = $(options.modal);
    if (!$modal.length) return;

    $(document).on('click', options.open, function () {
      $modal.removeClass('hidden');
    });

    $(document).on('click', options.close, function () {
      $modal.addClass('hidden');
    });
  }

  window.AppJQ = {
    csrf,
    setMsg,
    bindAjaxForm,
    bindModal
  };
})();
