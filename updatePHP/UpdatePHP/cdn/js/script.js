$(document).ready(function(){

    //BOOTSTRAP TOOLTIP RUN
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));


   $(document).on('click', '#nextStep', function () {

       var updatedClient = $('input[name="updatedClient"]');

       if (updatedClient.val() == '' || updatedClient.val() == null || updatedClient.val() == undefined)
       {
           updatedClient.addClass('border-danger');
       }
       else
       {
           updatedClient.addClass('d-none');
           $('#nextStep').addClass('d-none');
           $('.info-section').html('Lütfen güncellemek istediğiniz dosya isimlerini giriniz (örn: updated-codes.php)');
           $('.title-php').html("'"+updatedClient.val() + "' Sitesinden Kodlar Güncel Kodlar Alınacak").addClass('fs-5 fw-light').removeClass('fw-bold');

           $('input [name="updatedClient"]').addClass('d-none');
           $('.file-manager').addClass('visible');
       }
   });


  $(document).on('click', '.play-btn', function(){
      let icon = $(this).find('i');
      let proccess = '';

      if (icon.hasClass('fa-play')) {
          icon.removeClass('fa-play').addClass('fa-pause');
          $(this).removeClass('btn-success').addClass('btn-secondary');
          proccess = 1;
      } else {
          icon.removeClass('fa-pause').addClass('fa-play');
          $(this).removeClass('btn-secondary').addClass('btn-success');
          proccess = 0;
      }

      let id = $(this).data('ftp');

      $.ajax({
          url: '/UpdatePHP/class/Ajax.php',
          method: 'post',
          data: {
              request: 'setStatus',
              data: {
                  ftpId: id,
                  proccess: proccess
              }
          },
          success: function (data) {
              console.log(data);
          }
      });

  });

    $(document).on('submit', '.ftp-form', function(e){
        e.preventDefault();
        var form = $(this);
        var formDataArray = form.serializeArray();

        // formDataArray'den verileri JSON objesine dönüştürme
        var formDataJson = {};
        $.each(formDataArray, function() {
            if (formDataJson[this.name]) {
                if (!Array.isArray(formDataJson[this.name])) {
                    formDataJson[this.name] = [formDataJson[this.name]];
                }
                formDataJson[this.name].push(this.value);
            } else {
                formDataJson[this.name] = this.value;
            }
        });

        $.ajax({
            url: '/UpdatePHP/class/Ajax.php',
            method: 'post',
            contentType: 'application/json',
            data: JSON.stringify({
                request: 'saveChanges',
                data: formDataJson
            }),
            success: function (data) {
                if (data == "1")
                {
                    Swal.fire({
                        title: "Değişiklikler Kaydedildi!",
                        icon: "success"
                    });
                    setTimeout(function (){window.location.reload()}, 1000);
                }
                else
                {
                    Swal.fire({
                        title: "Bir Sorun Oluştu!",
                        icon: "error"
                    });
                    setTimeout(function (){window.location.reload()}, 1000);
                }
            }
        });
    });
});


function addRow() {
    var fileInput = $('#fileInput').val();

    if (fileInput) {
        $('#submitFiles').removeClass('d-none').removeAttr('disabled');
        $('#fileInput').css('border', 'var(--bs-border-width) solid var(--bs-border-color)');
        $('.file-manager-table').removeClass('d-none');
        var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();
        var fileCell = newRow.insertCell(0);
        var deleteCell = newRow.insertCell(1);

        fileCell.innerHTML = `<input type="text" class="form-control" name="fileNames[]" value="${fileInput}">`;
        deleteCell.style.padding = '5px';
        deleteCell.innerHTML = `<button type="button" class="btn btn-danger" onclick="if (window.confirm('Silmek İstediğinize Emin misiniz?')) { $(this).closest('tr').remove();}"><i class="fa fa-trash" style=""></i></button>`;

        document.getElementById('fileInput').value = '';
    } else {
        $('#fileInput').css('border', '1px solid red');
    }
}



function addFtpRow() {
        var table = document.getElementById('ftpTable').getElementsByTagName('tbody')[0];
        var newRow = table.insertRow();
        var nameCell = newRow.insertCell(0);
        var urlCell = newRow.insertCell(1);
        var deleteCell = newRow.insertCell(2);

        var inputs = $('input[name="ftpId"]');
        var maxVal = -Infinity;

        inputs.each(function() {
            var val = parseFloat($(this).val());
            if (val > maxVal) {
                maxVal = val;
            }
        });

        nameCell.innerHTML = `<input type="hidden" name="ftpId" value="${maxVal + 1}"><input type="hidden" name="ftpStatu" value="1"><input type="text" class="form-control" name="ftpName">`;
        urlCell.innerHTML = `<input type="text" class="form-control" name="ftpUrl">`;
        deleteCell.innerHTML = `<button type="button" class="btn btn-danger" onclick="if (window.confirm('Silmek İstediğinize Emin misiniz?')) { $(this).closest('tr').remove();}"><i class="fa fa-trash" style=""></i></button>`;
}