$(function () {
  if (!window.AppJQ) return;

  // open close modal, pakai class supaya bisa dipakai di banyak halaman
  AppJQ.bindModal({
    modal: '#modal-lapor',
    open: '.js-open-lapor',
    close: '#btn-close-lapor, #modal-backdrop'
  });

  // ajax submit form
  AppJQ.bindAjaxForm({
    form: '#form-laporan-modal',
    url: '/laporan',
    method: 'POST',
    msgBox: '#msg-modal',
    btn: '#btn-submit-lapor',
    btnText: 'Kirim Laporan',
    loadingText: 'Mengirim...',
    successText: 'Laporan berhasil dikirim',
    errorText: 'Gagal mengirim laporan'
  });
});
