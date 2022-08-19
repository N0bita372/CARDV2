<?php
    /**
     * Dear quý khách hàng CMSNT - Vui lòng không phát hành chúng mà không có giấy phép từ chúng tôi.
     * Chúng tôi xin cảm ơn quý khách hàng đã tin và sử dụng sản phẩm này, hẹn quý khách hàng ở các sản phẩm tốt hơn về sau.
     */
    require_once(__DIR__."/../../config/config.php");
    require_once(__DIR__."/../../config/function.php");
    require_once(__DIR__."/../../includes/login-admin.php");
    $title = 'QUẢN LÝ KHO THẺ CÀO | '.$CMSNT->site('tenweb');
    require_once(__DIR__."/Header.php");
    require_once(__DIR__."/Sidebar.php");
    require_once(__DIR__."/../../includes/checkLicense.php");
?>
<?php
if(isset($_POST['btnSaveOption']) && $getUser['level'] == 'admin')
{
    foreach ($_POST as $key => $value)
    {
        $CMSNT->update("options", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    admin_msg_success('Lưu thành công', '', 500);
}
if(isset($_POST['btnSave']) && $getUser['level'] == 'admin')
{
    if($CMSNT->get_row("SELECT * FROM `sellcards` WHERE `id` = '".check_string($_POST['sellcard_id'])."' ")['sellcard_id'] != 0 )
    {
        die('<script type="text/javascript">if(!alert("Chỉ được chọn loại thẻ để làm nhóm chính")){window.history.back().location.reload();}</script>');
    }
    $isUpdate = $CMSNT->update("sellcards", [
        'name' => check_string($_POST['name']),
        'ck' => check_string($_POST['ck']),
        'sellcard_id' => check_string($_POST['sellcard_id'])
    ], " `id` = '".check_string($_POST['id'])."' ");
    if($isUpdate)
    {
        admin_msg_success('Lưu thành công', '', 500);
    }
    else
    {
        die('<script type="text/javascript">if(!alert("Lưu thất bại")){window.history.back().location.reload();}</script>');
    }

}
if(isset($_POST['btnAdd']) && $getUser['level'] == 'admin')
{
    if($CMSNT->get_row("SELECT * FROM `sellcards` WHERE `id` = '".check_string($_POST['sellcard_id'])."' ")['sellcard_id'] != 0 )
    {
        die('<script type="text/javascript">if(!alert("Chỉ được chọn loại thẻ để làm nhóm chính")){window.history.back().location.reload();}</script>');
    }
    $isInsert = $CMSNT->insert("sellcards", [
        'name' => check_string($_POST['name']),
        'ck' => check_string($_POST['ck']),
        'sellcard_id' => check_string($_POST['sellcard_id'])
    ]);
    if($isInsert)
    {
        admin_msg_success('Thêm thành công', '', 500);
    }
    else
    {
        die('<script type="text/javascript">if(!alert("Thêm thất bại")){window.history.back().location.reload();}</script>');
    }
    
}
?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý kho thẻ</h1>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CẤU HÌNH MUA THẺ</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">ON/OFF Mua thẻ</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="status_muathe" required>
                                        <option value="<?=$CMSNT->site('status_muathe');?>">
                                            <?=$CMSNT->site('status_muathe');?>
                                        </option>
                                        <option value="ON">ON</option>
                                        <option value="OFF">OFF</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Server Bán thẻ</label>
                                <div class="col-sm-9">
                                    <select class="form-control show-tick" name="server_buycard" required>
                                        <option <?=$CMSNT->site('server_buycard') == 1 ? 'selected' : '';?> value="1">
                                            Từ trong kho
                                        </option>
                                        <option <?=$CMSNT->site('server_buycard') == 0 ? 'selected' : '';?> value="0">
                                            Từ API
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">LƯU Ý MUA THẺ</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Lưu ý mua thẻ</label>
                                <div class="col-sm-9">
                                <textarea class="textarea" name="notice_buycard"
                                            rows="6"><?=$CMSNT->site('notice_buycard');?></textarea>
                                </div>
                            </div>
                            <button type="submit" name="btnSaveOption" class="btn btn-primary btn-block">
                                <span>LƯU</span></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div style="float:right;padding: 10px;">
                    <button type="button" data-toggle="modal" data-target="#ThemLoaiThe" class="btn btn-info btn-sm"><i
                            class="fas fa-plus"></i> <span>Thêm loại thẻ</span>
                        </butt>
                </div>
                <div class="modal fade" id="ThemLoaiThe" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel"><i class="fas fa-plus mr-1"></i>Thêm loại
                                    thẻ </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-window-close"></i>
                                </button>
                            </div>
                            <form action="" method="POST">
                                <div class="modal-body">
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Chọn nhóm</label>
                                        <div class="col-sm-9">
                                            <select class="form-control show-tick" name="sellcard_id" required>
                                                <option value="0">Nhóm cha</option>
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `sellcards` WHERE `sellcard_id` = 0 ") as $row){?>
                                                <option option value="<?=$row['id'];?>"><?=$row['name'];?></option>
                                                <?php foreach($CMSNT->get_list("SELECT * FROM `sellcards` WHERE `sellcard_id` = '".$row['id']."' ") as $row1){?>
                                                <option value="<?=$row1['id'];?>">__<?=$row1['name'];?></option>
                                                <?php }?>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Name</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="text" name="name"
                                                    placeholder="Nhập tên loại thẻ hoặc mệnh giá" class="form-control"
                                                    required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Chiết khấu</label>
                                        <div class="col-sm-9">
                                            <div class="form-line">
                                                <input type="text" name="ck" placeholder="Nhập chiết khấu mua thẻ"
                                                    class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="btnAdd" class="btn btn-danger">
                                        <i class="fas fa-plus mr-1"></i>Thêm ngay</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                            class="fas fa-times-circle mr-1"></i>Đóng</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-12">
                        <?php foreach($CMSNT->get_list(" SELECT * FROM `sellcards` WHERE `sellcard_id` = 0 ") as $row){ ?>
                        <div class="timeline">
                            <div class="time-label">
                                <button class="btn btn-success btn-sm"><i
                                        class="fas fa-address-card mr-1"></i><?=$row['name'];?></button>
                                <button
                                    onclick="editRow(<?=$row['id'];?>, <?=$row['sellcard_id'];?>, '<?=$row['name'];?>', <?=$row['ck'];?>)"
                                    class="btn btn-primary btn-sm"><i class="far fa-edit mr-1"></i>Chỉnh sửa</button>
                                <button onclick="removeRow(<?=$row['id'];?>)" class="btn btn-danger btn-sm"><i
                                        class="fas fa-trash-alt mr-1"></i>Xoá</button>
                            </div>
                            <?php foreach($CMSNT->get_list(" SELECT * FROM `sellcards` WHERE `sellcard_id` = '".$row['id']."' ORDER BY `name` ASC ") as $row){ ?>
                            <div>
                                <i class="fas fa-sd-card bg-danger"></i>
                                <div class="timeline-item">
                                    <h3 class="timeline-header">Mệnh giá: <b
                                            style="color: blue;"><?=format_cash($row['name']);?></b> | Chiết
                                        khấu: <b style="color: red;"><?=$row['ck'];?>%</b></h3>
                                    <div class="timeline-body">
                                        <ul>
                                            <li>Thẻ trong kho:
                                                <b style="color: blue;">
                                                    <?=format_cash($CMSNT->num_rows("SELECT * FROM `storecards` WHERE `sellcard_id` = '".$row['id']."' "));?>
                                                </b>
                                            </li>
                                            <li>Thẻ đã bán:
                                                <b
                                                    style="color: green;"><?=format_cash($CMSNT->num_rows("SELECT * FROM `storecards` WHERE `sellcard_id` = '".$row['id']."' AND `username` IS NOT NULL "));?></b>
                                            </li>
                                            <li>Thẻ đang bán:
                                                <b
                                                    style="color: red;"><?=format_cash($CMSNT->num_rows("SELECT * FROM `storecards` WHERE `sellcard_id` = '".$row['id']."' AND `username` IS NULL "));?></b>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="timeline-footer">
                                        <a href="<?=BASE_URL('Admin/StoreCard/'.$row['id']);?>"
                                            class="btn btn-success btn-sm"><i class="fas fa-store mr-1"></i>Kho thẻ</a>
                                        <button
                                            onclick="editRow(<?=$row['id'];?>, <?=$row['sellcard_id'];?>, '<?=$row['name'];?>', <?=$row['ck'];?>)"
                                            class="btn btn-primary btn-sm"><i class="far fa-edit mr-1"></i>Chỉnh
                                            sửa</button>
                                        <button onclick="removeRow(<?=$row['id'];?>)" class="btn btn-danger btn-sm"><i
                                                class="fas fa-trash-alt mr-1"></i>Xoá</button>
                                    </div>
                                </div>
                            </div>
                            <?php } }?>
                            <div>
                                <i class="fas fa-clock bg-gray"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</div>
</section>
</div>

<!-- Modal -->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel"><i class="far fa-edit mr-1"></i>Chỉnh sửa loại thẻ</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-window-close"></i>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nhóm</label>
                        <div class="col-sm-8">
                            <select class="form-control show-tick" name="sellcard_id" id="sellcard_id" required>
                                <option value="0">Nhóm cha</option>
                                <?php foreach($CMSNT->get_list("SELECT * FROM `sellcards` WHERE `sellcard_id` = 0 ") as $row){?>
                                <option option value="<?=$row['id'];?>"><?=$row['name'];?></option>
                                <?php foreach($CMSNT->get_list("SELECT * FROM `sellcards` WHERE `sellcard_id` = '".$row['id']."' ") as $row1){?>
                                <option value="<?=$row1['id'];?>">__<?=$row1['name'];?></option>
                                <?php }?>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <div class="form-line">
                                <input type="hidden" name="id" id="id" class="form-control" required>
                                <input type="text" name="name" id="name" placeholder="Nhập tên loại thẻ hoặc mệnh giá"
                                    class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Chiết khấu</label>
                        <div class="col-sm-8">
                            <div class="form-line">
                                <input type="text" name="ck" id="ck" id="Nhập chiết khấu mua" class="form-control"
                                    required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="btnSave" class="btn btn-danger"><i class="fas fa-save mr-1"></i>Lưu
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
function editRow(id, sellcard_id, name, ck) {
    $("#sellcard_id").val(sellcard_id);
    $("#name").val(name);
    $("#id").val(id);
    $("#ck").val(ck);
    $("#modalEdit").modal();
    return false;
}

function removeRow(id) {
    Swal.fire({
        text: "Bạn có chắc chắn muốn xoá loại thẻ này không?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý',
        cancelButtonText: 'Huỷ'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "<?=BASE_URL("assets/ajaxs/admin/removeSellCard.php");?>",
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
        "responsive": true,
        "autoWidth": false,
    });
});
</script>
<script>
$(function() {
    // Summernote
    $('.textarea').summernote()
})
</script>




<?php 
    require_once("../../public/admin/Footer.php");
?>