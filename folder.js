function toggleFolder(folder) {
    folder.innerHTML = folder.innerHTML == '+' ? '-' : '+';
    if (folder.innerHTML == "+") {
        folder.className = "";
    } else {
        folder.className = "selected";
    }
}