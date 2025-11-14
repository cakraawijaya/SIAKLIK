$(document).ready(function() {

  function generateUUID() {
    return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
      var r = Math.random() * 16 | 0, v = c === 'x' ? r : (r & 0x3 | 0x8);
      return v.toString(16);
    });
  }

  $(document).on('show.bs.modal', '.queue-modal', function() {
    var modal = $(this);
    var token = generateUUID();
    modal.find('input[name="request_token"]').val(token);
    modal.find('input[name="kode"]').val('');
    modal.find('.queue-form').data('submitting', false);
    modal.find('button[type="submit"]').prop('disabled', false).html('Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>');
  });

  $(document).on('submit', '.queue-form', function(e) {
    e.preventDefault();

    var form = $(this);
    var kategori = form.data('kategori');
    var layanan = form.find('select[name="layanan"]').val();
    var request_token = form.find('input[name="request_token"]').val();
    var submitBtn = form.find('button[type="submit"]');

    if (!request_token) {
      request_token = generateUUID();
      form.find('input[name="request_token"]').val(request_token);
    }

    if (form.data('submitting')) return;
    form.data('submitting', true);
    submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Memproses...');

    Swal.fire({
      title: 'Memproses pendaftaran...',
      text: 'Mohon tunggu sebentar',
      allowOutsideClick: false,
      allowEscapeKey: false,
      didOpen: () => Swal.showLoading()
    });

    $.ajax({
      url: BASE_URL + "components/data_ajax/ajax_queue_registration.php",
      type: "POST",
      dataType: "json",
      data: {
        kategori: kategori,
        layanan: layanan,
        request_token: request_token
      },
      success: function(res) {
        Swal.close();

        if (res.status === "success") {
          form.find('input[name="kode"]').val(res.kode_antrean);
          form.closest('.modal').modal('hide');
          form[0].reset();

          setTimeout(function() {
            Swal.fire({
              toast: true,
              position: 'top-end',
              icon: 'success',
              html: `<b>Antrean berhasil dibuat!</b><br>Kode Anda: <strong>${res.kode_antrean}</strong>`,
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true
            });
          }, 400);

          if (typeof loadQueue === 'function') loadQueue();

        } 
        else if (res.status === "error_duplicate") {
          Swal.fire({
            title: 'Gagal Memproses',
            html: res.message + `<br><br>Kode antrean: <strong>${res.kode_antrean}</strong>`,
            icon: 'error',
            iconColor: '#dc3545',
            confirmButtonText: '<strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Tutup</strong>',
            buttonsStyling: false,
            buttonsStyling: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'swal2-card',
                confirmButton: 'swal2-confirm-button swal2-danger-confirm'
            }
          });
        }
        else {
          Swal.fire({
            title: 'Gagal Memproses',
            html: res.message || 'Terjadi kesalahan.',
            icon: 'error',
            iconColor: '#dc3545',
            confirmButtonText: '<strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Tutup</strong>',
            buttonsStyling: false,
            buttonsStyling: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            customClass: {
                popup: 'swal2-card',
                confirmButton: 'swal2-confirm-button swal2-danger-confirm'
            }
          });
        }
      },
      error: function(xhr) {
        Swal.close();
        console.error(xhr.responseText);

        Swal.fire({
          html: 'Terjadi kesalahan pada server.',
          title: 'Kesalahan Server',
          icon: 'error',
          iconColor: '#dc3545',
          confirmButtonText: '<strong><i class="fa fa-times mr-1" aria-hidden="true"></i>Tutup</strong>',
          buttonsStyling: false,
          buttonsStyling: false,
          allowOutsideClick: false,
          allowEscapeKey: false,
          customClass: {
            popup: 'swal2-card',
            confirmButton: 'swal2-confirm-button swal2-danger-confirm'
          }
        });
      },
      complete: function() {
        form.data('submitting', false);
        submitBtn.prop('disabled', false).html('Setuju & Lanjutkan<i class="fas fa-paper-plane ml-2"></i>');
      }
    });
  });

});