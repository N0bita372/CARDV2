<?php
    /**
     * Dear quý khách hàng CMSNT - Vui lòng không phát hành chúng mà không có giấy phép từ chúng tôi.
     * Chúng tôi xin cảm ơn quý khách hàng đã tin và sử dụng sản phẩm này, hẹn quý khách hàng ở các sản phẩm tốt hơn về sau.
     */
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login-admin.php");
    $title = 'KHO THẺ CÀO  | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
    require_once(__DIR__."/../../includes/checkLicense.php");
?>
<?php

if(!$row = $CMSNT->get_row("SELECT * FROM `sellcards` WHERE `id` = '".check_string($_GET['id'])."' AND `sellcard_id` != 0 "))
{
    die('<script type="text/javascript">if(!alert("Loại thẻ không tồn tại trong hệ thống")){window.history.back().location.reload();}</script>');
}
if(isset($_POST['btnImport']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        die('<script type="text/javascript">if(!alert("Chức năng này không khả dụng trên trang web demo")){window.history.back().location.reload();}</script>');
    }
    $listImport = explode(PHP_EOL, check_string($_POST['card']));
    $success=0;
    $error=0;
    foreach($listImport as $card)
    {
        $CMSNT->insert("storecards", [
            'sellcard_id' => $row['id'],
            'card' => $card,
            'createdate' => gettime(),
            'updatedate' => gettime()
        ]) ? $success++ : $error++; 
    }
    die('<script type="text/javascript">if(!alert("Nhập thành công '.$success.' thẻ, thất bại '.$error.' thẻ ! ")){window.history.back().location.reload();}</script>');
}
if(isset($_POST['btnRemove']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        die('<script type="text/javascript">if(!alert("Chức năng này không khả dụng trên trang web demo")){window.history.back().location.reload();}</script>');
    }
    $listRemove = explode(PHP_EOL, check_string($_POST['card']));
    $success=0;
    $error=0;
    foreach($listRemove as $card)
    {
        $CMSNT->remove("storecards", " `card` = '$card' ") ? $success++ : $error++;
    }
    die('<script type="text/javascript">if(!alert("Xoá thành công '.$success.' thẻ, thất bại '.$error.' thẻ ! ")){window.history.back().location.reload();}</script>');
}
if(isset($_POST['btnSaveTheCao']) && $getUser['level'] == 'admin')
{
    if($CMSNT->site('status_demo') == 'ON')
    {
        die('<script type="text/javascript">if(!alert("Chức năng này không khả dụng trên trang web demo")){window.history.back().location.reload();}</script>');
    }
    $isUpdate = $CMSNT->update("storecards", [
        'card' => check_string($_POST['card'])
    ], " `id` = '".check_string($_POST['id'])."' ");
    if($isUpdate)
    {
        die('<script type="text/javascript">if(!alert("Lưu thành công!")){window.history.back().location.reload();}</script>');
    }
    else
    {
        die('<script type="text/javascript">if(!alert("Lưu thất bại!")){window.history.back().location.reload();}</script>');
    }
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý kho thẻ <b
                            style="color: blue;"><?=$CMSNT->get_row("SELECT * FROM `sellcards` WHERE `id` = '".$row['sellcard_id']."' ")['name'];?></b>
                        - <b style="color: red;"><?=$row['name'];?></b></h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-danger float-right" href="<?=BASE_URL('Admin/SellCard');?>"><i
                            class="fas fa-undo mr-1"></i>Quay lại</a>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <section class="col-lg-6 connectedSortable">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-plus mr-1"></i>Nhập thẻ cào</h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Danh sách thẻ cần thêm</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="card"
                                        placeholder="Định dạng SERI|PIN (1 dòng 1 thẻ)" rows="7" required></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <button type="submit" name="btnImport" class="btn btn-primary">
                                <span><i class="fas fa-plus mr-1"></i>Thêm ngay</span></button>
                        </div>
                    </form>
            </section>
            <section class="col-lg-6 connectedSortable">
                <div class="card card-danger card-outline">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-trash mr-1"></i>Xoá thẻ cào</h3>
                        <div class="card-tools">
                            <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i>
                            </button>
                            <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <form action="" method="POST">
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Danh sách thẻ cần xoá</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="card"
                                        placeholder="Định dạng SERI|PIN (1 dòng 1 thẻ)" rows="7" required></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <button type="submit" name="btnRemove" class="btn btn-primary">
                                <span><i class="fas fa-trash mr-1"></i>Xoá ngay</span></button>
                        </div>
                    </form>
            </section>
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">DANH SÁCH THẺ CÀO</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <p>- Thẻ có <b>Username</b> trống là thẻ đang bán.</p>
                        <p>- Vui lòng không xoá thẻ đã bán tránh user không xem được lịch sử.</p>
                        <p>- <b>Updatedate</b> là thời gian user mua thẻ, mặc định là thời gian đưa thẻ lên hệ thống.
                        </p>
                        <div class="table-responsive">
                            <table id="datatable" class="table table-bordered table-striped dataTable">
                                <thead>
                                    <tr>
                                        <th width="10px;">#</th>
                                        <th>Username</th>
                                        <th>Card</th>
                                        <th>Createdate</th>
                                        <th>Updatedate</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach($CMSNT->get_list(" SELECT * FROM `storecards` WHERE `sellcard_id` = '".$row['id']."'  ORDER BY id DESC ") as $log){
                                    ?>
                                    <tr>
                                        <td><?=$i++;?></td>
                                        <td><a
                                                href="<?=BASE_URL('Admin/User/Edit/'.getUser($log['username'], 'id'));?>"><?=$log['username'];?></a>
                                        </td>
                                        <td><?=$log['card'];?></td>
                                        <td><?=$log['createdate'];?></td>
                                        <td><?=$log['updatedate'];?></td>
                                        <td>
                                            <button
                                                onclick="editRow(`<?=$log['id'];?>`, `<?=$log['card'];?>`)"
                                                class="btn btn-primary btn-sm"><i class="far fa-edit mr-1"></i>Chỉnh
                                                sửa</button>
                                            <button onclick="removeRow(<?=$log['id'];?>)"
                                                class="btn btn-danger btn-sm"><i
                                                    class="fas fa-trash-alt mr-1"></i>Xoá</button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="far fa-edit mr-1"></i>Chỉnh sửa chi tiết thẻ cào</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Thông tin thẻ cào</label>
                        <div class="col-sm-8">
                            <div class="form-line">
                                <input type="hidden" name="id" id="id" class="form-control" required>
                                <textarea class="form-control" rows="5" id="card" name="card" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnSaveTheCao" class="btn btn-danger"><i class="fas fa-save mr-1"></i>Lưu
                        ngay</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                            class="fas fa-times-circle mr-1"></i>Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<script type="text/javascript">
function editRow(id, card) {
    $("#card").val(card);
    $("#id").val(id);
    $("#modalEdit").modal();
    return false;
}
function removeRow(id) {
    Swal.fire({
        text: "Bạn có chắc chắn muốn xoá thẻ này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Huỷ'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?=BASE_URL("assets/ajaxs/admin/removeStoreCard.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        Swal.fire(
                            'Hoàn tất',
                            respone.msg,
                            'success'
                        );
                        location.reload();
                    } else {
                        Swal.fire(
                            'Thất bại',
                            respone.msg,
                            'error'
                        );
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>
<script>
$(function() {
    $("#datatable").DataTable({
        "responsive": false,
        "autoWidth": false,
    });
});
</script>





<?php 
    require_once("../../public/admin/Footer.php");
?>