function toggleFolder(folder) {
    //đổi kí hiệu + thành - và ngược lại tương ứng với việc mở và đóng thư mục
    folder.innerHTML = folder.innerHTML == '+' ? '-' : '+';
    //nếu thư mục đóng thì xóa class selected
    //nếu thư mục mở thì thêm class selected
    if (folder.innerHTML == "+") {
        folder.className = "";
    } else {
        folder.className = "selected";
    }
}