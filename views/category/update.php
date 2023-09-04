<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* CSS cho trang chỉnh sửa danh mục */
        /* Thêm CSS tùy chỉnh ở đây */
    </style>
</head>

<body>
    <h1>Edit Category</h1>
    <form id="editCategoryForm">
        <input type="hidden" id="categoryId" name="id" value="">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title"><br>
        <!-- Thêm các trường thông tin khác ở đây -->
        <button type="submit">Submit</button>
    </form>

    <script>
        $(document).ready(function() {
            var categoryId = getCategoryIdFromURL();
            if (categoryId) {
                loadCategoryDetail(categoryId);
            }

            // Sử dụng jQuery AJAX để gửi dữ liệu cập nhật danh mục
            $('#editCategoryForm').submit(function(event) {
                event.preventDefault();
                var formData = $(this).serialize();
                updateCategory(categoryId, formData);
            });
        });

        function getCategoryIdFromURL() {
            // Lấy categoryId từ URL (ví dụ: /category/edit?id=1)
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('id');
        }

        function loadCategoryDetail(categoryId) {
            $.ajax({
                url: '/category/view?id=' + categoryId, // Gọi API hiển thị chi tiết danh mục
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        $('#categoryId').val(data.category.id);
                        $('#title').val(data.category.title);
                        // Điền thông tin chi tiết danh mục vào biểu mẫu
                        // Điền các trường thông tin khác ở đây
                    } else {
                        alert(data.message);
                    }
                },
                error: function() {
                    alert('Đã có lỗi xảy ra khi tải chi tiết danh mục.');
                }
            });
        }

        function updateCategory(categoryId, formData) {
            $.ajax({
                url: '/category/update?id=' + categoryId, // Gọi API cập nhật danh mục
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        alert('Danh mục đã được cập nhật thành công.');
                        window.location.href = '/category/list'; // Chuyển hướng trở lại trang danh sách
                    } else {
                        alert(data.message);
                    }
                },
                error: function() {
                    alert('Đã có lỗi xảy ra khi cập nhật danh mục.');
                }
            });
        }
    </script>
</body>

</html>
