function focusMe(button) {
    var elem = document.getElementsByClassName("button-selected")[0];
    // if element having class `"button-selected"` defined, do stuff
    if (elem) {
        elem.className = "";
    }
    document.getElementById('txt').innerHTML = button.innerHTML;
    button.className = "button-selected";
}