
//đầu vào hiện tại
let currentInput = '';
// hàm nhập dữ liệu
function input(number) {
    currentInput += number;
    updateDisplay();
}

//hàm tính kết quả
function calculateResult() {
    //hàm eval() tính toán biểu thức trong chuỗi
    currentInput = eval(currentInput);
    updateDisplay();
}

//hàm xóa màn hình hiển thị 
function clearDisplay() {
    currentInput = '';
    updateDisplay();
}

//hàm cập nhật màn hình hiển thị
function updateDisplay() {
    document.getElementById('display').textContent = currentInput;
}