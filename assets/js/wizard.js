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
        console.log('error eks');
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


function ValidateSize(file) {
  var FileSize = file.files[0].size;
  if (FileSize > 1000000) {
    console.log('error eks');
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

function ValidateSizePengajuan(file) {
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
$(".custom-file-input").on("change", function () {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
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


}
//js data-pengguna

//js data-tim
if (document.getElementById('data_tim')) {

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
    $('#addTeam').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      document.getElementById("load-add-team").style.display = "block";
      document.getElementById("add-team").style.display = "none";
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-tim/tambah-tim.php',
        success: function (data) {
          document.getElementById("load-add-team").style.display = "none";
          document.getElementById("add-team").style.display = "block";
          $('.add-team').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

  $(document).ready(function () {
    $('#editTeam').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      document.getElementById("load-edit-team").style.display = "block";
      document.getElementById("edit-team").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-tim/edit-tim.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-edit-team").style.display = "none";
          document.getElementById("edit-team").style.display = "block";
          $('.edit-team').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });
  $(document).ready(function () {
    $('#delTeam').on('show.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
      document.getElementById("load-del-team").style.display = "block";
      document.getElementById("del-team").style.display = "none";
      const id = $(e.relatedTarget).data('id');
      $.ajax({
        type: 'post',
        url: 'dashboard/page/master/data-tim/hapus-tim.php',
        data: { 'id': id },
        success: function (data) {
          document.getElementById("load-del-team").style.display = "none";
          document.getElementById("del-team").style.display = "block";
          $('.del-team').html(data);
        }
      });
    });
    $('.modal').on('hide.bs.modal', function (e) {
      $('.modal .modal-dialog').attr('class', 'modal-dialog modal-sm');
    });
  });

}
//js data-tim


