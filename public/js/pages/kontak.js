$(function () {
  if (!window.AppJQ) return;

  // buka tutup modal
  AppJQ.bindModal({
    modal: '#modal-lapor',
    open: '.js-open-lapor',
    close: '#btn-close-lapor, #modal-backdrop'
  });

  // ajax submit laporan
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
