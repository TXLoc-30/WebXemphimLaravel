# LUỒNG XỬ LÝ DỮ LIỆU  (3 MODULE CHÍNH)

### 1 \. Xem Phim
> 1 \. Người dùng gửi yêu cầu.
Nguồn dữ liệu: Người dùng truy cập trang chi tiết phim thông qua URL (ví dụ: /movie/{id}).
Dữ liệu đầu vào: idmovie: ID của phim được chọn (truyền qua URL hoặc request).
Session người dùng: Kiểm tra trạng thái đăng nhập (username_minmovies).

>2\. Truy vấn cơ sở dữ liệu
Bảng liên quan
movies: Lấy thông tin chi tiết phim (tên, mô tả, URL video, lượt xem, giá, ...).
moviecabinet: Kiểm tra xem người dùng đã mua phim chưa.
users: Lấy thông tin ví tiền của người dùng (nếu cần kiểm tra quyền truy cập).
Truy vấn SQL -> Lấy thông tin phim -> Kiểm tra quyền truy cập

> 3 \. Xử lý logic
Kiểm tra quyền truy cập
Kiểm tra người dùng đã đăng nhập chưa.
Kiểm tra người dùng đã mua phim chưa.

> 4 \. Trả dữ liệu cho giao diện
Dữ liệu trả về:
Thông tin chi tiết phim: Tên, mô tả, URL video, diễn viên, đạo diễn, ...
URL nhúng video: Lấy từ cột urlembed hoặc urlembed2 trong bảng links.
Trình phát video được nhúng vào giao diện bằng thẻ <iframe>

### 2 \. Nạp Tiền và Thanh toán 
> 1 \. Người dùng gửi yêu cầu nạp tiền truy cập vào trang nạp tiền
Nhập số tiền cần nạp và mã gia dịch
Dữ liệu được gửi qua form đến controller WalletController.

> 2 \. Xử lý yêu cầu nạp tiền
Controller WalletController nhận yêu cầu qua phương thức saveChargeWallet.
Hệ thống kiểm tra người dùng dựa trên session username_minmovies và lưu thông tin giao dịch vào bảng wallet_charges.

> 3 \. Quản trị viên xác nhận giao dịch
Quản trị viên truy cập trang quản lý giao dịch nạp tiền.
Các giao dịch nạp tiền được hiển thị từ bảng wallet_charges với trạng thái pending.

> 4 \. Xác nhận hoặc từ chối giao dịch
Quản trị viên xác nhận giao dịch qua các phương thức approveCharge hoặc rejectCharge trong WalletController.

> 5 \. Cập nhật số dư ví
Khi giao dịch được xác nhận, số tiền trong ví của người dùng (wallet.money) được cập nhật.
Nếu giao dịch bị từ chối, trạng thái giao dịch được đánh dấu là rejected.

### 3 \. Quản trị viên
> 1 \.Quản lý phim
Mô tả: Admin có thể thêm, sửa, xóa phim trong hệ thống.
Thêm phim: Admin gửi thông tin phim qua form -> Controller AdminController lưu thông tin vào bảng movies
Sửa phim: Admin chỉnh sửa thông tin phim qua form -> Controller cập nhật thông tin trong bảng movies
Xóa phim: Admin chọn phim cần xóa -> Controller xóa phim khỏi bảng movies

> 2 \. Quản lý người dùng
Mô tả: Admin có thể xem danh sách người dùng, thêm, sửa, hoặc xóa tài khoản.
Xem danh sách người dùng: Controller lấy danh sách từ bảng users
Thêm người dùng: Admin gửi thông tin người dùng qua form -> Controller lưu thông tin vào bảng users
Xóa người dùng: Admin chọn người dùng cần xóa -> Controller xóa người dùng khỏi bảng users

> 3 \. Quản lý danh mục, quốc gia, năm sản xuất
Mô tả: Admin có thể thêm, sửa, xóa danh mục, quốc gia, và năm sản xuất.
Thêm danh mục: Admin gửi tên danh mục qua form -> Controller lưu vào bảng categories.
Sửa danh mục: Admin chỉnh sửa tên danh mục qua form -> Controller cập nhật bảng categorie.
Xóa danh mục: Admin chọn danh mục cần xóa -> Controller xóa khỏi bảng categories.

> 4 \. Quản lý giao dịch ví
Mô tả: Admin xác nhận hoặc từ chối các giao dịch nạp tiền.
Xem danh sách giao dịch: Controller lấy danh sách từ bảng wallet_charge.
Xác nhận giao dịch: Admin xác nhận giao dịch, cập nhật số dư ví và trạng thái giao dịch.
Từ chối giao dịch: Admin từ chối giao dịch, cập nhật trạng thái
.
> 5 \. Thống kê
Mô tả: Admin xem thống kê về người dùng, phim, và giao dịch.
Luồng dữ liệu: Controller lấy dữ liệu từ các bảng users, movies, wallet_charges và hiển thị trên giao diện


