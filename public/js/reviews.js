/* ============================================================
   reviews.js — star picker, char counter, delete confirm,
                 report modal (index + create/edit pages)
   ============================================================ */

// ── Star Picker (half-star) ──
(function () {
    const picker = document.getElementById('starPicker');
    if (!picker) return;

    const wraps       = picker.querySelectorAll('.star-wrap');
    const ratingInput = document.getElementById('ratingInput');
    const hint        = document.getElementById('starHint');

    const labels = {
        0.5: 'Sangat Buruk', 1: 'Buruk Sekali',
        1.5: 'Buruk',        2: 'Kurang',
        2.5: 'Cukup',        3: 'Lumayan',
        3.5: 'Bagus',        4: 'Bagus Sekali',
        4.5: 'Sangat Bagus', 5: 'Luar Biasa',
    };

    function setStars(val) {
        wraps.forEach((wrap, i) => {
            const idx = i + 1;
            wrap.classList.remove('active-full', 'active-half');
            if (val >= idx)            wrap.classList.add('active-full');
            else if (val >= idx - 0.5) wrap.classList.add('active-half');
        });
        if (hint) hint.textContent = labels[val] || 'Pilih rating';
    }

    wraps.forEach(wrap => {
        wrap.querySelectorAll('.star-half').forEach(btn => {
            btn.addEventListener('mouseenter', () => setStars(parseFloat(btn.dataset.value)));
            btn.addEventListener('click', () => {
                const val = parseFloat(btn.dataset.value);
                ratingInput.value = val;
                setStars(val);
            });
        });
    });

    picker.addEventListener('mouseleave', () => {
        setStars(parseFloat(ratingInput.value) || 0);
    });

    // Restore nilai awal (mode edit)
    const initial = parseFloat(ratingInput.value);
    if (initial) setStars(initial);
})();

// ── Char Counter ──
(function () {
    const comment   = document.getElementById('comment');
    const charCount = document.getElementById('charCount');
    if (!comment || !charCount) return;

    function update() {
        const len = comment.value.length;
        charCount.textContent = len + ' / 1000';
        charCount.style.color = len > 900 ? '#e05252' : '';
    }
    comment.addEventListener('input', update);
    update();
})();

// ── Delete confirmation (index) ──
document.querySelectorAll('.review-delete-form').forEach(form => {
    form.addEventListener('submit', e => {
        if (!confirm('Hapus ulasan kamu? Tindakan ini tidak bisa dibatalkan.')) {
            e.preventDefault();
        }
    });
});

// ── Report Modal (index) ──
function openReportModal(reviewId) {
    const modal = document.getElementById('reportModal');
    const form  = document.getElementById('reportForm');
    if (!modal || !form) return;

    form.action = '/reviews/' + reviewId + '/report';
    form.querySelectorAll('input[type="radio"]').forEach(r => r.checked = false);
    document.getElementById('noteBox')?.classList.remove('show');
    modal.classList.add('open');
}

function closeReportModal() {
    document.getElementById('reportModal')?.classList.remove('open');
}

function onReasonChange(radio) {
    const noteBox = document.getElementById('noteBox');
    if (!noteBox) return;
    noteBox.classList.toggle('show', radio.value === 'lainnya');
}

document.getElementById('reportModal')?.addEventListener('click', function (e) {
    if (e.target === this) closeReportModal();
});

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeReportModal();
});
