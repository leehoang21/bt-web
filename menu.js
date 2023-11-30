function focusMe(button) {
    //lấy element có class là `"button-selected"` đầu tiên
    var elem = document.getElementsByClassName("button-selected")[0];
    //nếu có thì xóa class
    if (elem) {
        elem.className = "";
    }
    //thêm class vào button được click
    document.getElementById('txt').innerHTML = button.innerHTML;
    //thay dổi tên class để thay đổi màu sắc
    button.className = "button-selected";
}