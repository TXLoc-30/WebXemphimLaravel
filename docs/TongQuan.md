# Tổng quan dự án

_Dự án là một hệ thống quản lý và xem phim trực tuyến, được xây dựng trên framework Laravel. Nó bao gồm các thành phần chính như quản lý người dùng, phim, danh mục, quốc gia, ngôn ngữ, và các giao dịch liên quan đến ví điện tử. Dự án có cấu trúc thư mục chuẩn của Laravel, kết hợp với các tệp SQL để quản lý cơ sở dữ liệu._

## Các chức năng chính

>#### 1\. Người dùng
>
>> Đăng ký/Đăng nhập
>> Xem phim
>>Ví tiền ( nạp tiền, mua phim)
>>Bình luận
>>Tủ phim cá nhân

>#### 2\. Quản trị viên (Admin)
>
>>Quản lý phim ( Thêm, sửa, xoá )
>>Quản lý người dùng
>>Quản lý bình luận
>>Thông kê trang web
>>Xác nhận thanh toán

## Các công nghệ sử dụng

#### 1\. Framework
- Laravel: Đây là framework chính được sử dụng trong dự án, thể hiện qua các thư mục như app, routes, config, và các tệp như artisan, composer.json.
- Bootstrap: Được sử dụng để xây dựng giao diện người dùng, thể hiện qua các tệp CSS như bootstrap.css trong thư mục public.

#### 2\. Ngôn ngữ lập trình
- PHP: Là ngôn ngữ chính của dự án, được sử dụng trong các tệp như Controllers, php, và các tệp SQL được xử lý thông qua PHP.
- JavaScript: Được sử dụng cho các tính năng giao diện động, thể hiện qua các tệp như ckeditor và các đoạn mã trong tệp PHP.
- HTML/CSS/ jQuery: Được sử dụng để xây dựng giao diện và trải nghiệm cho người dùng.
#### 3\. Cơ sở dữ liệu
- MySQL: Dự án sử dụng cơ sở dữ liệu MariaDB hoặc MySQL, thể hiện qua các tệp SQL như minmovie.sql, movies.sql, và minmovie1.sql.
#### 4\. Công cụ quản lý gói
- Composer: Được sử dụng để quản lý các gói PHP