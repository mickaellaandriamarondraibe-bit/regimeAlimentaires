document.addEventListener('DOMContentLoaded', () => {
    const navMenu = document.getElementById('navMenu');
    const mobileBtn = document.getElementById('mobileBtn');

    if (mobileBtn && navMenu) {
        mobileBtn.addEventListener('click', () => {
            navMenu.classList.toggle('mobile-open');

            mobileBtn.innerHTML = navMenu.classList.contains('mobile-open')
                ? '<i class="fa-solid fa-xmark"></i>'
                : '<i class="fa-solid fa-bars"></i>';
        });
    }

    // Modals catalogue
    document.querySelectorAll('.js-open-program-modal').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modalId = btn.dataset.modalId;
            const modal = document.getElementById(modalId);

            if (modal) {
                modal.classList.add('is-open');
            }
        });
    });

    document.querySelectorAll('.js-close-program-modal').forEach((btn) => {
        btn.addEventListener('click', () => {
            const modalId = btn.dataset.modalId;
            const modal = document.getElementById(modalId);

            if (modal) {
                modal.classList.remove('is-open');
            }
        });
    });

    document.querySelectorAll('.catalogue-modal').forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal) {
                modal.classList.remove('is-open');
            }
        });
    });

    drawDashboardCharts();
    initHomeAnimations();
});

function initHomeAnimations() {
    const autoTargets = [
        '.page-head-row',
        '.card',
        '.admin-table-wrap',
        '.badge',
        '.btn',
        '.input-group',
        '.metric',
        '.status-pill',
        '.footer-inner > *',
        'h2',
        'h3',
        'p',
    ];

    autoTargets.forEach((selector) => {
        document.querySelectorAll(selector).forEach((el) => {
            if (!el.hasAttribute('data-animate')) {
                let type = 'fade-up';
                if (el.classList.contains('badge')) type = 'fade-left';
                if (el.classList.contains('btn')) type = 'zoom-in';
                if (el.classList.contains('card')) type = 'card';
                el.setAttribute('data-animate', type);
            }
        });
    });

    const items = Array.from(document.querySelectorAll('[data-animate]'))
        .filter((el) => !el.closest('.home-hero'));
    if (!items.length) {
        return;
    }

    items.forEach((el, idx) => {
        el.classList.add('anim-ready');
        const customDelay = Number(el.getAttribute('data-delay') || 0);
        const delay = Number.isFinite(customDelay) && customDelay > 0
            ? customDelay
            : Math.min(idx * 35, 260);
        el.style.setProperty('--anim-delay', `${delay}ms`);
    });

    // Afficher tout de suite les éléments déjà dans le viewport au chargement
    items.forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.92) {
            el.classList.add('is-visible');
        }
    });

    if (!('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.16,
        rootMargin: '0px 0px -8% 0px',
    });

    items.forEach((el) => {
        if (!el.classList.contains('is-visible')) {
            observer.observe(el);
        }
    });
}

function drawDashboardCharts() {
    if (typeof Chart === 'undefined') {
        return;
    }

    const txCanvas = document.getElementById('txTypeChart');
    const usersCanvas = document.getElementById('usersRoleChart');

    const txData = window.NUTRIFIT_TX_BY_TYPE || {};
    const usersData = window.NUTRIFIT_USERS_BY_ROLE || {};

    if (txCanvas) {
        new Chart(txCanvas, {
            type: 'doughnut',
            data: {
                labels: ['Crédits', 'Débits'],
                datasets: [{
                    data: [
                        Number(txData.C || 0),
                        Number(txData.D || 0)
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    }

    if (usersCanvas) {
        new Chart(usersCanvas, {
            type: 'pie',
            data: {
                labels: ['Admins', 'Clients'],
                datasets: [{
                    data: [
                        Number(usersData.admin || 0),
                        Number(usersData.client || 0)
                    ]
                }]
            },
            options: {
                responsive: true
            }
        });
    }
}

function exportProfilePdf() {
    window.print();
}
