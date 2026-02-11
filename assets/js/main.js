document.addEventListener("DOMContentLoaded", function () {
    var backToTop = document.getElementById("backToTop");

    function handleScroll() {
        if (backToTop) {
            backToTop.classList.toggle("is-visible", window.scrollY > 300);
        }
    }

    if (backToTop) {
        backToTop.addEventListener("click", function () {
            window.scrollTo({ top: 0, behavior: "smooth" });
        });
    }

    window.addEventListener("scroll", handleScroll);
    handleScroll();
});
