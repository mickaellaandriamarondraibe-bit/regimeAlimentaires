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

    drawDashboardCharts();
    initHomeAnimations();
});

function initHomeAnimations() {
    const autoTargets = [
        '.page-head-row',
        '.card',
        '.admin-table-wrap',
    ];

    autoTargets.forEach((selector) => {
        document.querySelectorAll(selector).forEach((el) => {
            if (!el.hasAttribute('data-animate')) {
                el.setAttribute('data-animate', 'fade-up');
            }
        });
    });

    const items = Array.from(document.querySelectorAll('[data-animate]'))
        .filter((el) => !el.closest('.home-hero'));
    if (!items.length) {
        return;
    }

    items.forEach((el) => {
        el.classList.add('anim-ready');
        el.style.setProperty('--anim-delay', '0ms');
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
