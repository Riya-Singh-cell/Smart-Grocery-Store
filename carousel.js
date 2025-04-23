let index = 0;

function showSlide(n) {
    const slides = document.querySelectorAll(".carousel img");
    if (n >= slides.length) { index = 0; }
    if (n < 0) { index = slides.length - 1; }

    document.querySelector(".carousel").style.transform = `translateX(${-index * 100}%)`;
}

function nextSlide() {
    index++;
    showSlide(index);
}

function prevSlide() {
    index--;
    showSlide(index);
}

// Auto-slide every 3 seconds
setInterval(() => {
    nextSlide();
}, 3000);
