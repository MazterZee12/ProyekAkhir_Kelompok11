// ===== STAR PICKER (half-star) =====
const starWraps   = document.querySelectorAll('.star-wrap');
const ratingInput = document.getElementById('ratingInput');
const starHint    = document.getElementById('starHint');

const labels = {
    0.5: 'Sangat Buruk', 1: 'Buruk Sekali',
    1.5: 'Buruk',        2: 'Kurang',
    2.5: 'Cukup',        3: 'Lumayan',
    3.5: 'Bagus',        4: 'Bagus Sekali',
    4.5: 'Sangat Bagus', 5: 'Luar Biasa'
};

function setStars(val) {
    starWraps.forEach((wrap, i) => {
        const idx = i + 1;
        wrap.classList.remove('active-full', 'active-half');
        if (val >= idx)          wrap.classList.add('active-full');
        else if (val >= idx - 0.5) wrap.classList.add('active-half');
    });
    ratingInput.value    = val;
    starHint.textContent = labels[val] || 'Pilih rating';
}

if (starWraps.length) {
    // Set initial value
    const init = parseFloat(ratingInput.value);
    if (init) setStars(init);

    starWraps.forEach(wrap => {
        wrap.querySelectorAll('.star-half').forEach(btn => {
            // Hover preview
            btn.addEventListener('mouseenter', () => setStars(parseFloat(btn.dataset.value)));

            // Click set
            btn.addEventListener('click', () => {
                const val = parseFloat(btn.dataset.value);
                setStars(val);
                ratingInput.value = val;
            });
        });
    });

    // Restore on mouse leave
    document.getElementById('starPicker').addEventListener('mouseleave', () => {
        setStars(parseFloat(ratingInput.value) || 0);
    });
}

// ===== CHAR COUNTER =====
const comment   = document.getElementById('comment');
const charCount = document.getElementById('charCount');
if (comment && charCount) {
    function updateCount() {
        const len = comment.value.length;
        charCount.textContent = len + ' / 1000';
        charCount.style.color = len > 900 ? '#ef4444' : '#9ca3af';
    }
    comment.addEventListener('input', updateCount);
    updateCount();
}
