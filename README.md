<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel


## Hướng dẫn cài đặt

### Yêu cầu hệ thống
- PHP >= 8.2
- Composer
- Node.js & npm

### Các bước cài đặt

1. **Clone dự án & cài đặt các package PHP:**
   ```bash
   composer install
   ```

2. **Cài đặt các package Node.js:**
   ```bash
   npm install
   ```

3. **Tạo file môi trường:**
   ```bash
   cp .env.example .env
   ```
   Sau đó chỉnh sửa các thông số kết nối database trong file `.env`.

4. **Tạo key ứng dụng & migrate database:**
   ```bash
   php artisan key:generate
   php artisan migrate
   ```

5. **Chạy server:**
   - Chạy backend Laravel:
     ```bash
     php artisan serve
     ```
   - Chạy frontend (Vite):
     ```bash
     npm run dev
     ```
   - Hoặc chạy đồng thời cả hai:
     ```bash
     composer run dev
     ```

---

## Các chức năng chính

### Người dùng
- Đăng ký, đăng nhập, đăng xuất
- Xem danh sách sản phẩm
- Thêm sản phẩm vào giỏ hàng
- Xem giỏ hàng
- Đặt hàng và xem lịch sử đơn hàng
- Xem thông tin cá nhân 

### Quản trị viên (Admin)
- Quản lý sản phẩm
- Quản lý đơn hàng
- Quản lý người dùng

### Phân quyền
- Người dùng thông thường chỉ có thể truy cập các chức năng cơ bản như xem sản phẩm, giỏ hàng, đặt hàng và quản lý thông tin cá nhân.
- Người dùng có quyền admin (is_admin = 1) có thể truy cập vào trang quản trị để quản lý sản phẩm, đơn hàng và người dùng.
- Nếu người dùng không có quyền admin cố gắng truy cập vào trang quản trị, họ sẽ bị chuyển hướng về trang sản phẩm với thông báo lỗi.
