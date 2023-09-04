<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create category</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Create Category</h1>

    <div id="category-form">
        <div class="form-group">
            <label for="category-title">Title:</label>
            <input type="text" class="form-control" id="category-title" name="title">
        </div>

        <button id="create-category-btn" class="btn btn-primary">Create</button>
    </div>

    <div id="success-message" class="alert alert-success" style="display: none;">
        Category created successfully.
    </div>

    <div id="error-message" class="alert alert-danger" style="display: none;">
        Error creating category. Please check the form.
    </div>

    <script>
        $(document).ready(function() {
            $('#create-category-btn').click(function() {
                // Lấy giá trị từ trường "title"
                var title = $('#category-title').val();
                console.log(title);

                // Gửi dữ liệu đến API
                $.ajax({
                    url: '/category/store', // Điều hướng đến API để lưu danh mục
                    method: 'POST',
                    data: {
                        title: title
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data.success) {
                            // Nếu thành công, hiển thị thông báo và chuyển hướng đến trang danh sách
                            $('#success-message').show();
                            $('#error-message').hide();
                            setTimeout(function() {
                                window.location.href = '/';
                            }, 2000); // Chuyển hướng sau 2 giây
                        } else {
                            // Nếu có lỗi validation hoặc không tạo được danh mục
                            $('#success-message').hide();
                            $('#error-message').show();
                        }
                    },
                    error: function() {
                        // Xử lý lỗi kết nối API
                        $('#success-message').hide();
                        $('#error-message').show();
                    }
                });
            });
        });
    </script>
</body>

</html>
