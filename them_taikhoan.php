<?php
require_once __DIR__ . '/../DB/DBConnect.php';
require_once __DIR__ . '/../model/User.php';

$conn = new DBConnect();
$model = new User($conn->getConnection());
$userModel = $model->getTeacherNoUserUpdate();


$content = '
<div>
<div class="pass-text">
    <p>Thêm tài khoản</p>
</div>
</div>
<div id="password-form">
<form action="../../controller/UserController.php?action=insert" method="post">

    <label for="username">Nhập tài khoản</label>
    <input type="text" name="username" id="username" value="' . (isset($firstrow['ma_gv']) ? $firstrow['ma_gv'] : '') . '"><br>
    <p class="error-p">';
if (isset($_SESSION["error_username"])) {
    $content .= $_SESSION["error_username"];
    unset($_SESSION["error_username"]);
}
$content .= '</p>
    <label for="password">Nhập mật khẩu</label>
    <input type="password" name="password" id="password"><br>
    <p class="error-p">';
if (isset($_SESSION["error_password"])) {
    $content .= $_SESSION["error_password"];
    unset($_SESSION["error_password"]);
}
$content .= '</p>
    <label for="role">Chọn quyền</label>
    <select name="role" id="role">
        <option value="admin">Admin</option>
        <option value="user">User</option>
    </select><br>
    <label for="">Trạng thái hoạt động</label>
    <select name="status" id="status">
        <option value="1">Hoạt động</option>
        <option value="0">Không hoạt động</option>
    </select><br>
    <label for="giangvien">Giảng viên</label>
    <select name="giangvien" id="giangvien" <?php echo $_SESSION[\'khoa\'] ?>>
<option value="">Vui lòng chọn giảng viên</option>';
foreach ($userModel as $user) {
    $content .= '<option value="' . $user['ma_gv'] . '">' . $user['ho_lot_gv'] . ' ' . $user['ten_gv'] . '</option>';
}
$content .= '</select>
<p class="error-p">';
if (isset($_SESSION["thongbao"])) {
    $content .= $_SESSION["thongbao"];
    unset($_SESSION["thongbao"]);
}
$content .= '</p>
<br>
<button type="submit" name="submit" id="loginButton" class="btn btn-primary">Thêm</button>';
$content .= '
</form>
<script src="../js/them_tk.js"></script>
<script>
document.addEventListener("click", function() {
    const giangvienSelect = document.getElementById("giangvien");
    const usernameInput = document.getElementById("username");
    giangvienSelect.addEventListener("change", function() {
        usernameInput.value = this.value;
    });
});
</script>
</div>
';

include '../view/admin/sua_taikhoan.php';
