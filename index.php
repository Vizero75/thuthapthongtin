<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Nhập Phiếu Thông Tin</title>
    <link rel="stylesheet" href="css/styles.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>

    <!-- Popper JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Nhập Thông Tin Phiếu Quà Tặng</h2>
        <button onclick="window.location.href='../nhanvien/login.php'">Đăng nhập Nhân viên</button>
        <form method="POST" action="index.php">
            <label for="ma_phieu">Mã Phiếu Thông Tin:</label>
            <input type="text" id="ma_phieu" name="ma_phieu" value="<?php echo isset($voucherData['MaPhieuThongTin']) ? $voucherData['MaPhieuThongTin'] : ''; ?>" required><br><br>

            <?php
            require_once __DIR__ . '/../src/models/VoucherModel.php';
            $voucherModel = new VoucherModel();
            $isLocked = false;

            if (isset($_POST['check_voucher'])) {
                $maPhieu = $_POST['ma_phieu'];
                $voucherData = $voucherModel->getVoucherByCode($maPhieu);
                $isLocked = $voucherModel->isVoucherLocked($maPhieu);

                if ($voucherData) {
                    if ($isLocked) {
                        echo "<p>Thông tin đã được xác nhận và không thể chỉnh sửa.</p>";
                    } else {
                        echo "<p>Mã Phiếu Thông Tin hợp lệ. Vui lòng điền các thông tin còn thiếu.</p>";
                    }
                } else {
                    echo "Mã Phiếu Thông Tin không tồn tại.";
                }
            }

            if (!$isLocked) {
            ?>
                <label for="ten_co_so">Tên Cơ Sở Bán Lẻ:</label>
                <input type="text" id="ten_co_so" name="ten_co_so" value="<?php echo isset($_POST['ten_co_so']) ? $_POST['ten_co_so'] : ''; ?>"><br><br>

                <label for="so_dien_thoai">Số Điện Thoại:</label>
                <input type="text" id="so_dien_thoai" name="so_dien_thoai" value="<?php echo isset($_POST['so_dien_thoai']) ? $_POST['so_dien_thoai'] : ''; ?>"><br><br>

                <label for="ten_chu_tai_khoan">Tên Chủ Tài Khoản:</label>
                <input type="text" id="ten_chu_tai_khoan" name="ten_chu_tai_khoan" value="<?php echo isset($_POST['ten_chu_tai_khoan']) ? $_POST['ten_chu_tai_khoan'] : ''; ?>"><br><br>

                <label for="ten_ngan_hang">Tên Ngân Hàng:</label>
                <input type="text" id="ten_ngan_hang" name="ten_ngan_hang" value="<?php echo isset($_POST['ten_ngan_hang']) ? $_POST['ten_ngan_hang'] : ''; ?>"><br><br>

                <label for="so_tai_khoan">Số Tài Khoản:</label>
                <input type="text" id="so_tai_khoan" name="so_tai_khoan" value="<?php echo isset($_POST['so_tai_khoan']) ? $_POST['so_tai_khoan'] : ''; ?>"><br><br>

                <label for="dia_chi_mua">Địa Chỉ Nơi Mua Sản Phẩm:</label>
                <input type="text" id="dia_chi_mua" name="dia_chi_mua" value="<?php echo isset($_POST['dia_chi_mua']) ? $_POST['dia_chi_mua'] : ''; ?>"><br><br>

                <button type="submit" name="save_voucher">Lưu Thông Tin</button>
            <?php } ?>
        </form>

        <?php
    if (isset($_POST['save_voucher']) && !$isLocked) {
    $maPhieu = $_POST['ma_phieu'];
    $tenCoSo = $_POST['ten_co_so'];
    $soDienThoai = $_POST['so_dien_thoai'];
    $tenChuTaiKhoan = $_POST['ten_chu_tai_khoan'];
    $tenNganHang = $_POST['ten_ngan_hang'];
    $soTaiKhoan = $_POST['so_tai_khoan'];
    $diaChiMua = $_POST['dia_chi_mua'];

    // Debug: In ra các giá trị
    echo "<pre>";
    echo "Mã Phiếu Thông Tin: $maPhieu\n";
    echo "Tên Cơ Sở Bán Lẻ: $tenCoSo\n";
    echo "Số Điện Thoại: $soDienThoai\n";
    echo "Tên Chủ Tài Khoản: $tenChuTaiKhoan\n";
    echo "Tên Ngân Hàng: $tenNganHang\n";
    echo "Số Tài Khoản: $soTaiKhoan\n";
    echo "Địa Chỉ Nơi Mua Sản Phẩm: $diaChiMua\n";
    echo "</pre>";

    // Nếu các giá trị không NULL, thực hiện cập nhật
    if ($maPhieu && $tenCoSo && $soDienThoai && $tenChuTaiKhoan && $tenNganHang && $soTaiKhoan && $diaChiMua) {
        $voucherModel->updateVoucherDetails($maPhieu, $tenCoSo, $soDienThoai, $tenChuTaiKhoan, $tenNganHang, $soTaiKhoan, $diaChiMua);
        $voucherModel->lockVoucher($maPhieu);
        echo "Thông tin phiếu đã được lưu thành công và dữ liệu đã bị khóa.";
    } else {
        echo "Có lỗi xảy ra, một hoặc nhiều trường không có giá trị.";
    }
}

        ?>
    </div>
</body>
</html>
