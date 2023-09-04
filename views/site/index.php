<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Categories</title>
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>List of Categories</h1>
    <button id="createCategoryButton">Create</button>
    <ul id="categoryList">
        <!-- Danh sách danh mục sẽ được cập nhật ở đây -->
    </ul>

    <script>
        $(document).ready(function() {
            loadCategoryList();

            $('#createCategoryButton').click(function() {
                // Chuyển đến trang tạo danh mục
                window.location.href = '/category/create';
            });
        });
        // Sử dụng jQuery AJAX để gọi API và cập nhật danh sách danh mục
        function loadCategoryList() {

            $.ajax({
                url: '/category/index', // Điều hướng đến controller API
                method: 'GET',
                dataType: 'json', // Response là JSON
                success: function(data) {
                    $('#categoryList').empty();

                    $.each(data, function(index, category) {
                        var listItem = '<li>' + category.title + ' ' +
                            '<button class="editButton" data-category-id="' + category.id + '">Edit</button>' +
                            '<button class="deleteButton" data-category-id="' + category.id + '">Delete</button>' +
                            '</li>';
                        $('#categoryList').append(listItem);
                    });

                    // Bắt sự kiện khi nút Edit được click
                    $('.editButton').click(function() {
                        var categoryId = $(this).data('category-id');
                        window.location.href = '/category/edit?id=' + categoryId;
                    });

                    // Bắt sự kiện khi nút Delete được click
                    $('.deleteButton').click(function() {
                        var categoryId = $(this).data('category-id');
                        var confirmDelete = confirm('Bạn có chắc chắn muốn xóa danh mục này?');
                        if (confirmDelete) {
                            deleteCategory(categoryId);
                        }
                    });
                },
                error: function() {
                    alert('Đã có lỗi xảy ra khi tải danh sách danh mục.');
                }
            });
        }

        function deleteCategory(categoryId) {
            $.ajax({
                url: '/category/delete?id=' + categoryId, // API xóa danh mục
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        alert('Danh mục đã được xóa thành công.');
                        loadCategoryList(); // Load lại danh sách sau khi xóa thành công
                    } else {
                        alert('Đã có lỗi xảy ra khi xóa danh mục.');
                    }
                },
                error: function() {
                    alert('Đã có lỗi xảy ra khi xóa danh mục.');
                }
            });
        }
    </script>
</body>

</html>
