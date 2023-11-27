
//đầu vào hiện tại
let currentInput = '';
// phím toán hạng
function appendNumber(number) {

    currentInput += number;
    updateDisplay();
}

//hàm tính kết quả
function calculateResult() {
    
    //hàm eval() tính toán biểu thức
    //hàm eval() trả về kết quả của biểu thức
    //hàm eval() trả về NaN nếu biểu thức không hợp lệ
    //hàm eval() trả về Infinity nếu kết quả vượt quá giới hạn của kiểu dữ liệu
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