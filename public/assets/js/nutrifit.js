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
});

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