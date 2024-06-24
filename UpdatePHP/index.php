<?php
define("PATH", realpath('.'));


require_once PATH . '/class/run.php';

$FtpToUpdate = new ClientDal();
$FtpData = $FtpToUpdate->GetAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <?php include PATH. '/app/require/data/head.php';?>
</head>
<body>
<div class="ftp-manager ">
    <button type="button" class="rounded p-2 next-step position-absolute  top-0 end-0 m-3"
            onclick="$('.ftp-table-area').toggleClass('d-none')">Güncellenecek Ftp'ler
    </button>
    <div class="ftp-table-area border d-none rounded p-3 position-absolute bg-white m-3 w-50"
         style="top: 80px; right: 100px; z-index: 4;">
        <div class="d-flex w-100 align-items-end justify-content-between  p-3">
            <span class="fs-5 fw-bold">Güncelleme Yapılacak Ftp Listesi</span>
            <button type="button" class="btn btn-success" data-bs-toggle="tooltip" onclick="addFtpRow()" data-bs-placement="top" data-bs-title="Yeni Ftp Ekle"><i class="fa fa-plus"></i></button>
        </div>
        <form action="" method="post" class="ftp-form">
            <table class="table" id="ftpTable">
                <thead class="bg-light">
                <th class="p-4">Ftp Adı</th>
                <th class="p-4">Url</th>
                <th class="p-4">İşlem</th>
                </thead>
                <tbody>
                <?php foreach ($FtpData['FtpsToUpdate'] as $ftp => $value): ?>
                    <tr>
                        <input type="hidden" name="ftpId" value="<?= $value['id'] ?>">
                        <input type="hidden" name="ftpStatu" value="<?= $value['Status'] ?>">
                        <td class="p-2 text-center"><input type="text" name="ftpName" class="form-control" value="<?= $value['FtpName'] ?>"></td>
                        <td class="p-2 text-center"><input type="text" name="ftpUrl" class="form-control w-100" value="<?= $value['Domain'] ?>">
                        </td>
                        <td class="p-2 text-center">
                            <button type="button" data-ftp="<?= $value['id'] ?>"
                                    class="btn <?php echo $value['Status'] == 1 ? 'btn-secondary ' : 'btn-success'; ?> play-btn">
                                <i class="fa <?php echo $value['Status'] == 1 ? 'fa-pause ' : 'fa-play'; ?> "></i>
                            </button>

                            <button type="button" class="btn btn-danger" onclick="if (window.confirm('Silmek İstediğinize Emin misiniz?')) { $(this).closest('tr').remove();}"><i class="fa fa-trash" style=""></i></button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <div class="d-flex align-items-center justify-content-center">
                <button type="submit" name="ftp-btn" class="form-element rounded p-2 next-step">Değişiklikleri Kaydet</button>
            </div>
        </form>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="form-section">
                <form action="" method="post">
                    <button type="button" class="bg-transparent position-absolute top-0 end-0 m-3 border-0"
                            onclick="window.dialog.showModal();" data-bs-toggle="tooltip" data-bs-placement="top"
                            data-bs-title="Update PHP Hakkında Bilgi Almak İçin Tıklayınız"><img
                                src="cdn/img/request.svg" alt="" width="24"></button>
                    <h1 class="fw-bold title-php">UPDATE PHP ' YE HOŞGELDİNİZ!</h1>

                    <span class="p-3 mt-4 text-center info-section text-white rounded text-wrap">Devam edebilmek için lütfen güncelleme yaptığınız web projesinin domain kısmını giriniz. (örn: www.example.com)</span>

                    <div class="form-group">
                        <input type="text" name="updatedClient" class="form-element mt-5  py-2 px-5"
                               placeholder="www.example.com">
                    </div>
                    <div class="form-group">
                        <button type="button" class="form-element next-step mt-3  py-2 px-4" id="nextStep">İlerle &nbsp;<i
                                    class="fas fa-arrow-right-long"></i></button>
                    </div>

                    <div class="file-manager mt-5 border rounded p-3">
                        <div class="form-group d-flex gap-3 align-items-center justify-content-center">
                            <input type="text" name="fileNames" id="fileInput" class="form-element   py-2 px-5"
                                   placeholder="örn: index.php">
                            <button type="button" class="btn btn-success" onclick="addRow()"><i class="fas fa-plus"></i>
                            </button>
                        </div>

                        <div class="file-manager-table d-none">
                            <table class="table w-100" id="dataTable">
                                <thead>
                                <th>Dosya Adı</th>
                                <th>İşlem</th>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>


                        <div class="form-group ">
                            <button type="submit" id="submitFiles" disabled
                                    class="form-element next-step mt-3  py-2 px-4 d-none">Gönder
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</body>

<?php include PATH. '/app/require/data/js.php';?>

<?php include PATH. '/app/require/inc/info-diolog.php';?>

</html>



<?php
if ($_POST) {
    $fileNames = implode(",", $_POST["fileNames"]);
    $index = new Index();
    $response = $index->visitUpdatedFtp($fileNames, $_POST['updatedClient']);


    if (!empty($response)):?>
        <button class="modal-btn bg-transparent border-0" data-bs-target="#exampleModalToggle"
                data-bs-toggle="modal"></button>

        <div class="modal fade" id="exampleModalToggle" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Dosyalarınız Sunuculara Gönderildi</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                        foreach ($response as $key => $value):
                            ?>
                            <span class="fs-2 fw-bold border-bottom w-100 d-flex mt-3"><?= $key ?></span>
                            <?php
                            foreach ($value as $item => $data):
                                ?>
                                <?php foreach ($data as $messages): ?>
                                <div class="<?php echo $item == 'error' ? 'bg-danger ' : 'bg-success'; ?> p-3 mt-3 rounded text-white">
                                    <span><b><?= $messages['fileName'] ?> :</b> <?= $messages['message'] ?></span>
                                </div>
                            <?php endforeach; ?>
                            <?php endforeach; ?>

                        <?php endforeach; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                    </div>
                </div>
            </div>
        </div>
        <script>$('.modal-btn').trigger('click');</script>

    <?php
    endif;
}
?>

