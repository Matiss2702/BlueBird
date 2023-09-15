const stars = document.querySelectorAll('.review-star');

stars.forEach(star => {
    star.addEventListener('click', function (e) {
        const rate = Array.from(stars).indexOf(this) + 1;

        stars.forEach((s, index) => {
            if (index < rate) {
                s.classList.add('text-warning');
            } else {
                s.classList.remove('text-warning');
            }
        });

        document.getElementById('rate').value = rate;
    });
});