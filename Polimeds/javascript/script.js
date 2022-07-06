function open_close_sidebar() {
    if (document.getElementById("sidebar").style.display == "none") {
        document.getElementById("sidebar").style.display = "block";
    } else {
        document.getElementById("sidebar").style.display = "none";
    }
}

function go_to_page(page) {
    window.location.href = page;
}