let show = true;
setTimeout(() => (show = false), 2000);
const el = document.getElementById("status");
if (show) {
    el.style.display = "block";
}
