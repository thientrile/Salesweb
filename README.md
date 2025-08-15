# Salesweb

Website bán hàng demo (PHP + MySQL) với cấu trúc MVC tối giản.

> Mục tiêu: dễ đọc, dễ chạy local, dễ mở rộng module (sản phẩm, danh mục, giỏ hàng, đơn hàng… tuỳ bạn phát triển thêm).

---

## 🧭 Mục lục

- [Tính năng](#tính-năng)
- [Kiến trúc & Thư mục](#kiến-trúc--thư-mục)
- [Yêu cầu hệ thống](#yêu-cầu-hệ-thống)
- [Cách chạy nhanh (Windows/macOS/Linux)](#cách-chạy-nhanh-windowsmacoslinux)
- [Cấu hình CSDL](#cấu-hình-csdl)
- [Quy ước code](#quy-ước-code)
- [Lộ trình phát triển gợi ý](#lộ-trình-phát-triển-gợi-ý)
- [Đóng góp](#đóng-góp)
- [Bản quyền](#bản-quyền)

---

## ✨ Tính năng

> **Hiện là khung sườn** để bạn build thành web bán hàng hoàn chỉnh. Repo đã có:
- Trang vào qua `index.php` (front controller).
- Bộ router/handler dùng `server.php` để chạy bằng PHP built-in server (hữu ích khi dev).
- Tách lớp **Controller / Model / View**.
- Thư mục `Mysql/` chứa script SQL (schema/seed) để import nhanh.
- Tĩnh: `assets/` (CSS/JS/ảnh). Repo có cả SCSS/LESS để bạn build CSS nếu muốn.

> Tuỳ tiến độ của bạn, tick dần:
- [ ] Danh mục & Sản phẩm (CRUD)
- [ ] Giỏ hàng (session)
- [ ] Đặt hàng/Hoá đơn
- [ ] Auth (đăng ký/đăng nhập)
- [ ] Admin panel (quản trị)

---
├─ assets/ # CSS/JS/ảnh tĩnh (có SCSS/LESS nếu cần build)
├─ controller/ # Lớp điều khiển - nhận request, gọi model, render view
├─ model/ # Truy vấn DB & logic nghiệp vụ
├─ view/ # Template hiển thị (PHP/HTML)
├─ Mysql/ # Script .sql (schema/seed) để import MySQL
├─ index.php # Front controller (điểm vào ứng dụng)
├─ server.php # Router cho PHP built-in server (dev)
└─ run.bat # Batch script chạy nhanh trên Windows


> Lưu ý: tên file cấu hình DB có thể nằm trong `model/` hoặc được require từ `server.php`. Xem ghi chú phần [Cấu hình CSDL](#cấu-hình-csdl).

---

## 🧰 Yêu cầu hệ thống

- PHP **8.x** (khuyến nghị)
- MySQL/MariaDB **10.x+**
- Trình duyệt bất kỳ (Chrome/Edge/Firefox)
- (Tuỳ chọn) XAMPP/Laragon nếu bạn thích chạy kiểu Apache + PHP

---

## 🚀 Cách chạy nhanh (Windows/macOS/Linux)

### 1) Clone mã nguồn
```bash
git clone https://github.com/thientrile/Salesweb.git
cd Salesweb

2) Tạo database & import dữ liệu

Tạo một database, ví dụ: salesweb

Vào thư mục Mysql/ và import các file .sql vào database vừa tạo (schema + dữ liệu mẫu nếu có).

3) Cấu hình kết nối DB

Mở file cấu hình kết nối (thường nằm trong model/ hoặc được include từ server.php).

Cập nhật các biến:

$DB_HOST = '127.0.0.1';
$DB_NAME = 'salesweb';
$DB_USER = 'root';
$DB_PASS = '';
$DB_CHARSET = 'utf8mb4';


Nếu repo có sẵn file ví dụ như config.example.php, hãy copy thành config.php rồi chỉnh.

4) Chạy local

Cách A – Windows (khuyến nghị, nhanh gọn)

Double-click run.bat (hoặc mở cmd tại thư mục dự án và gõ run.bat)

Cách B – PHP built-in server

# Chạy ở cổng 8000, router qua server.php
php -S 127.0.0.1:8000 server.php


Mở trình duyệt: http://127.0.0.1:8000

Cách C – XAMPP/Laragon

Đặt thư mục dự án vào htdocs (XAMPP) hoặc www (Laragon)

Truy cập: http://localhost/Salesweb/

⚙️ Cấu hình CSDL

Kết nối: dùng PDO/MySQLi (tuỳ file trong model/), đảm bảo charset utf8mb4.

Import: mọi script .sql nằm trong Mysql/. Import theo thứ tự: schema trước, seed sau.

Quyền: tài khoản MySQL có quyền CREATE/ALTER/INSERT/SELECT/UPDATE/DELETE.

Tip: Nếu lỗi Access denied hoặc Unknown database, kiểm tra lại tên DB & user/password, hoặc cấp quyền bằng:

CREATE DATABASE salesweb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON salesweb.* TO 'root'@'localhost' IDENTIFIED BY '';
FLUSH PRIVILEGES;

📝 Quy ước code

Controller: chỉ điều phối, không nhét logic nặng.

Model: mọi truy vấn DB/logic nghiệp vụ đặt ở đây; trả về dữ liệu sạch.

View: HTML/PHP tối giản; tránh truy vấn DB trực tiếp.

Assets: nếu chỉnh .scss/.less, hãy build ra .css trước khi commit (tuỳ công cụ bạn dùng: Dart Sass, Lessc, v.v.).

🗺️ Lộ trình phát triển gợi ý

 Middleware auth + CSRF token cho form

 Cart lưu session + đồng bộ DB khi đăng nhập

 Phân trang, tìm kiếm, lọc theo danh mục/giá

 Upload ảnh sản phẩm (validate & nén ảnh)

 Module Admin: quản lý sản phẩm, đơn hàng, người dùng

 Đa ngôn ngữ (vi/en)

🤝 Đóng góp

PR/Issue đều welcome. Quy ước:

Tạo nhánh theo kiểu feature/<ten-feature> hoặc fix/<mo-ta>.

Mô tả rõ thay đổi + ảnh minh hoạ (nếu là UI).

Viết ngắn gọn, commit nhỏ gọn, có mô tả.

📄 Bản quyền

Chưa khai báo license. Nếu bạn muốn mở nguồn: thêm LICENSE (MIT/Apache-2.0…).


> Ghi chú nguồn: cấu trúc thư mục và file được lấy từ trang code của repo (liệt kê `controller/`, `model/`, `view/`, `Mysql/`, `assets/`, `index.php`, `run.bat`, `server.php`). GitHub cũng hiển thị phần “Sales Website” và biểu đồ ngôn ngữ (JS/CSS/SCSS/LESS/HTML + Hack/PHP). :contentReference[oaicite:2]{index=2} :contentReference[oaicite:3]{index=3}

Nếu muốn, mình có thể chỉnh README theo **đúng tên file cấu hình DB** trong dự án của bạn (ví dụ `model/Database.php` hay `config.php`) và thêm **ảnh chụp màn hình** để nhìn “xịn” hơn.
::contentReference[oaicite:4]{index=4}
## 🧱 Kiến trúc & Thư mục

