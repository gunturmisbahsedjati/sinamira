/**
 * Main
 */

'use strict';
$(window).on('load', function () {
  if ($('.cover').length) {
    $('.cover').parallax({
      imageSrc: $('.cover').data('image'),
      zIndex: '1'
    });
  }

  $("#preloader").animate({
    'opacity': '0'
  }, 600, function () {
    setTimeout(function () {
      $("#preloader").css("visibility", "hidden").fadeOut();
    }, 300);
  });
});


$('#formAuthentication').submit(function (e) {
  e.preventDefault();
  var valid = true;
  var username = $("#username").val();
  var password = $("#password").val();
  const btnLogin = document.querySelector('.btn-login');
  const btnLoading = document.querySelector('.btn-loading');
  $.ajax({
    url: "inc/checklogin",
    type: "POST",
    data: { 'username': username, 'password': password },
    success: function (data) {
      if (data == 0) {
        btnLogin.classList.toggle('d-none');
        btnLoading.classList.toggle('d-none');
        Swal.fire({
          title: 'Username dan Password \n tidak sesuai',
          text: "Cek kembali username dan password anda !",
          confirmButtonColor: '#696cff',
          confirmButtonText: 'Ok',
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {
            btnLogin.classList.toggle('d-none');
            btnLoading.classList.toggle('d-none');

          }
        });

      } else if (data !== 1) {
        btnLogin.classList.toggle('d-none');
        btnLoading.classList.toggle('d-none');
        var username = $("#username").val();
        $.ajax({
          url: "inc/redirect",
          type: "POST",
          data: { 'username': username, 'password': password },
          dataType: "text",
          success: function (data) {
            Swal.fire({
              title: "Login Sukses",
              icon: "success",
              timer: 1500,
              showConfirmButton: false
            }).then(function () {
              if (true) {
                window.location = "./";
              }
            });

          }
        });
      } else {
        console.log("invalid");
      }
    }
  });
  //
});

var myLoadingPage
function loadingPage() {
  myLoadingPage = setTimeout(showPage, 100);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("content").style.display = "block";
}

// $(document).ready(function () {
//   $('[data-toggle="counter-up"]').counterUp({
//     delay: 10,
//     time: 1000
//   });
// });
var _validFileExtensions = [".jpg"];
function ValidateSingleInputJPG(oInput) {
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensions.length; j++) {
        var sCurExtension = _validFileExtensions[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          blnValid = true;
          break;

        }
      }

      if (!blnValid) {
        Swal.fire({
          icon: 'error',
          title: 'File format harus JPG !',
          showConfirmButton: true,
          timer: 5000
        });
        oInput.value = "";
        return false;
      }
    }
  }
  return true;
};

var _validFileExtensionpdf = ["pdf", "PDF", "Pdf"];
function ValidateSingleInputpdf(oInput) {
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensionpdf.length; j++) {
        var sCurExtension = _validFileExtensionpdf[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          blnValid = true;
          break;

        }
      }

      if (!blnValid) {
        Swal.fire({
          icon: 'error',
          title: 'File format harus pdf !',
          showConfirmButton: true,
          timer: 5000
        });
        oInput.value = "";
        return false;
      }
    }
  }
  return true;
};

var _validFileExtensionImage = ["jpg", "jpeg", "png"];
function ValidateImage(oInput) {
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensionImage.length; j++) {
        var sCurExtension = _validFileExtensionImage[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          blnValid = true;
          break;

        }
      }

      if (!blnValid) {
        // console.log('error eks');
        Swal.fire({
          icon: 'error',
          title: 'File format harus .jpg, .jpeg, .png !',
          showConfirmButton: true,
          timer: 5000
        });
        oInput.value = "";
        return false;
      }
    }
  }
  return true;
};

var _validFileExtensionVideo = ["mp4", "wma", "avi"];
function ValidateVideo(oInput) {
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensionVideo.length; j++) {
        var sCurExtension = _validFileExtensionVideo[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          blnValid = true;
          break;

        }
      }

      if (!blnValid) {
        // console.log('error eks');
        Swal.fire({
          icon: 'error',
          title: 'File format harus .mp4, .wma, .avi !',
          showConfirmButton: true,
          timer: 5000
        });
        oInput.value = "";
        return false;
      }
    }
  }
  return true;
};

function ValidateSizeVideo(file) {
  var FileSize = file.files[0].size;
  if (FileSize > 200000000) {
    Swal.fire({
      icon: 'error',
      title: 'Ukuran file maks 200MB',
      showConfirmButton: true,
      timer: 5000
    });
    file.value = "";
    return false;
  } else {

  }
}


function ValidateSize(file) {
  var FileSize = file.files[0].size;
  if (FileSize > 1000000) {
    // console.log('error eks');
    Swal.fire({
      icon: 'error',
      title: 'Ukuran file maks 1MB',
      showConfirmButton: true,
      timer: 5000
    });
    file.value = "";
    return false;
  } else {

  }
}

function ValidateSize2MB(file) {
  var FileSize = file.files[0].size;
  if (FileSize > 2097152) {
    Swal.fire({
      icon: 'error',
      title: 'Ukuran file maks 2MB',
      showConfirmButton: true,
      timer: 5000
    });
    file.value = "";
    return false;
  } else {

  }
}

var _validFileExtensionsExcel = [".xls", ".xlsx"];

function ValidateSingleInputExcel(oInput) {
  if (oInput.type == "file") {
    var sFileName = oInput.value;
    if (sFileName.length > 0) {
      var blnValid = false;
      for (var j = 0; j < _validFileExtensionsExcel.length; j++) {
        var sCurExtension = _validFileExtensionsExcel[j];
        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
          blnValid = true;
          break;

        }
      }

      if (!blnValid) {
        Swal.fire({
          icon: 'error',
          title: 'File format harus Excel !',
          showConfirmButton: true,
          timer: 5000
        });
        oInput.value = "";
        return false;
        $('.cekButton').attr('disabled', true);
      } else {
        $('.cekButton').removeAttr('disabled');
      }
    }
  }
  return true;
};

// $(".custom-file-input").on("change", function () {
//   var fileName = $(this).val().split("\\").pop();
//   $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
// });


//sidebar
$(document).ready(function () {
  $('#commingSoon').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
    document.getElementById("load-comingsoon").style.display = "block";
    document.getElementById("comingsoon").style.display = "none";
    $.ajax({
      url: 'dashboard/page/comingSoonPage',
      success: function (data) {
        document.getElementById("load-comingsoon").style.display = "none";
        document.getElementById("comingsoon").style.display = "block";
        $('.comingsoon').html(data);
      }
    });
  });
  $('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  });
});

//js data-pengguna
if (document.getElementById('data_akun_manajemen')) {

  $('#account_table').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': true
  });

  //tambah
  $(document).ready(function () {
    $('#addAccount').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-add-account").style.display = "block";
      document.getElementById("add-account").style.display = "none";
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-pengguna/tambah-akun.php',
        success: function (data) {
          document.getElementById("load-add-account").style.display = "none";
          document.getElementById("add-account").style.display = "block";
          $('.add-account').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

  $(document).ready(function () {
    $('#delAccount').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-del-account").style.display = "block";
      document.getElementById("del-account").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-pengguna/hapus-akun.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-del-account").style.display = "none";
          document.getElementById("del-account").style.display = "block";
          $('.del-account').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });


}
//js data-pengguna

//js data-tim
if (document.getElementById('data_area')) {

  $('#team_table').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    'autoWidth': true
  });

  //tambah
  $(document).ready(function () {
    $('#addArea').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      document.getElementById("load-add-area").style.display = "block";
      document.getElementById("add-area").style.display = "none";
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-area/tambah-area.php',
        success: function (data) {
          document.getElementById("load-add-area").style.display = "none";
          document.getElementById("add-area").style.display = "block";
          $('.add-area').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

  $(document).ready(function () {
    $('#editArea').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      document.getElementById("load-edit-area").style.display = "block";
      document.getElementById("edit-area").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-area/edit-area.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-edit-area").style.display = "none";
          document.getElementById("edit-area").style.display = "block";
          $('.edit-area').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });
  $(document).ready(function () {
    $('#delArea').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      document.getElementById("load-del-area").style.display = "block";
      document.getElementById("del-area").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-area/hapus-area.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-del-area").style.display = "none";
          document.getElementById("del-area").style.display = "block";
          $('.del-area').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

}
//js data-tim

//js data-program
$(document).ready(function () {
  $('#showYearProgram').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    document.getElementById("load-show-year-program").style.display = "block";
    document.getElementById("show-year-program").style.display = "none";
    $.ajax({
      type: 'post',
      url: 'dashboard/page/kegiatan/data-program-kerja/pilih-tahun-program.php',
      success: function (data) {
        // console.log(data);
        document.getElementById("load-show-year-program").style.display = "none";
        document.getElementById("show-year-program").style.display = "block";
        $('.show-year-program').html(data);
      }
    });
  });
  $('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  });
});

if (document.getElementById('data_program')) {

  $('#program_table').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    // 'autoWidth': true
  });


  $(document).ready(function () {
    $('#addProgram').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-add-program").style.display = "block";
      document.getElementById("add-program").style.display = "none";
      const token = $(e.relatedTarget).data('token');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-program-kerja/tambah-program.php',
        data: { 'token': token },
        success: function (data) {
          document.getElementById("load-add-program").style.display = "none";
          document.getElementById("add-program").style.display = "block";
          $('.add-program').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

  $(document).ready(function () {
    $('#editProgram').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-edit-program").style.display = "block";
      document.getElementById("edit-program").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-program-kerja/ubah-program.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-edit-program").style.display = "none";
          document.getElementById("edit-program").style.display = "block";
          $('.edit-program').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

  $(document).ready(function () {
    $('#delProgram').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-del-program").style.display = "block";
      document.getElementById("del-program").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-program-kerja/hapus-program.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-del-program").style.display = "none";
          document.getElementById("del-program").style.display = "block";
          $('.del-program').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

};
//js data-program

//js data-kegiatan
$(document).ready(function () {
  $('#showYearActivity').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    document.getElementById("load-show-year-activity").style.display = "block";
    document.getElementById("show-year-activity").style.display = "none";
    $.ajax({
      type: 'post',
      url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/pilih-tahun-kegiatan.php',
      success: function (data) {
        // console.log(data);
        document.getElementById("load-show-year-activity").style.display = "none";
        document.getElementById("show-year-activity").style.display = "block";
        $('.show-year-activity').html(data);
      }
    });
  });
  $('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  });
});

if (document.getElementById('data_kegiatan')) {
  $('#activity_table').DataTable({
    'paging': true,
    'lengthChange': true,
    'searching': true,
    'ordering': true,
    'info': true,
    // 'autoWidth': true
  });
}
if (document.getElementById('data_detail_program')) {

  // $('#detail_program_table').DataTable({
  //   'paging': false,
  //   'lengthChange': false,
  //   'searching': false,
  //   'ordering': false,
  //   'info': false,
  //   'autoWidth': true
  // });


  $(document).ready(function () {
    $('#addDetailActivity').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-add-detail-activity").style.display = "block";
      document.getElementById("add-detail-activity").style.display = "none";
      const token = $(e.relatedTarget).data('token');
      const key = $(e.relatedTarget).data('key');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/tambah-kegiatan.php',
        data: { 'token': token, 'key': key },
        success: function (data) {
          document.getElementById("load-add-detail-activity").style.display = "none";
          document.getElementById("add-detail-activity").style.display = "block";
          $('.add-detail-activity').html(data);
          // $('#program').selectpicker();
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      // $('#program').selectpicker('destroy');
    });
  });

  $(document).ready(function () {
    $('#editDetailActivity').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-edit-detail-activity").style.display = "block";
      document.getElementById("edit-detail-activity").style.display = "none";
      const token = $(e.relatedTarget).data('token');
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/ubah-kegiatan.php',
        data: { 'token': token, 'id': id },
        success: function (data) {
          document.getElementById("load-edit-detail-activity").style.display = "none";
          document.getElementById("edit-detail-activity").style.display = "block";
          $('.edit-detail-activity').html(data);
          // $('#program').selectpicker();
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      // $('#program').selectpicker('destroy');
    });
  });

  $(document).ready(function () {
    $('#delDetailActivity').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-del-detail-activity").style.display = "block";
      document.getElementById("del-detail-activity").style.display = "none";
      const token = $(e.relatedTarget).data('token');
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/hapus-kegiatan.php',
        data: { 'token': token, 'id': id },
        success: function (data) {
          document.getElementById("load-del-detail-activity").style.display = "none";
          document.getElementById("del-detail-activity").style.display = "block";
          $('.del-detail-activity').html(data);
          // $('#program').selectpicker();
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      // $('#program').selectpicker('destroy');
    });
  });

  $(document).ready(function () {
    $('#updateStatusActivity').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      document.getElementById("load-update-status-activity").style.display = "block";
      document.getElementById("update-status-activity").style.display = "none";
      const token = $(e.relatedTarget).data('token');
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/ubah-status-kegiatan.php',
        data: { 'token': token, 'id': id },
        success: function (data) {
          document.getElementById("load-update-status-activity").style.display = "none";
          document.getElementById("update-status-activity").style.display = "block";
          $('.update-status-activity').html(data);
          // $('#program').selectpicker();
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      // $('#program').selectpicker('destroy');
    });
  });

  $(document).ready(function () {
    $('#uploadFileActivity').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-lg');
      document.getElementById("load-upload-file-activity").style.display = "block";
      document.getElementById("upload-file-activity").style.display = "none";
      const token = $(e.relatedTarget).data('token');
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/upload-dokumen-detail-kegiatan.php',
        data: { 'token': token, 'id': id },
        success: function (data) {
          document.getElementById("load-upload-file-activity").style.display = "none";
          document.getElementById("upload-file-activity").style.display = "block";
          $('.upload-file-activity').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

  //   $(document).ready(function () {
  //     $('#editProgram').on('show.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //       document.getElementById("load-edit-program").style.display = "block";
  //       document.getElementById("edit-program").style.display = "none";
  //       const id = $(e.relatedTarget).data('id');
  //       $.ajax({
  //         type: 'post',
  //         url: 'dashboard/page/kegiatan/data-program-kerja/ubah-program.php',
  //         data: { 'id': id },
  //         success: function (data) {
  //           document.getElementById("load-edit-program").style.display = "none";
  //           document.getElementById("edit-program").style.display = "block";
  //           $('.edit-program').html(data);
  //         }
  //       });
  //     });
  //     $('.modal').on('hide.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     });
  //   });

  //   $(document).ready(function () {
  //     $('#delProgram').on('show.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //       document.getElementById("load-del-program").style.display = "block";
  //       document.getElementById("del-program").style.display = "none";
  //       const id = $(e.relatedTarget).data('id');
  //       $.ajax({
  //         type: 'post',
  //         url: 'dashboard/page/kegiatan/data-program-kerja/hapus-program.php',
  //         data: { 'id': id },
  //         success: function (data) {
  //           document.getElementById("load-del-program").style.display = "none";
  //           document.getElementById("del-program").style.display = "block";
  //           $('.del-program').html(data);
  //         }
  //       });
  //     });
  //     $('.modal').on('hide.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     });
  //   });

};
//js data-kegiatan

//js data-capaian-kinerja
$(document).ready(function () {
  $('#showYearInstrument').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    document.getElementById("load-show-year-instrument").style.display = "block";
    document.getElementById("show-year-instrument").style.display = "none";
    $.ajax({
      type: 'post',
      url: 'dashboard/page/kegiatan/data-capaian-program-kerja/pilih-tahun-capaian.php',
      success: function (data) {
        // console.log(data);
        document.getElementById("load-show-year-instrument").style.display = "none";
        document.getElementById("show-year-instrument").style.display = "block";
        $('.show-year-instrument').html(data);
      }
    });
  });
  $('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  });
});

if (document.getElementById('data_capaian_kegiatan')) {

}
if (document.getElementById('data_capaian_kinerja_detail_program')) {
  $('#instrument_table').DataTable({
    'paging': false,
    'lengthChange': false,
    'searching': true,
    'ordering': false,
    'info': false,
    // 'autoWidth': true
  });

  // $('#detail_program_table').DataTable({
  //   'paging': false,
  //   'lengthChange': false,
  //   'searching': false,
  //   'ordering': false,
  //   'info': false,
  //   'autoWidth': true
  // });


  $(document).ready(function () {
    $('#addInstrumentTeam').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-lg');
      document.getElementById("load-add-instrument-team").style.display = "block";
      document.getElementById("add-instrument-team").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-capaian-program-kerja/modal/tambah-capaian-akses-tim.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-add-instrument-team").style.display = "none";
          document.getElementById("add-instrument-team").style.display = "block";
          $('.add-instrument-team').html(data);
          // $('#program').selectpicker();
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      // $('#program').selectpicker('destroy');
    });
  });

  $(document).ready(function () {
    $('#addInstrumentAdmin').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-lg');
      document.getElementById("load-add-instrument-admin").style.display = "block";
      document.getElementById("add-instrument-admin").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/kegiatan/data-capaian-program-kerja/modal/tambah-capaian-akses-admin.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-add-instrument-admin").style.display = "none";
          document.getElementById("add-instrument-admin").style.display = "block";
          $('.add-instrument-admin').html(data);
          // $('#program').selectpicker();
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      // $('#program').selectpicker('destroy');
    });
  });

  // $(document).ready(function () {
  //   $('#editDetailActivity').on('show.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //     document.getElementById("load-edit-detail-activity").style.display = "block";
  //     document.getElementById("edit-detail-activity").style.display = "none";
  //     const token = $(e.relatedTarget).data('token');
  //     const id = $(e.relatedTarget).data('id');
  //     $.ajax({
  //       type: 'post',
  //       url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/ubah-kegiatan.php',
  //       data: { 'token': token, 'id': id },
  //       success: function (data) {
  //         document.getElementById("load-edit-detail-activity").style.display = "none";
  //         document.getElementById("edit-detail-activity").style.display = "block";
  //         $('.edit-detail-activity').html(data);
  //         // $('#program').selectpicker();
  //       }
  //     });
  //   });
  //   $('.modal').on('hide.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     // $('#program').selectpicker('destroy');
  //   });
  // });

  // $(document).ready(function () {
  //   $('#delDetailActivity').on('show.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //     document.getElementById("load-del-detail-activity").style.display = "block";
  //     document.getElementById("del-detail-activity").style.display = "none";
  //     const token = $(e.relatedTarget).data('token');
  //     const id = $(e.relatedTarget).data('id');
  //     $.ajax({
  //       type: 'post',
  //       url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/hapus-kegiatan.php',
  //       data: { 'token': token, 'id': id },
  //       success: function (data) {
  //         document.getElementById("load-del-detail-activity").style.display = "none";
  //         document.getElementById("del-detail-activity").style.display = "block";
  //         $('.del-detail-activity').html(data);
  //         // $('#program').selectpicker();
  //       }
  //     });
  //   });
  //   $('.modal').on('hide.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     // $('#program').selectpicker('destroy');
  //   });
  // });

  // $(document).ready(function () {
  //   $('#updateStatusActivity').on('show.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //     document.getElementById("load-update-status-activity").style.display = "block";
  //     document.getElementById("update-status-activity").style.display = "none";
  //     const token = $(e.relatedTarget).data('token');
  //     const id = $(e.relatedTarget).data('id');
  //     $.ajax({
  //       type: 'post',
  //       url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/ubah-status-kegiatan.php',
  //       data: { 'token': token, 'id': id },
  //       success: function (data) {
  //         document.getElementById("load-update-status-activity").style.display = "none";
  //         document.getElementById("update-status-activity").style.display = "block";
  //         $('.update-status-activity').html(data);
  //         // $('#program').selectpicker();
  //       }
  //     });
  //   });
  //   $('.modal').on('hide.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     // $('#program').selectpicker('destroy');
  //   });
  // });

  // $(document).ready(function () {
  //   $('#uploadFileActivity').on('show.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-lg');
  //     document.getElementById("load-upload-file-activity").style.display = "block";
  //     document.getElementById("upload-file-activity").style.display = "none";
  //     const token = $(e.relatedTarget).data('token');
  //     const id = $(e.relatedTarget).data('id');
  //     $.ajax({
  //       type: 'post',
  //       url: 'dashboard/page/kegiatan/data-kegiatan-program-kerja/modal/upload-dokumen-detail-kegiatan.php',
  //       data: { 'token': token, 'id': id },
  //       success: function (data) {
  //         document.getElementById("load-upload-file-activity").style.display = "none";
  //         document.getElementById("upload-file-activity").style.display = "block";
  //         $('.upload-file-activity').html(data);
  //       }
  //     });
  //   });
  //   $('.modal').on('hide.bs.modal', function (e) {
  //     $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //   });
  // });

  //   $(document).ready(function () {
  //     $('#editProgram').on('show.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //       document.getElementById("load-edit-program").style.display = "block";
  //       document.getElementById("edit-program").style.display = "none";
  //       const id = $(e.relatedTarget).data('id');
  //       $.ajax({
  //         type: 'post',
  //         url: 'dashboard/page/kegiatan/data-program-kerja/ubah-program.php',
  //         data: { 'id': id },
  //         success: function (data) {
  //           document.getElementById("load-edit-program").style.display = "none";
  //           document.getElementById("edit-program").style.display = "block";
  //           $('.edit-program').html(data);
  //         }
  //       });
  //     });
  //     $('.modal').on('hide.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     });
  //   });

  //   $(document).ready(function () {
  //     $('#delProgram').on('show.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
  //       document.getElementById("load-del-program").style.display = "block";
  //       document.getElementById("del-program").style.display = "none";
  //       const id = $(e.relatedTarget).data('id');
  //       $.ajax({
  //         type: 'post',
  //         url: 'dashboard/page/kegiatan/data-program-kerja/hapus-program.php',
  //         data: { 'id': id },
  //         success: function (data) {
  //           document.getElementById("load-del-program").style.display = "none";
  //           document.getElementById("del-program").style.display = "block";
  //           $('.del-program').html(data);
  //         }
  //       });
  //     });
  //     $('.modal').on('hide.bs.modal', function (e) {
  //       $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  //     });
  //   });

};
//js data-capaian-kinerja


// common fitur
$(document).ready(function () {
  $('#changePass').on('show.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
    document.getElementById("load-change-pass").style.display = "block";
    document.getElementById("change-pass").style.display = "none";
    const url = $(e.relatedTarget).data('url');
    $.ajax({
      type: 'post',
      url: 'dashboard/page/common-fitur/ganti-pass.php',
      data: { 'url': url },
      success: function (data) {
        document.getElementById("load-change-pass").style.display = "none";
        document.getElementById("change-pass").style.display = "block";
        $('.change-pass').html(data);
      }
    });
  });
  $('.modal').on('hide.bs.modal', function (e) {
    $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
  });
});
// common fitur

//dashboard
if (document.getElementById('calendar')) {
  $('#calendar').fullCalendar({
    googleCalendarApiKey: 'AIzaSyBdk8wCbYgLgRfQKFJWGqFDSNKRlUtnT3w',
    themeSystem: 'bootstrap4',
    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'year,month,basicWeek,listDay'
    },
    locale: 'id',
    editable: false,
    defaultView: 'month',
    displayEventTime: false,
    eventSources: [
      // event google kalender
      {
        googleCalendarId: 'en.indonesian#holiday@group.v.calendar.google.com',
        rendering: 'background',
        className: 'fc-holiday',
        // dayRender: function (date, cell) {
        //   cell.css("color", "white");
        // },
        // backgroundColor: 'red',
        // borderColor: '#378006'
      },
      // event kegiatan
      {
        url: "dashboard/page/view-dashboard/fetch-event",
      }
      // any other sources...
    ],
    eventRender: function (event, element, view) {
      if (event.allDay === 'true') {
        event.allDay = true;
      } else {
        event.allDay = false;
      }
    },
    selectable: true,
    eventClick: function (event, element) {
      $('#nama_area').html(event.nama_area);
      $('#nama_kegiatan').html(event.title);
      $('#nama_program').html(event.nama_program);
      $('#id_kegiatan').val(event.id_kegiatan);
      let cek_status = event.status_kegiatan;
      let $select = document.querySelector('#status_kegiatan');
      $select.value = event.status_kegiatan;
      const coba = 'oke';
      // let awal = $('#tglAwal').html(moment(event.start).format('D MMMM Y'));
      // let akhir = $('#tglAkhir').html(moment(event.end).format('D MMMM Y'));
      moment.locale('id')
      let awal = moment(event.start).format('D MMMM Y');
      let akhir = moment(event.end).format('D MMMM Y');
      $('#pelaksanaan').html(awal + ' s/d ' + akhir);
      // console.log();
      // $('#seksi').html(event.nama_seksi);
      $('#detailCalendarActivity').modal();
      // $('#detailCalendarActivity').on('show.bs.modal', function (e) {
      //   $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      //   document.getElementById("load-detail-calender-activity").style.display = "block";
      //   document.getElementById("detail-calender-activity").style.display = "none";
      //   $.ajax({
      //     type: 'post',
      //     url: 'dashboard/page/view-dashboard/detail-kegiatan.php',
      //     success: function (data) {
      //       document.getElementById("load-detail-calender-activity").style.display = "none";
      //       document.getElementById("detail-calender-activity").style.display = "block";
      //       $('.detail-calender-activity').html(data);
      //     }
      //   });
      // });
      $('.modal').on('hide.bs.modal', function (e) {
        $('.modal .modal-dialog').attr('class', 'modal-dialog modal-md');
      });
    }
  });
};

//dashboard
