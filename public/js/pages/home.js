$(function () {

  AppJQ.bindModal({
    modal: '#modal-lapor',
    open: '#btn-open-lapor, #btn-open-lapor-2',
    close: '#btn-close-lapor, #modal-backdrop'
  });

  AppJQ.bindAjaxForm({
    form: '#form-laporan-modal',
    url: '/laporan',
    msgBox: '#msg-modal',
    btn: '#btn-submit-lapor',
    btnText: 'Kirim Laporan',
    loadingText: 'Mengirim...',
    resetOnSuccess: true
  });

});
