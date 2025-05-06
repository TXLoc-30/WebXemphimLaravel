# KIẾN TRÚC HỆ THỐNG

## 1 \. Tổng quan

Dự án được xây dựng trên framework Laravel, tuân theo mô hình MVC (Model-View-Controller). Các thành phần chính bao gồm:
- Models: Đại diện cho dữ liệu và logic nghiệp vụ, được định nghĩa trong thư mục app.
- Views: Hiển thị giao diện người dùng, được lưu trong thư mục views.
- Controllers: Xử lý logic ứng dụng và kết nối giữa Models và Views, nằm trong Controllers.

## 2 \. Front-end

> Public.
>
>> Chứa các tài nguyên tĩnh phục vụ giao diện.
>>+ css: Chứa các tệp CSS
>>+ app.css: CSS chính cho toàn bộ giao diện.
>>+ style.css: CSS tùy chỉnh cho giao diện người dùng.
>>+ right.css: CSS cho sidebar bên phải.
>>+ js: Chứa các tệp JavaScript như:
>>+ app.js: Tệp chính để khởi tạo các thành phần JavaScript.
>>+ owl.carousel2.js: Thư viện tạo slider.
>>+ public/images/: Chứa hình ảnh như poster phim, biểu tượng, và các hình ảnh giao diện khác.

> Thư mục views
>
>> Chứa các tệp giao diện Blade (template engine của Laravel).
>> user: Giao diện cho người dùng.
>> watchmovie.blade.php: Giao diện xem phim.
>> master.blade.php: Template chính cho các trang người dùng.
>> header.blade.php và footer.blade.php: Header và footer dùng chung.
>> admin: Giao diện cho quản trị viên.

## 3 \. Back-end

> App
> Chứa các thành phần chính của ứng dụng:
>
>> Models: Đại diện cho các bảng trong cơ sở dữ liệu, ví dụ:
>> Movie: Quản lý thông tin phim.
>> User: Quản lý thông tin người dùng.
>> Wallet: Quản lý ví tiền của người dùng.
>> Payment: Quản lý giao dịch thanh toán.
>> Controllers: Xử lý logic nghiệp vụ, ví dụ:
>> UserController: Xử lý các chức năng liên quan đến người dùng.
>> WalletController: Xử lý nạp tiền và giao dịch ví.
>> AdminController: Xử lý các chức năng quản trị.
>> Middleware: Quản lý quyền truy cập, ví dụ:
>> AdminMiddleware: Kiểm tra quyền truy cập của quản trị viên.

> Thư mục routes
>
>> web.php: Định nghĩa các route chính của ứng dụng, kết nối URL với các controller.

> Thư mục database
>
>> Migrations: Định nghĩa cấu trúc bảng cơ sở dữ liệu.
>> Seeders: Tạo dữ liệu mẫu cho cơ sở dữ liệu.
>> SQL: Các tệp SQL như minmovie.sql, movies.sql chứa dữ liệu mẫu.