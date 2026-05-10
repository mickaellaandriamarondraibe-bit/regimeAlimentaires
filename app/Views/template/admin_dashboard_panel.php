<section class="page" id="page-admin-dashboard">
  <style>
    .admin-table-wrap { overflow: auto; border: 1px solid #eee; border-radius: 12px; background: #fff; }
    .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; min-width: 620px; }
    .admin-table thead th {
      text-align: left;
      padding: 12px 14px;
      color: #4a3f57;
      background: #f8f5fc;
      border-bottom: 1px solid #ece7f3;
      font-weight: 800;
    }
    .admin-table tbody td {
      padding: 11px 14px;
      border-bottom: 1px solid #f1edf7;
      color: #3f3b3f;
      vertical-align: middle;
    }
    .admin-table tbody tr:nth-child(even) { background: #fcfbfe; }
    .admin-table tbody tr:hover { background: #f6f1ff; }
    .admin-pill { display:inline-block; padding:4px 10px; border-radius:999px; font-size:12px; font-weight:800; }
    .admin-pill-admin { background:#efe7ff; color:#4a1f88; }
    .admin-pill-client { background:#e9fbf2; color:#0e8f61; }
    .admin-pill-c { background:#e7f1ff; color:#1f5a9a; }
    .admin-pill-d { background:#ffecec; color:#a12727; }
  </style>
  <div class="container" style="padding:26px 0 40px;">
    <div class="card" style="padding:14px;border-radius:24px;overflow:hidden;">
      <div style="display:grid;grid-template-columns:220px 1fr 290px;gap:14px;">
        <aside style="background:#19004d;color:#fff;border-radius:16px;padding:16px;">
          <h3 style="margin:0 0 18px;font-weight:900;">DesignNrite</h3>
          <div style="display:grid;gap:8px;font-size:13px;">
            <a href="<?= site_url('dashboard') ?>" style="background:#ff6b9a;color:#fff;padding:10px 12px;border-radius:10px;text-decoration:none;">Dashboard</a>
            <a href="<?= site_url('profil') ?>" style="color:#e7dbff;text-decoration:none;padding:8px 12px;">Profile</a>
            <a href="<?= site_url('regime/list') ?>" style="color:#e7dbff;text-decoration:none;padding:8px 12px;">Analytics</a>
            <a href="<?= site_url('ingredient') ?>" style="color:#e7dbff;text-decoration:none;padding:8px 12px;">Accounting</a>
            <a href="<?= site_url('admin/transactions') ?>" style="color:#e7dbff;text-decoration:none;padding:8px 12px;">Messages</a>
            <a href="<?= site_url('parametres') ?>" style="color:#e7dbff;text-decoration:none;padding:8px 12px;">Projects</a>
          </div>
        </aside>

        <main style="padding:8px 6px;">
          <div style="display:flex;justify-content:space-between;align-items:center;gap:10px;margin-bottom:12px;">
            <h2 style="margin:0;color:#2e1a53;">Dashboard</h2>
            <input type="text" placeholder="Search" style="width:220px;padding:8px 10px;border:1px solid #ddd;border-radius:10px;">
          </div>

          <p style="margin:0 0 10px;color:#ff5a1f;font-weight:700;">Hello, <?= esc($client['username'] ?? session('username') ?? 'Admin') ?></p>

          <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:14px;">
            <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:12px;"><strong>$<?= esc(number_format((float)($stats['montant_total'] ?? 0),0,',',' ')) ?></strong><br><small>Total sales</small></div>
            <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:12px;"><strong><?= esc((string)($stats['users'] ?? 0)) ?></strong><br><small>Users</small></div>
            <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:12px;"><strong><?= esc((string)($stats['regimes'] ?? 0)) ?></strong><br><small>Regimes</small></div>
            <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:12px;"><strong><?= esc((string)($stats['ingredients'] ?? 0)) ?></strong><br><small>Ingredients</small></div>
          </div>

          <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:12px;">
            <strong style="color:#2e1a53;">Recent transactions</strong>
            <div class="admin-table-wrap" style="margin-top:8px;">
              <table class="admin-table">
                <thead><tr><th>Date</th><th>User</th><th>Type</th><th>Amount</th></tr></thead>
                <tbody>
                <?php foreach (($latest_transactions ?? []) as $t): ?>
                  <tr>
                    <td><?= esc($t['date']) ?></td>
                    <td><?= esc($t['username'] ?? '-') ?></td>
                    <td><span class="admin-pill <?= ($t['type'] ?? '') === 'C' ? 'admin-pill-c' : 'admin-pill-d' ?>"><?= esc($t['type']) ?></span></td>
                    <td><strong><?= esc($t['montant']) ?></strong></td>
                  </tr>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </main>

        <aside style="background:#fff;border:1px solid #eee;border-radius:16px;padding:14px;">
          <h4 style="margin:0 0 10px;color:#2e1a53;">Quick links</h4>
          <div style="display:grid;gap:8px;">
            <a class="btn btn-light" href="<?= site_url('regime/create') ?>">Create regime</a>
            <a class="btn btn-light" href="<?= site_url('ingredient') ?>">Ingredients</a>
            <a class="btn btn-light" href="<?= site_url('admin/transactions') ?>">Transactions</a>
            <a class="btn btn-light" href="<?= site_url('parametres') ?>">Parameters</a>
          </div>
        </aside>
      </div>
    </div>
  </div>

  <div class="container" style="padding-bottom:40px;">
    <div class="card" style="padding:16px;">
      <h3 style="margin:0 0 10px;color:#2e1a53;">Derniers utilisateurs</h3>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Rôle</th></tr></thead>
          <tbody>
          <?php foreach (($latest_users ?? []) as $u): ?>
            <tr>
              <td><?= esc($u['id']) ?></td>
              <td><?= esc($u['username']) ?></td>
              <td><?= esc($u['email']) ?></td>
              <td><span class="admin-pill <?= ($u['role'] ?? '') === 'admin' ? 'admin-pill-admin' : 'admin-pill-client' ?>"><?= esc($u['role']) ?></span></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="card" style="padding:16px;margin-top:14px;">
      <h3 style="margin:0 0 10px;color:#2e1a53;">Derniers régimes</h3>
      <div class="admin-table-wrap">
        <table class="admin-table">
          <thead><tr><th>ID</th><th>Nom</th><th>Variation/semaine</th></tr></thead>
          <tbody>
          <?php foreach (($latest_regimes ?? []) as $r): ?>
            <tr>
              <td><?= esc($r['id']) ?></td>
              <td><?= esc($r['name']) ?></td>
              <td><?= esc($r['variation_poids_semaine']) ?></td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>
