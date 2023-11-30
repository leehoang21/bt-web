function sortTable(columnIndex) {
    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
    table = document.getElementById("myTable");
    switching = true;
    dir = "asc";

    while (switching) {
        switching = false;
        rows = table.rows;

        for (i = 1; i < (rows.length - 1); i++) {
            shouldSwitch = false;
            //lấy giá trị của hàng thứ i và i+1
            x = rows[i].getElementsByTagName("td")[columnIndex];
            y = rows[i + 1].getElementsByTagName("td")[columnIndex];
            
            //nếu so sánh hợp lệ thì đổi chỗ
            if (dir == "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase() ||
                dir == "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                
                shouldSwitch = true;
                break;
            }
        }

        if (shouldSwitch) {
            //thực hiện đổi chỗ
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
            switchcount++;
        } else {
            
            if (switchcount == 0 && dir == "asc") {
                //nếu không đổi chỗ và đang là sắp xếp tăng dần thì đổi thành sắp xếp giảm dần
                dir = "desc";
                switching = true;
            }
        }
    }

    // Xóa lớp CSS từ tất cả các thẻ th
    var headers = document.getElementsByTagName("th");
    for (var j = 0; j < headers.length; j++) {
        headers[j].classList.remove("sorted-asc", "sorted-desc");
    }

    // Thêm lớp CSS vào thẻ th được kích chọn
    headers[columnIndex].classList.add(dir === "asc" ? "sorted-asc" : "sorted-desc");
}



function searchTable() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("myTable");
    tr = table.getElementsByTagName("tr");

    for (i = 0; i < tr.length; i++) {
        //lấy ô dữ liệu thứ 3 tức là tên sản phẩm
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
            //
            txtValue = td.textContent || td.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                //nếu tìm thấy thì hiển thị hàng đó và highlight text tìm kiếm
                tr[i].style.display = "";
                highlightSearchText(tr[i], filter);
            } else {
                //nếu không tìm thấy thì ẩn đi
                tr[i].style.display = "none";
            }
        }
    }
}

//hàm thực hiện hight light text tìm kiếm
function highlightSearchText(row, filter) {
    
    var cells = row.getElementsByTagName("td");
    for (var i = 0; i < cells.length; i++) {
        var cellText = cells[i].textContent || cells[i].innerText;
        var index = cellText.toUpperCase().indexOf(filter);
        if (index > -1) {

            var highlightedText = cellText.substr(index, filter.length);
            var newText = cellText.replace(highlightedText, `<span class="highlight">${highlightedText}</span>`);
            cells[i].innerHTML = newText;
        }
    }
}

//lắng nghe sự kiện tìm kiếm
function searchFunction(input) {
    input.addEventListener("keyup", searchTable);
}