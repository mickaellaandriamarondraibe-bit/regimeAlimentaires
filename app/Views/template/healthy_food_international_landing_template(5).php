<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NutriFit — Healthy Food Program</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    :root {
      --primary: #ff5a1f;
      --primary-2: #ff7b2f;
      --pink: #d91472;
      --green: #16c784;
      --green-dark: #0f9f6e;
      --yellow: #ffd166;
      --purple: #3b1749;
      --dark: #171717;
      --text: #3f3b3f;
      --muted: #756c75;
      --bg: #f6f0f7;
      --soft: #fff8ef;
      --white: #ffffff;
      --border: rgba(59, 23, 73, .12);
      --shadow: 0 24px 70px rgba(59, 23, 73, .13);
      --radius: 28px;
      --container: 1180px;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: Inter, system-ui, sans-serif;
      color: var(--text);
      background: var(--bg);
      overflow-x: hidden;
    }
    img { max-width: 100%; display: block; }
    button, input, select { font: inherit; }
    button { cursor: pointer; }
    a { color: inherit; text-decoration: none; }

    .container { width: min(var(--container), calc(100% - 40px)); margin-inline: auto; }
    .page { display: none; animation: pageIn .35s ease both; }
    .page.active { display: block; }

    @keyframes pageIn {
      from { opacity: 0; transform: translateY(16px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .btn {
      border: 0;
      border-radius: 999px;
      padding: 14px 23px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      font-weight: 900;
      transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .btn:hover { transform: translateY(-2px); }
    .btn-primary {
      color: white;
      background: linear-gradient(135deg, var(--primary), var(--primary-2));
      box-shadow: 0 18px 35px rgba(255, 90, 31, .28);
    }
    .btn-green {
      color: white;
      background: linear-gradient(135deg, var(--green), #53dd9b);
      box-shadow: 0 18px 35px rgba(22, 199, 132, .25);
    }
    .btn-light {
      background: white;
      color: var(--purple);
      border: 1px solid var(--border);
      box-shadow: 0 12px 30px rgba(59, 23, 73, .08);
    }
    .btn-dark { background: var(--purple); color: white; }
    .full { width: 100%; }

    .badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      border-radius: 999px;
      padding: 8px 13px;
      background: rgba(22, 199, 132, .12);
      color: var(--green-dark);
      font-weight: 900;
      font-size: .9rem;
    }

    /* Header */
    .top-call {
      background: #f8f8f8;
      padding: 8px 0;
      border-bottom: 1px solid rgba(0,0,0,.06);
    }
    .top-call .container {
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }
    .call-pill {
      background: #17bd86;
      color: white;
      border-radius: 4px;
      padding: 7px 18px;
      display: flex;
      align-items: center;
      gap: 11px;
      font-weight: 900;
      line-height: 1.1;
    }
    .call-pill small { display: block; font-size: .72rem; font-weight: 600; opacity: .9; }
    .call-pill i { font-size: 1.45rem; }

    .navbar {
      position: sticky;
      top: 0;
      z-index: 100;
      background: rgba(255,255,255,.96);
      backdrop-filter: blur(18px);
      border-bottom: 1px solid rgba(59, 23, 73, .08);
      box-shadow: 0 8px 28px rgba(59, 23, 73, .05);
    }
    .nav-inner {
      min-height: 82px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 24px;
      padding: 8px 0;
    }
    .logo {
      display: flex;
      align-items: center;
      gap: 10px;
      color: var(--purple);
      font-size: 1.55rem;
      font-weight: 950;
      letter-spacing: -.06em;
      border: 0;
      background: transparent;
      padding: 0;
      cursor: pointer;
      line-height: 1;
    }
    .logo:focus {
      outline: none;
    }
    .logo-icon {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      display: grid;
      place-items: center;
      color: white;
      background: linear-gradient(135deg, var(--pink), var(--primary));
      box-shadow: 0 10px 25px rgba(217, 20, 114, .22);
    }
    .nav-menu {
      display: flex;
      align-items: center;
      gap: 26px;
      color: var(--purple);
      font-weight: 850;
    }
    .nav-menu button {
      border: 0;
      background: transparent;
      color: inherit;
      font-weight: inherit;
      transition: color .2s ease, transform .2s ease;
      cursor: pointer;
    }
    .nav-menu button:hover, .nav-menu button.active-link { color: var(--pink); }
    .nav-icons {
      display: flex;
      align-items: center;
      gap: 22px;
      color: var(--dark);
      font-size: .85rem;
      text-align: center;
      font-weight: 700;
    }
    .nav-icons button {
      border: 0;
      background: transparent;
      display: grid;
      place-items: center;
      gap: 3px;
      color: inherit;
    }
    .nav-icons i { font-size: 1.45rem; color: #232323; }
    .mobile-btn { display: none; }

    .orange-tab {
      background: linear-gradient(135deg, var(--primary), var(--primary-2)) !important;
      color: white !important;
      padding: 12px 28px !important;
      border-radius: 999px;
      box-shadow: 0 13px 28px rgba(255, 90, 31, .3);
      text-align: center;
      line-height: 1.05;
      min-width: 190px;
    }
    .orange-tab:hover {
      color: white !important;
      filter: brightness(1.03);
    }
    .orange-tab small { display: block; font-size: .7rem; font-weight: 900; }

    /* Home */
    .hero {
      min-height: calc(100vh - 126px);
      padding: 74px 0 92px;
      background:
        radial-gradient(circle at 8% 12%, rgba(255, 209, 102, .35), transparent 30%),
        radial-gradient(circle at 88% 12%, rgba(22, 199, 132, .16), transparent 34%),
        linear-gradient(180deg, #fff8ef, var(--bg));
      overflow: hidden;
    }
    .hero-grid {
      display: grid;
      grid-template-columns: 1.05fr .95fr;
      gap: 58px;
      align-items: center;
    }
    .hero h1 {
      color: var(--purple);
      font-size: clamp(3rem, 6vw, 6.1rem);
      line-height: .91;
      letter-spacing: -.085em;
      margin: 18px 0 22px;
    }
    .hero h1 span { color: var(--primary); }
    .hero p {
      max-width: 640px;
      color: var(--muted);
      line-height: 1.8;
      font-size: 1.12rem;
      margin-bottom: 30px;
    }
    .hero-actions { display: flex; gap: 13px; flex-wrap: wrap; }
    .hero-visual {
      position: relative;
      min-height: 670px;
      padding-bottom: 58px;
    }
    .big-food {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 58px;
      border-radius: 52px;
      background: url('https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=1300&q=85') center/cover;
      box-shadow: var(--shadow);
      animation: float 6s ease-in-out infinite;
      overflow: hidden;
    }
    .big-food::after {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(180deg, transparent 35%, rgba(59,23,73,.62));
    }
    .quick-card {
      display: none;
    }
    .quick-card h3 { color: var(--purple); font-size: 1.45rem; letter-spacing: -.04em; margin-bottom: 8px; }
    .quick-card p { font-size: .94rem; margin: 0 0 15px; line-height: 1.55; }
    .input-group { display: grid; gap: 7px; margin-bottom: 12px; }
    .input-group label { font-weight: 850; color: var(--purple); font-size: .86rem; }
    .input, .select {
      width: 100%;
      border: 1px solid var(--border);
      background: #fffaf4;
      border-radius: 16px;
      padding: 13px 14px;
      outline: 0;
      color: var(--purple);
    }
    .input:focus, .select:focus { box-shadow: 0 0 0 4px rgba(255,90,31,.12); border-color: rgba(255,90,31,.55); }
    .floating {
      position: absolute;
      z-index: 3;
      background: rgba(255,255,255,.94);
      border: 1px solid var(--border);
      box-shadow: 0 18px 46px rgba(59,23,73,.14);
      border-radius: 999px;
      padding: 13px 16px;
      font-weight: 950;
      color: var(--purple);
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .floating i { color: var(--green); }

    .diagnostic-section {
      background: linear-gradient(180deg, var(--bg), #fff8ef);
      padding-top: 78px;
    }
    .diagnostic-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 24px;
      align-items: stretch;
    }
    .action-card {
      position: relative;
      overflow: hidden;
      background: rgba(255,255,255,.96);
      border: 1px solid var(--border);
      border-radius: 34px;
      padding: 30px;
      box-shadow: 0 22px 60px rgba(59,23,73,.1);
    }
    .action-card::after {
      content: '';
      position: absolute;
      width: 180px;
      height: 180px;
      right: -70px;
      top: -70px;
      border-radius: 50%;
      background: rgba(255, 209, 102, .24);
      pointer-events: none;
    }
    .action-icon {
      width: 62px;
      height: 62px;
      display: grid;
      place-items: center;
      border-radius: 22px;
      color: white;
      background: linear-gradient(135deg, var(--green), #52dc9a);
      font-size: 1.45rem;
      margin-bottom: 22px;
      box-shadow: 0 14px 30px rgba(22,199,132,.2);
    }
    .code-icon {
      background: linear-gradient(135deg, var(--primary), var(--pink));
      box-shadow: 0 14px 30px rgba(255,90,31,.2);
    }
    .action-card h3 {
      color: var(--purple);
      font-size: 1.65rem;
      letter-spacing: -.045em;
      margin-bottom: 8px;
    }
    .action-card p {
      color: var(--muted);
      line-height: 1.65;
      margin-bottom: 20px;
    }
    .code-input-wrap {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 10px;
      margin-bottom: 16px;
    }
    .code-input {
      text-transform: uppercase;
      font-weight: 900;
      letter-spacing: .08em;
    }
    .code-help {
      display: flex;
      gap: 10px;
      align-items: flex-start;
      padding: 14px;
      border-radius: 18px;
      background: #fff8ef;
      color: var(--muted);
      font-size: .92rem;
      line-height: 1.5;
    }
    .code-help i {
      color: var(--primary);
      margin-top: 2px;
    }
    .f1 { top: 70px; left: -24px; animation: float 5s ease-in-out infinite reverse; }
    .f2 { top: 22px; right: 22px; animation: float 4.8s ease-in-out infinite; }
    @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-14px); } }

    .section { padding: 88px 0; }
    .section-title { max-width: 760px; margin: 0 auto 42px; text-align: center; }
    .section-title h2 { color: var(--purple); font-size: clamp(2rem,4vw,3.5rem); line-height: 1.03; letter-spacing: -.065em; margin-top: 14px; }
    .section-title p { color: var(--muted); line-height: 1.75; font-size: 1.05rem; margin-top: 14px; }

    .steps, .programs-grid, .benefits-grid, .profile-grid { display: grid; gap: 22px; }
    .steps { grid-template-columns: repeat(3, 1fr); }
    .programs-grid { grid-template-columns: repeat(3, 1fr); }
    .benefits-grid { grid-template-columns: repeat(4, 1fr); }
    .card {
      background: white;
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: 0 18px 50px rgba(59,23,73,.08);
      overflow: hidden;
      transition: transform .22s ease, box-shadow .22s ease;
    }
    .card:hover { transform: translateY(-7px); box-shadow: 0 28px 70px rgba(59,23,73,.13); }
    .pad { padding: 28px; }
    .icon-box {
      width: 58px; height: 58px; border-radius: 19px; display: grid; place-items: center;
      background: linear-gradient(135deg, var(--primary), var(--yellow)); color: white; font-size: 1.35rem; margin-bottom: 20px;
    }
    .card h3 { color: var(--purple); font-size: 1.35rem; letter-spacing: -.04em; margin-bottom: 10px; }
    .card p { color: var(--muted); line-height: 1.65; }

    .program-img { height: 230px; background-size: cover; background-position: center; }
    .list { display: grid; gap: 10px; margin: 18px 0 22px; }
    .list li { list-style: none; display: flex; gap: 10px; font-weight: 750; color: var(--text); }
    .list i { color: var(--green); margin-top: 3px; }

    /* Menus page */
    .page-head {
      background: linear-gradient(180deg, #ffffff, var(--bg));
      padding: 34px 0 26px;
      border-bottom: 1px solid rgba(59, 23, 73, .08);
    }
    .page-head-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 20px;
      flex-wrap: wrap;
    }
    .page-head h1 {
      color: var(--purple);
      letter-spacing: -.055em;
      font-size: clamp(2rem, 4vw, 3.2rem);
    }
    .filter-box {
      display: flex;
      align-items: center;
      gap: 10px;
      flex-wrap: wrap;
    }
    .filter-box select, .filter-box input {
      border: 0;
      border-radius: 999px;
      padding: 13px 18px;
      background: white;
      box-shadow: 0 12px 30px rgba(59,23,73,.07);
      color: var(--purple);
      outline: 0;
      font-weight: 750;
    }
    .menus-wrapper { padding: 32px 0 90px; }
    .menu-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 22px;
    }
    .dish-card {
      background: #f7f2ea;
      border-radius: 21px;
      overflow: hidden;
      box-shadow: 0 14px 35px rgba(59,23,73,.08);
      border: 1px solid rgba(59,23,73,.06);
      position: relative;
      min-height: 360px;
      transition: transform .2s ease, box-shadow .2s ease;
    }
    .dish-card:hover { transform: translateY(-6px); box-shadow: 0 24px 55px rgba(59,23,73,.14); }
    .dish-img {
      height: 190px;
      background-size: cover;
      background-position: center;
      border-bottom-left-radius: 50% 18%;
      border-bottom-right-radius: 50% 18%;
    }
    .dish-body { padding: 18px 18px 20px; background: #fbf8f1; min-height: 170px; display: grid; align-content: space-between; }
    .dish-body h3 {
      color: var(--purple);
      text-align: center;
      font-size: 1rem;
      line-height: 1.35;
      letter-spacing: -.02em;
      margin: 2px 0 16px;
    }
    .dish-meta { display: flex; justify-content: space-between; align-items: center; }
    .nutri {
      display: flex;
      align-items: center;
      gap: 2px;
      font-size: .72rem;
      font-weight: 900;
    }
    .nutri span { width: 18px; height: 22px; display: grid; place-items: center; color: white; }
    .nutri span:nth-child(1){ background:#009b5a; }
    .nutri span:nth-child(2){ background:#78be20; }
    .nutri span:nth-child(3){ background:#ffd100; }
    .nutri span:nth-child(4){ background:#f28c28; }
    .nutri span:nth-child(5){ background:#e13b2f; }
    .zoom-btn {
      width: 40px; height: 40px; border-radius: 50%; border: 0; background: #efe3f2; color: var(--purple);
      display: grid; place-items: center;
    }
    .dish-label {
      position: absolute;
      left: 0; top: 0;
      background: #d8f7e8;
      color: var(--purple);
      padding: 9px 18px;
      border-bottom-right-radius: 12px;
      font-weight: 900;
      font-size: .86rem;
    }

    /* Auth pages */
    .auth-bg {
      min-height: calc(100vh - 126px);
      display: grid;
      place-items: center;
      padding: 50px 0;
      background:
        radial-gradient(circle at 15% 20%, rgba(255,209,102,.34), transparent 32%),
        radial-gradient(circle at 85% 22%, rgba(22,199,132,.16), transparent 35%),
        linear-gradient(180deg, #fff8ef, var(--bg));
    }
    .auth-card {
      width: min(980px, calc(100% - 40px));
      display: grid;
      grid-template-columns: .95fr 1.05fr;
      border-radius: 38px;
      overflow: hidden;
      background: white;
      box-shadow: var(--shadow);
      border: 1px solid var(--border);
    }
    .auth-visual {
      min-height: 560px;
      background: linear-gradient(180deg, rgba(59,23,73,.08), rgba(59,23,73,.62)), url('https://images.unsplash.com/photo-1498837167922-ddd27525d352?auto=format&fit=crop&w=1100&q=85') center/cover;
      color: white;
      padding: 36px;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
    }
    .auth-visual h2 { font-size: 2.4rem; line-height: 1.03; letter-spacing: -.06em; margin-bottom: 12px; }
    .auth-visual p { opacity: .86; line-height: 1.65; }
    .auth-form { padding: 42px; }
    .auth-form h1 { color: var(--purple); font-size: 2.35rem; letter-spacing: -.06em; margin-bottom: 8px; }
    .auth-form > p { color: var(--muted); line-height: 1.6; margin-bottom: 26px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 13px; }
    .auth-switch { margin-top: 18px; color: var(--muted); text-align: center; font-weight: 700; }
    .auth-switch button { border: 0; background: transparent; color: var(--pink); font-weight: 900; }
    .progress {
      display: flex; gap: 8px; margin-bottom: 24px;
    }
    .progress span { flex: 1; height: 8px; border-radius: 99px; background: #eadfec; }
    .progress .on { background: linear-gradient(135deg, var(--primary), var(--green)); }

    /* Profile */
    .profile-hero {
      padding: 48px 0 30px;
      background: linear-gradient(180deg, #fff8ef, var(--bg));
    }
    .profile-top {
      display: grid;
      grid-template-columns: auto 1fr auto;
      gap: 22px;
      align-items: center;
      background: white;
      border: 1px solid var(--border);
      box-shadow: 0 18px 55px rgba(59,23,73,.09);
      border-radius: 34px;
      padding: 28px;
    }
    .profile-avatar {
      width: 96px; height: 96px; border-radius: 50%;
      background: url('https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=240&q=80') center/cover;
      border: 5px solid #fff0df;
    }
    .profile-top h1 { color: var(--purple); font-size: 2.15rem; letter-spacing: -.055em; }
    .profile-top p { color: var(--muted); margin-top: 5px; }
    .profile-grid { grid-template-columns: 1.1fr .9fr; padding: 28px 0 90px; }
    .metric-grid { display: grid; grid-template-columns: repeat(3,1fr); gap: 14px; margin-top: 18px; }
    .metric { background: #fff8ef; border-radius: 22px; padding: 18px; text-align: center; border: 1px solid rgba(59,23,73,.08); }
    .metric strong { color: var(--purple); font-size: 1.55rem; display: block; }
    .metric span { color: var(--muted); font-weight: 800; font-size: .85rem; }
    .timeline { display: grid; gap: 14px; }
    .timeline-item { display: flex; gap: 13px; padding: 16px; border-radius: 20px; background: #fff8ef; }
    .timeline-item i { color: var(--green); margin-top: 3px; }
    .timeline-item strong { color: var(--purple); display: block; margin-bottom: 4px; }
    .timeline-item span { color: var(--muted); line-height: 1.5; font-size: .94rem; }

    /* Modal */
    .modal {
      position: fixed;
      inset: 0;
      background: rgba(23,23,23,.58);
      z-index: 200;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 22px;
    }
    .modal.active { display: flex; }
    .modal-content {
      width: min(560px, 100%);
      background: white;
      border-radius: 28px;
      overflow: hidden;
      box-shadow: var(--shadow);
      animation: modalIn .25s ease both;
    }
    @keyframes modalIn { from { opacity:0; transform: scale(.95); } to { opacity:1; transform: scale(1); } }
    .modal-img { height: 260px; background-size: cover; background-position: center; }
    .modal-body { padding: 26px; }
    .modal-body h3 { color: var(--purple); font-size: 1.7rem; letter-spacing: -.04em; margin-bottom: 8px; }
    .modal-body p { color: var(--muted); line-height: 1.65; margin-bottom: 18px; }
    .modal-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .reveal { opacity: 0; transform: translateY(28px); transition: opacity .7s ease, transform .7s ease; }
    .reveal.visible { opacity: 1; transform: translateY(0); }

    @media (max-width: 1040px) {
      .nav-menu, .nav-icons { display: none; }
      .mobile-btn { display: inline-flex; }
      .nav-menu.mobile-open {
        display: grid;
        position: absolute;
        top: 74px;
        left: 20px;
        right: 20px;
        padding: 22px;
        background: white;
        border-radius: 24px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        z-index: 110;
      }
      .hero-grid, .auth-card, .profile-grid { grid-template-columns: 1fr; }
      .hero-visual { min-height: 620px; }
      .steps, .programs-grid, .benefits-grid, .menu-grid, .diagnostic-grid { grid-template-columns: repeat(2,1fr); }
      .profile-top { grid-template-columns: auto 1fr; }
      .profile-top .btn { grid-column: 1 / -1; }
    }
    @media (max-width: 680px) {
      .top-call { display: none; }
      .hero { padding-top: 44px; }
      .hero-visual { min-height: auto; }
      .big-food { position: relative; min-height: 390px; }
      .quick-card { position: relative; right: auto; bottom: auto; margin-top: 20px; width: 100%; }
      .floating { display: none; }
      .steps, .programs-grid, .benefits-grid, .menu-grid, .form-grid, .metric-grid, .diagnostic-grid { grid-template-columns: 1fr; }
      .code-input-wrap { grid-template-columns: 1fr; }
      .section { padding: 68px 0; }
      .auth-form { padding: 28px; }
      .auth-visual { min-height: 300px; }
      .profile-top { grid-template-columns: 1fr; text-align: center; justify-items: center; }
    }
  </style>
</head>
<body>
 
  <header class="navbar">
    <div class="container nav-inner">
      <button class="logo" onclick="showPage('home')">
        <span class="logo-icon"><i class="fa-solid fa-heart-pulse"></i></span>
        NutriFit
      </button>

      <nav class="nav-menu" id="navMenu">
        <button onclick="showPage('home')" data-link="home"><i class="fa-solid fa-house"></i></button>
        <button onclick="showPage('home')">Méthode</button>
        <button onclick="showPage('home')">Résultats</button>
        <button onclick="showPage('menus')" data-link="menus">Menus</button>
        <button class="orange-tab" onclick="showPage('programs')" data-link="programs"><small>PROGRAMMES DE</small> PERTE DE POIDS</button>
        <button onclick="showPage('home')">E-shop</button>
      </nav>

      <div class="nav-icons">
        <button onclick="showPage('profile')"><i class="fa-regular fa-circle-user"></i><span>Mon compte</span></button>
        <button onclick="showPage('login')"><i class="fa-solid fa-right-to-bracket"></i><span>Login</span></button>
        <?php if (session()->get('user_id')): ?>
          <button onclick="window.location.href='<?= site_url('logout') ?>'"><i class="fa-solid fa-power-off"></i><span>Logout</span></button>
        <?php endif; ?>
      </div>

      <button class="btn btn-light mobile-btn" id="mobileBtn"><i class="fa-solid fa-bars"></i></button>
    </div>
    <?php if ((session('role') ?? '') === 'admin'): ?>
      <div class="container" style="padding:10px 0 14px;">
        <div class="actions" style="justify-content:center;">
          <a class="btn btn-light" href="<?= site_url('dashboard') ?>">Dashboard</a>
          <a class="btn btn-light" href="<?= site_url('ingredient') ?>">Ingrédients</a>
          <a class="btn btn-light" href="<?= site_url('regime/list') ?>">Régimes</a>
          <a class="btn btn-light" href="<?= site_url('regime/create') ?>">Créer régime</a>
          <a class="btn btn-light" href="<?= site_url('admin/transactions') ?>">Transactions</a>
          <a class="btn btn-light" href="<?= site_url('parametres') ?>">Paramètres</a>
        </div>
      </div>
    <?php endif; ?>
  </header>

  <main>
    <!-- ACCUEIL -->
    <section class="page active" id="page-home">
      <div class="hero">
        <div class="container hero-grid">
          <div class="reveal">
            <span class="badge"><i class="fa-solid fa-bolt"></i> Programme nutritionnel international</span>
            <h1>Mangez mieux. <span>Progressez simplement.</span></h1>
            <p>Template professionnel complet pour un service de repas équilibrés : menus, programmes, inscription en deux étapes, connexion, profil client et parcours “commencer”.</p>
            <div class="hero-actions">
              <button class="btn btn-primary" onclick="showPage('signup1')">Commencer maintenant <i class="fa-solid fa-arrow-right"></i></button>
              <button class="btn btn-light" onclick="showPage('menus')">Voir les menus</button>
            </div>
          </div>

          <div class="hero-visual reveal">
            <div class="big-food"></div>
            <div class="floating f1"><i class="fa-solid fa-truck-fast"></i> Livraison à domicile</div>
            <div class="floating f2"><i class="fa-solid fa-user-doctor"></i> Coach nutrition</div>
          </div>
        </div>
      </div>

      <section class="section diagnostic-section">
        <div class="container">
          <div class="section-title reveal">
            <span class="badge"><i class="fa-solid fa-clipboard-check"></i> Démarrage rapide</span>
            <h2>Commencez avec un diagnostic ou un code</h2>
            <p>Cette section sépare clairement l’action utilisateur de la photo principale. Le hero reste propre et les cartes deviennent plus visibles.</p>
          </div>

          <div class="diagnostic-grid">
            <article class="action-card reveal">
              <div class="action-icon"><i class="fa-solid fa-heart-pulse"></i></div>
              <h3>Diagnostic rapide</h3>
              <p>Répondez à quelques informations pour recevoir une première recommandation de programme.</p>

              <div class="input-group">
                <label>Objectif</label>
                <select class="select">
                  <option>Perte de poids</option>
                  <option>Équilibre alimentaire</option>
                  <option>Programme sportif</option>
                  <option>Rééquilibrage complet</option>
                </select>
              </div>

              <div class="input-group">
                <label>Email</label>
                <input class="input" type="email" placeholder="votre@email.com">
              </div>

              <button class="btn btn-green full" onclick="showPage('signup1')">
                Démarrer mon diagnostic <i class="fa-solid fa-arrow-right"></i>
              </button>
            </article>

            <article class="action-card code-card reveal">
              <div class="action-icon code-icon"><i class="fa-solid fa-ticket"></i></div>
              <h3>Insérer un code</h3>
              <p>Déjà reçu un code ? Entrez-le ici pour accéder directement à votre programme ou à votre offre.</p>

              <div class="code-input-wrap">
                <input class="input code-input" id="programCode" type="text" placeholder="Ex : NUTRI2026" maxlength="20">
                <button class="btn btn-primary" onclick="validateCode()">Valider</button>
              </div>

              <div class="code-help">
                <i class="fa-solid fa-circle-info"></i>
                <span>Le code peut venir d’un coach, d’une offre spéciale ou d’un programme déjà acheté.</span>
              </div>
            </article>
          </div>
        </div>
      </section>

      <section class="section">
        <div class="container">
          <div class="section-title reveal">
            <span class="badge"><i class="fa-solid fa-route"></i> Méthode</span>
            <h2>Un parcours clair du premier clic au profil client</h2>
            <p>Le template ne s’arrête pas à une page d’accueil : il montre aussi le parcours utilisateur complet.</p>
          </div>
          <div class="steps">
            <article class="card pad reveal"><div class="icon-box">1</div><h3>Choix du programme</h3><p>L’utilisateur découvre les offres et choisit son type de programme.</p></article>
            <article class="card pad reveal"><div class="icon-box">2</div><h3>Inscription en 2 étapes</h3><p>Étape 1 pour les informations personnelles, étape 2 pour les objectifs nutritionnels.</p></article>
            <article class="card pad reveal"><div class="icon-box">3</div><h3>Profil personnalisé</h3><p>Le profil affiche le programme, les repas, les statistiques et les prochaines actions.</p></article>
          </div>
        </div>
      </section>

      <section class="section" style="background:#fff8ef;">
        <div class="container">
          <div class="section-title reveal">
            <span class="badge"><i class="fa-solid fa-gem"></i> Avantages</span>
            <h2>Un rendu professionnel pour présentation internationale</h2>
          </div>
          <div class="benefits-grid">
            <article class="card pad reveal"><div class="icon-box"><i class="fa-solid fa-mobile-screen"></i></div><h3>Responsive</h3><p>Compatible desktop, tablette et mobile.</p></article>
            <article class="card pad reveal"><div class="icon-box"><i class="fa-solid fa-wand-magic-sparkles"></i></div><h3>Animations</h3><p>Apparition au scroll, hover cards et transitions propres.</p></article>
            <article class="card pad reveal"><div class="icon-box"><i class="fa-solid fa-bowl-food"></i></div><h3>Menus</h3><p>Grille de plats avec filtres, nutri-score et détails.</p></article>
            <article class="card pad reveal"><div class="icon-box"><i class="fa-solid fa-user-check"></i></div><h3>Compte client</h3><p>Login, inscription et page profil inclus.</p></article>
          </div>
        </div>
      </section>
    </section>

    <!-- MENUS -->
    <section class="page" id="page-menus">
      <div class="page-head">
        <div class="container page-head-row">
          <div>
            <span class="badge"><i class="fa-solid fa-utensils"></i> Les plats</span>
            <h1>Nos menus colorés et équilibrés</h1>
          </div>
          <div class="filter-box">
            <input id="searchDish" type="text" placeholder="Rechercher un plat..." oninput="filterDishes()">
            <select id="categoryFilter" onchange="filterDishes()">
              <option value="all">Filtrer</option>
              <option value="viande">Viande</option>
              <option value="poulet">Poulet</option>
              <option value="vegetarien">Végétarien</option>
              <option value="pates">Pâtes</option>
            </select>
          </div>
        </div>
      </div>

      <div class="container menus-wrapper">
        <div class="menu-grid" id="dishGrid"></div>
      </div>
    </section>

    <!-- PROGRAMMES -->
    <section class="page" id="page-programs">
      <div class="page-head">
        <div class="container page-head-row">
          <div>
            <span class="badge"><i class="fa-solid fa-chart-line"></i> Programmes</span>
            <h1>Programmes de perte de poids</h1>
          </div>
          <button class="btn btn-primary" onclick="showPage('signup1')">Commencer</button>
        </div>
      </div>
      <section class="section">
        <div class="container programs-grid">
          <article class="card reveal">
            <div class="program-img" style="background-image:url('https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=900&q=85')"></div>
            <div class="pad"><h3>Starter Fit</h3><p>Pour démarrer une routine simple avec menus guidés.</p><ul class="list"><li><i class="fa-solid fa-check"></i> 4 repas par jour</li><li><i class="fa-solid fa-check"></i> Menus équilibrés</li><li><i class="fa-solid fa-check"></i> Livraison hebdomadaire</li></ul><button class="btn btn-light full" onclick="showPage('signup1')">Choisir</button></div>
          </article>
          <article class="card reveal">
            <div class="program-img" style="background-image:url('https://images.unsplash.com/photo-1494390248081-4e521a5940db?auto=format&fit=crop&w=900&q=85')"></div>
            <div class="pad"><h3>Premium Coach</h3><p>Le programme le plus complet avec accompagnement.</p><ul class="list"><li><i class="fa-solid fa-check"></i> Coach dédié</li><li><i class="fa-solid fa-check"></i> Suivi profil</li><li><i class="fa-solid fa-check"></i> Ajustement mensuel</li></ul><button class="btn btn-primary full" onclick="showPage('signup1')">Le plus demandé</button></div>
          </article>
          <article class="card reveal">
            <div class="program-img" style="background-image:url('https://images.unsplash.com/photo-1506368249639-73a05d6f6488?auto=format&fit=crop&w=900&q=85')"></div>
            <div class="pad"><h3>Active Protein</h3><p>Pour les personnes actives qui veulent garder une alimentation structurée.</p><ul class="list"><li><i class="fa-solid fa-check"></i> Plats protéinés</li><li><i class="fa-solid fa-check"></i> Collations</li><li><i class="fa-solid fa-check"></i> Plan sportif doux</li></ul><button class="btn btn-light full" onclick="showPage('signup1')">Découvrir</button></div>
          </article>
        </div>
      </section>
    </section>

    <!-- LOGIN -->
    <section class="page" id="page-login">
      <div class="auth-bg">
        <div class="auth-card">
          <div class="auth-visual"><h2>Bon retour sur NutriFit</h2><p>Connectez-vous pour retrouver votre programme, vos menus et votre suivi.</p></div>
          <form class="auth-form" method="post" action="<?= site_url('validationLogin') ?>">
            <?= csrf_field() ?>
            <h1>Connexion</h1>
            <p>Accédez à votre espace personnel.</p>
            <div class="input-group"><label>Email</label><input class="input" type="email" name="email" placeholder="client@email.com" required></div>
            <div class="input-group"><label>Mot de passe</label><input class="input" type="password" name="pwd" placeholder="••••••••" required></div>
            <button class="btn btn-primary full" type="submit" formaction="<?= site_url('validationLogin') ?>" formmethod="post">Se connecter <i class="fa-solid fa-right-to-bracket"></i></button>
            <div class="auth-switch">Pas encore de compte ? <button type="button" onclick="showPage('signup1')">Créer un compte</button></div>
          </form>
        </div>
      </div>
    </section>

    <!-- SIGNUP 1 -->
    <section class="page" id="page-signup1">
      <div class="auth-bg">
        <div class="auth-card">
          <div class="auth-visual"><h2>Étape 1 : vos informations</h2><p>Une première page simple pour créer le compte client.</p></div>
          <form class="auth-form" method="post" action="<?= site_url('step2') ?>">
            <?= csrf_field() ?>
            <div class="progress"><span class="on"></span><span></span></div>
            <h1>Créer mon compte</h1>
            <p>Renseignez les informations principales.</p>
            <?php if (session()->getFlashdata('error')): ?>
              <p style="color:#c81e1e;font-weight:700;"><?= esc(session()->getFlashdata('error')) ?></p>
            <?php endif; ?>
            <div class="form-grid">
              <div class="input-group"><label>Nom d'utilisateur</label><input class="input" type="text" name="name" placeholder="Rakoto" value="<?= esc((string) session('name')) ?>" required></div>
              <div class="input-group"><label>Email</label><input class="input" type="email" name="email" placeholder="votre@email.com" value="<?= esc((string) session('email')) ?>" required></div>
            </div>
            <div class="input-group"><label>Mot de passe</label><input class="input" type="password" name="pwd" placeholder="Créer un mot de passe" required></div>
            <input type="hidden" name="phone" value="<?= esc((string) session('phone')) ?>">
            <input type="hidden" name="genre" value="<?= esc((string) session('genre')) ?>">
            <input type="hidden" name="date_naissance" value="<?= esc((string) session('date_naissance')) ?>">
            <input type="hidden" name="age" value="<?= esc((string) session('age')) ?>">
            <input type="hidden" name="taille" value="<?= esc((string) session('taille')) ?>">
            <input type="hidden" name="poids" value="<?= esc((string) session('poids')) ?>">
            <button class="btn btn-primary full" type="submit" formaction="<?= site_url('step2') ?>" formmethod="post">Continuer vers l’étape 2 <i class="fa-solid fa-arrow-right"></i></button>
            <div class="auth-switch">Déjà inscrit ? <button type="button" onclick="showPage('login')">Se connecter</button></div>
          </form>
        </div>
      </div>
    </section>

    <!-- SIGNUP 2 -->
    <section class="page" id="page-signup2">
      <div class="auth-bg">
        <div class="auth-card">
          <div class="auth-visual"><h2>Étape 2 : votre objectif</h2><p>Cette étape rend le parcours plus professionnel et personnalisé.</p></div>
          <form class="auth-form" method="post" action="<?= site_url('register') ?>">
            <?= csrf_field() ?>
            <div class="progress"><span class="on"></span><span class="on"></span></div>
            <h1>Mon profil nutrition</h1>
            <p>Informations issues de votre profil client.</p>
            <?php if (session()->getFlashdata('error')): ?>
              <p style="color:#c81e1e;font-weight:700;"><?= esc(session()->getFlashdata('error')) ?></p>
            <?php endif; ?>
            <div class="form-grid">
              <div class="input-group">
                <label>Genre</label>
                <select class="select" name="genre" required>
                  <option value="H" <?= (($client['genre'] ?? session('genre') ?? '') === 'H') ? 'selected' : '' ?>>Homme</option>
                  <option value="F" <?= (($client['genre'] ?? session('genre') ?? '') === 'F') ? 'selected' : '' ?>>Femme</option>
                </select>
              </div>
              <div class="input-group"><label>Téléphone</label><input class="input" type="text" name="phone" value="<?= esc($client['phone'] ?? session('phone') ?? '') ?>"></div>
            </div>
            <div class="form-grid">
              <div class="input-group"><label>Poids (kg)</label><input class="input" type="number" step="0.01" name="poids" value="<?= esc($client['poids'] ?? session('poids') ?? '') ?>" required></div>
              <div class="input-group"><label>Taille (cm)</label><input class="input" type="number" step="0.01" name="taille" value="<?= esc($client['taille'] ?? session('taille') ?? '') ?>" required></div>
            </div>
            <div class="form-grid">
              <div class="input-group"><label>Âge</label><input class="input" type="number" name="age" value="<?= esc($client['age'] ?? session('age') ?? '') ?>" required></div>
              <div class="input-group"><label>Date de naissance</label><input class="input" type="date" name="date_naissance" value="<?= esc($client['date_naissance'] ?? session('date_naissance') ?? '') ?>" required></div>
            </div>
            <button class="btn btn-green full" type="submit">Finaliser et voir mon profil <i class="fa-solid fa-check"></i></button>
            <div class="auth-switch"><button type="button" onclick="backToStep1()">Retour étape 1</button></div>
          </form>
        </div>
      </div>
    </section>

    <!-- PROFIL -->
    <section class="page" id="page-profile">
      <div class="profile-hero">
        <div class="container profile-top">
          <div class="profile-avatar"></div>
          <div>
            <span class="badge"><i class="fa-solid fa-user-check"></i> Profil actif</span>
            <h1>Bonjour, <?= esc($client['username'] ?? session('username') ?? 'Client') ?></h1>
            <p>
              Email : <?= esc($user['email'] ?? session('email') ?? '-') ?>
              · Genre : <?= esc($client['genre'] ?? '-') ?>
              · Wallet : <?= esc($client['wallet'] ?? '0') ?> Ar
            </p>
          </div>
          <button class="btn btn-primary" onclick="showPage('menus')">Voir mes menus</button>
        </div>
      </div>
      <div class="container profile-grid">
        <article class="card pad reveal">
          <h3>Mon profil nutrition</h3>
          <?php if (session()->getFlashdata('success')): ?>
            <p style="color:#129a57;font-weight:700;"><?= esc(session()->getFlashdata('success')) ?></p>
          <?php endif; ?>
          <?php if (session()->getFlashdata('error')): ?>
            <p style="color:#c81e1e;font-weight:700;"><?= esc(session()->getFlashdata('error')) ?></p>
          <?php endif; ?>
          <form method="post" action="<?= site_url('profil/update') ?>">
            <?= csrf_field() ?>
            <div class="form-grid">
              <div class="input-group"><label>Email</label><input class="input" type="email" name="email" value="<?= esc($user['email'] ?? session('email') ?? '') ?>" required></div>
              <div class="input-group"><label>Nom d'utilisateur</label><input class="input" type="text" name="username" value="<?= esc($client['username'] ?? session('username') ?? '') ?>" required></div>
            </div>
            <div class="form-grid">
              <div class="input-group"><label>Téléphone</label><input class="input" type="text" name="phone" value="<?= esc(($client['phone'] ?? '') === '0' ? '' : ($client['phone'] ?? '')) ?>"></div>
              <div class="input-group">
                <label>Genre</label>
                <select class="select" name="genre" required>
                  <option value="">Choisir</option>
                  <option value="H" <?= (($client['genre'] ?? '') === 'H') ? 'selected' : '' ?>>Homme</option>
                  <option value="F" <?= (($client['genre'] ?? '') === 'F') ? 'selected' : '' ?>>Femme</option>
                </select>
              </div>
            </div>
            <div class="form-grid">
              <div class="input-group"><label>Taille (cm)</label><input class="input" type="number" step="0.01" min="50" max="250" name="taille" value="<?= esc($client['taille'] ?? '') ?>" required></div>
              <div class="input-group"><label>Poids (kg)</label><input class="input" type="number" step="0.01" min="10" max="300" name="poids" value="<?= esc($client['poids'] ?? '') ?>" required></div>
            </div>
            <button class="btn btn-primary full" type="submit">Enregistrer les modifications</button>
          </form>
        </article>
        <article class="card pad reveal">
          <h3>Détails client</h3>
          <div class="timeline">
            <div class="timeline-item"><i class="fa-solid fa-phone"></i><div><strong>Téléphone</strong><span><?= esc($client['phone'] ?? '-') ?></span></div></div>
            <div class="timeline-item"><i class="fa-solid fa-calendar-days"></i><div><strong>Date de naissance</strong><span><?= esc($client['date_naissance'] ?? '-') ?></span></div></div>
            <div class="timeline-item"><i class="fa-solid fa-crown"></i><div><strong>Statut Gold</strong><span><?= !empty($client['is_gold']) ? 'Oui' : 'Non' ?></span></div></div>
          </div>
        </article>
      </div>
    </section>

    <!-- ADMIN DASHBOARD -->
    <section class="page" id="page-admin-dashboard">
      <div class="page-head">
        <div class="container page-head-row">
          <div><span class="badge"><i class="fa-solid fa-shield-halved"></i> Admin</span><h1>Dashboard Admin</h1></div>
        </div>
      </div>
      <div class="container">
        <article class="card pad reveal">
          <div class="metric-grid" style="margin-bottom:14px;">
            <div class="metric"><strong><?= esc((string) ($stats['users'] ?? 0)) ?></strong><span>Utilisateurs</span></div>
            <div class="metric"><strong><?= esc((string) ($stats['regimes'] ?? 0)) ?></strong><span>Régimes</span></div>
            <div class="metric"><strong><?= esc((string) ($stats['ingredients'] ?? 0)) ?></strong><span>Ingrédients</span></div>
            <div class="metric"><strong><?= esc(number_format((float) ($stats['montant_total'] ?? 0), 0, ',', ' ')) ?> Ar</strong><span>Montant total transactions</span></div>
          </div>
          <div class="actions">
            <a class="btn btn-primary" href="<?= site_url('ingredient') ?>">Ingrédients</a>
            <a class="btn btn-green" href="<?= site_url('regime/create') ?>">Créer régime</a>
            <a class="btn btn-light" href="<?= site_url('regime/list') ?>">Liste régimes</a>
            <a class="btn btn-light" href="<?= site_url('admin/transactions') ?>">Transactions</a>
            <a class="btn btn-light" href="<?= site_url('parametres') ?>">Paramètres</a>
          </div>
        </article>

        <article class="card pad reveal" style="margin-top:14px;">
          <h3>Derniers utilisateurs</h3>
          <table><thead><tr><th>ID</th><th>Username</th><th>Email</th><th>Rôle</th></tr></thead><tbody>
            <?php foreach (($latest_users ?? []) as $u): ?>
              <tr><td><?= esc($u['id']) ?></td><td><?= esc($u['username']) ?></td><td><?= esc($u['email']) ?></td><td><?= esc($u['role']) ?></td></tr>
            <?php endforeach; ?>
          </tbody></table>
        </article>

        <article class="card pad reveal" style="margin-top:14px;">
          <h3>Derniers régimes</h3>
          <table><thead><tr><th>ID</th><th>Nom</th><th>Variation/semaine</th></tr></thead><tbody>
            <?php foreach (($latest_regimes ?? []) as $r): ?>
              <tr><td><?= esc($r['id']) ?></td><td><?= esc($r['name']) ?></td><td><?= esc($r['variation_poids_semaine']) ?></td></tr>
            <?php endforeach; ?>
          </tbody></table>
        </article>

        <article class="card pad reveal" style="margin-top:14px;">
          <h3>Dernières transactions</h3>
          <table><thead><tr><th>Date</th><th>Type</th><th>Client</th><th>Montant</th></tr></thead><tbody>
            <?php foreach (($latest_transactions ?? []) as $t): ?>
              <tr><td><?= esc($t['date']) ?></td><td><?= esc($t['type']) ?></td><td><?= esc($t['username'] ?? '-') ?></td><td><?= esc($t['montant']) ?> Ar</td></tr>
            <?php endforeach; ?>
          </tbody></table>
        </article>
      </div>
    </section>

    <!-- ADMIN INGREDIENT -->
    <section class="page" id="page-admin-ingredient">
      <div class="page-head"><div class="container page-head-row"><div><span class="badge"><i class="fa-solid fa-carrot"></i> Admin</span><h1>Ingrédients</h1></div></div></div>
      <div class="container">
        <article class="card pad reveal">
          <form action="<?= site_url('ingredient/create') ?>" method="post" class="row" style="margin-bottom:14px;">
            <?= csrf_field() ?>
            <div class="input-group"><label>Nom ingrédient</label><input class="input" type="text" name="name" required></div>
            <div class="actions" style="align-items:end;"><button class="btn btn-primary" type="submit">Ajouter</button></div>
          </form>
          <table><thead><tr><th>Nom</th></tr></thead><tbody>
            <?php foreach (($ingredients ?? []) as $item): ?><tr><td><?= esc($item['name']) ?></td></tr><?php endforeach; ?>
          </tbody></table>
        </article>
      </div>
    </section>

    <!-- ADMIN REGIME LIST -->
    <section class="page" id="page-admin-regime-list">
      <div class="page-head"><div class="container page-head-row"><div><span class="badge"><i class="fa-solid fa-list"></i> Admin</span><h1>Liste des régimes</h1></div></div></div>
      <div class="container">
        <article class="card pad reveal">
          <div class="actions" style="margin-bottom:10px;"><a class="btn btn-primary" href="<?= site_url('regime/create') ?>">Créer un régime</a></div>
          <table><thead><tr><th>Photo</th><th>Nom</th><th>Action</th></tr></thead><tbody>
            <?php foreach (($regimes ?? []) as $r): ?>
              <?php
                $img = 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=600&q=80';
                $nameLower = strtolower((string) ($r['name'] ?? ''));
                if (str_contains($nameLower, 'mass') || str_contains($nameLower, 'gain')) {
                    $img = 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80';
                } elseif (str_contains($nameLower, 'lean') || str_contains($nameLower, 'cut')) {
                    $img = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=600&q=80';
                } elseif (str_contains($nameLower, 'boost') || str_contains($nameLower, 'active')) {
                    $img = 'https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=600&q=80';
                }
              ?>
              <tr>
                <td><img src="<?= esc($img) ?>" alt="Regime" style="width:86px;height:58px;object-fit:cover;border-radius:10px;"></td>
                <td><?= esc($r['name']) ?></td>
                <td><a class="btn btn-light" href="<?= site_url('regime/detail/' . $r['id']) ?>">Détail</a></td>
              </tr>
            <?php endforeach; ?>
          </tbody></table>
        </article>
      </div>
    </section>

    <!-- ADMIN REGIME FORM -->
    <section class="page" id="page-admin-regime-form">
      <div class="page-head"><div class="container page-head-row"><div><span class="badge"><i class="fa-solid fa-pen-to-square"></i> Admin</span><h1>Créer un régime</h1></div></div></div>
      <div class="container">
        <article class="card pad reveal">
          <form action="<?= site_url('regime/create') ?>" method="post" class="row-1">
            <?= csrf_field() ?>
            <div class="input-group"><label>Nom</label><input class="input" type="text" name="regime_name" value="<?= esc((string) old('regime_name')) ?>" required></div>
            <div class="input-group"><label>Variation du poids / semaine</label><input class="input" type="number" step="any" name="variation_poids_semaine" value="<?= esc((string) old('variation_poids_semaine')) ?>" required></div>
            <div class="input-group"><label>Description</label><textarea class="input" name="description"><?= esc((string) old('description')) ?></textarea></div>
            <h3>Compositions (%)</h3>
            <div class="form-grid">
              <?php foreach (($ingredients ?? []) as $item): ?>
                <div class="input-group"><label><?= esc($item['name']) ?></label><input class="input" type="number" step="any" name="pourcentage_<?= esc($item['name']) ?>" value="<?= esc((string) old('pourcentage_' . $item['name'], '0')) ?>"></div>
              <?php endforeach; ?>
            </div>
            <h3>Prix</h3>
            <div id="prix-zone" class="row-1"><div class="form-grid"><div class="input-group"><label>Semaine</label><input class="input" type="number" name="semaine[]" required></div><div class="input-group"><label>Prix</label><input class="input" type="number" step="any" name="prix[]" required></div></div></div>
            <div class="actions"><button class="btn btn-light" type="button" onclick="addAdminWeekRow()">Ajouter semaine</button><button class="btn btn-primary" type="submit">Enregistrer</button></div>
          </form>
        </article>
      </div>
    </section>

    <!-- ADMIN REGIME DETAIL -->
    <section class="page" id="page-admin-regime-detail">
      <div class="page-head"><div class="container page-head-row"><div><span class="badge"><i class="fa-solid fa-circle-info"></i> Admin</span><h1>Détail régime</h1></div></div></div>
      <div class="container">
        <article class="card pad reveal">
          <?php if (!empty($regime)): ?>
            <?php
              $detailImg = 'https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=1000&q=80';
              $detailName = strtolower((string) ($regime['name'] ?? ''));
              if (str_contains($detailName, 'mass') || str_contains($detailName, 'gain')) {
                  $detailImg = 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=1000&q=80';
              } elseif (str_contains($detailName, 'lean') || str_contains($detailName, 'cut')) {
                  $detailImg = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=1000&q=80';
              } elseif (str_contains($detailName, 'boost') || str_contains($detailName, 'active')) {
                  $detailImg = 'https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=1000&q=80';
              }
            ?>
            <img src="<?= esc($detailImg) ?>" alt="Regime image" style="width:100%;max-height:280px;object-fit:cover;border-radius:14px;margin-bottom:12px;">
            <h2><?= esc($regime['name']) ?></h2>
            <p><?= esc($regime['description']) ?></p>
            <p><strong>Variation:</strong> <?= esc($regime['variation_poids_semaine']) ?> kg/semaine</p>
            <h3>Compositions</h3>
            <table><thead><tr><th>Ingrédient</th><th>%</th></tr></thead><tbody><?php foreach (($regime['compositions'] ?? []) as $c): ?><tr><td><?= esc($c['ingredient_name']) ?></td><td><?= esc($c['pourcentage']) ?></td></tr><?php endforeach; ?></tbody></table>
            <h3 style="margin-top:14px;">Prix</h3>
            <table><thead><tr><th>Semaine</th><th>Prix</th></tr></thead><tbody><?php foreach (($regime['prix'] ?? []) as $p): ?><tr><td><?= esc($p['duree_semaine']) ?></td><td><?= esc($p['prix']) ?> Ar</td></tr><?php endforeach; ?></tbody></table>
          <?php else: ?>
            <p>Régime introuvable.</p>
          <?php endif; ?>
          <div class="actions" style="margin-top:10px;"><a class="btn btn-light" href="<?= site_url('regime/list') ?>">Retour</a></div>
        </article>
      </div>
    </section>
  </main>

  <div class="modal" id="dishModal">
    <div class="modal-content">
      <div class="modal-img" id="modalImg"></div>
      <div class="modal-body">
        <h3 id="modalTitle">Titre du plat</h3>
        <p id="modalText">Description du plat.</p>
        <div class="modal-actions">
          <button class="btn btn-primary" onclick="showPage('signup1'); closeModal();">Ajouter à mon programme</button>
          <button class="btn btn-light" onclick="closeModal()">Fermer</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    const pages = ['home', 'menus', 'programs', 'login', 'signup1', 'signup2', 'profile', 'admin-dashboard', 'admin-ingredient', 'admin-regime-list', 'admin-regime-form', 'admin-regime-detail'];
    const navMenu = document.getElementById('navMenu');
    const mobileBtn = document.getElementById('mobileBtn');

    function showPage(name) {
      pages.forEach(page => document.getElementById('page-' + page).classList.remove('active'));
      document.getElementById('page-' + name).classList.add('active');
      document.querySelectorAll('[data-link]').forEach(btn => btn.classList.remove('active-link'));
      document.querySelectorAll('[data-link="' + name + '"]').forEach(btn => btn.classList.add('active-link'));
      navMenu.classList.remove('mobile-open');
      mobileBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
      window.scrollTo({ top: 0, behavior: 'smooth' });
      setTimeout(revealVisible, 80);
    }

    mobileBtn.addEventListener('click', () => {
      navMenu.classList.toggle('mobile-open');
      mobileBtn.innerHTML = navMenu.classList.contains('mobile-open') ? '<i class="fa-solid fa-xmark"></i>' : '<i class="fa-solid fa-bars"></i>';
    });

    const staticDishes = [
      { title: "Merlu, sauce à l’estragon, purée de carottes et riz", cat: "viande", label: "", img: "https://images.unsplash.com/photo-1532550907401-a500c9a57435?auto=format&fit=crop&w=900&q=85", desc: "Plat équilibré avec poisson, féculent et légumes doux." },
      { title: "Porc sauce au poivre, écrasé de pomme de terre et petits pois", cat: "viande", label: "", img: "https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=900&q=85", desc: "Une recette généreuse pour un programme classique." },
      { title: "Poulet au pesto rosso, mini penne et ratatouille", cat: "poulet pates", label: "", img: "https://images.unsplash.com/photo-1621996346565-e3dbc646d9a9?auto=format&fit=crop&w=900&q=85", desc: "Poulet, pâtes et légumes méditerranéens." },
      { title: "Poulet sauce thym citron et penne", cat: "poulet pates", label: "", img: "https://images.unsplash.com/photo-1551183053-bf91a1d81141?auto=format&fit=crop&w=900&q=85", desc: "Plat parfumé au citron avec pâtes fondantes." },
      { title: "Galettes végétariennes, légumes verts et pommes de terre", cat: "vegetarien", label: "Végétarien", img: "https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=900&q=85", desc: "Alternative végétarienne colorée et complète." },
      { title: "Lasagnes légères aux légumes du soleil", cat: "vegetarien pates", label: "Végétarien", img: "https://images.unsplash.com/photo-1574894709920-11b28e7367e3?auto=format&fit=crop&w=900&q=85", desc: "Recette chaude, rassurante et facile à intégrer." },
      { title: "Crevettes, riz parfumé et légumes croquants", cat: "viande", label: "", img: "https://images.unsplash.com/photo-1603133872878-684f208fb84b?auto=format&fit=crop&w=900&q=85", desc: "Un plat léger avec une belle présentation visuelle." },
      { title: "Bowl méditerranéen, riz et légumes grillés", cat: "vegetarien", label: "Nouveau", img: "https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=900&q=85", desc: "Bowl moderne adapté à une landing page internationale." }
    ];

    const dbRegimes = <?= json_encode($regimes ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const dishes = (Array.isArray(dbRegimes) && dbRegimes.length > 0)
      ? dbRegimes.map((r) => {
          const name = (r.name || 'Régime').toLowerCase();
          let img = "https://images.unsplash.com/photo-1490645935967-10de6ba17061?auto=format&fit=crop&w=900&q=85";
          if (name.includes('mass') || name.includes('gain') || Number(r.variation_poids_semaine) > 0) {
            img = "https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=900&q=85";
          } else if (name.includes('lean') || name.includes('cut') || Number(r.variation_poids_semaine) < 0) {
            img = "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=900&q=85";
          } else if (name.includes('boost') || name.includes('active')) {
            img = "https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?auto=format&fit=crop&w=900&q=85";
          }
          return {
            title: r.name || 'Régime',
            cat: Number(r.variation_poids_semaine) < 0 ? 'viande' : 'vegetarien',
            label: Number(r.variation_poids_semaine) > 0 ? 'Gain' : 'Perte',
            img,
            desc: r.description || 'Régime disponible dans notre programme.'
          };
        })
      : staticDishes;

    function renderDishes(list = dishes) {
      const grid = document.getElementById('dishGrid');
      grid.innerHTML = list.map((dish, index) => `
        <article class="dish-card reveal">
          ${dish.label ? `<div class="dish-label">${dish.label}</div>` : ''}
          <div class="dish-img" style="background-image:url('${dish.img}')"></div>
          <div class="dish-body">
            <h3>${dish.title}</h3>
            <div class="dish-meta">
              <div>
                <small style="font-size:.62rem;font-weight:900;color:#746678;display:block;margin-bottom:2px;">NUTRI-SCORE</small>
                <div class="nutri"><span>A</span><span>B</span><span>C</span><span>D</span><span>E</span></div>
              </div>
              <button class="zoom-btn" onclick="openDish(${index})"><i class="fa-solid fa-magnifying-glass"></i></button>
            </div>
          </div>
        </article>
      `).join('');
      setTimeout(revealVisible, 80);
    }

    function filterDishes() {
      const q = document.getElementById('searchDish').value.toLowerCase();
      const cat = document.getElementById('categoryFilter').value;
      const filtered = dishes.filter(dish => {
        const byText = dish.title.toLowerCase().includes(q);
        const byCat = cat === 'all' || dish.cat.includes(cat);
        return byText && byCat;
      });
      renderDishes(filtered);
    }

    function openDish(index) {
      const dish = dishes[index];
      document.getElementById('modalImg').style.backgroundImage = `url('${dish.img}')`;
      document.getElementById('modalTitle').textContent = dish.title;
      document.getElementById('modalText').textContent = dish.desc + ' Ce détail permet de simuler une vraie fiche plat professionnelle.';
      document.getElementById('dishModal').classList.add('active');
    }
    function closeModal() { document.getElementById('dishModal').classList.remove('active'); }

    function addAdminWeekRow() {
      const z = document.getElementById('prix-zone');
      if (!z) return;
      const d = document.createElement('div');
      d.className = 'form-grid';
      d.innerHTML = '<div class="input-group"><label>Semaine</label><input class="input" type="number" name="semaine[]" required></div><div class="input-group"><label>Prix</label><input class="input" type="number" step="any" name="prix[]" required></div>';
      z.appendChild(d);
    }

    function backToStep1() {
      const formStep2 = document.querySelector('#page-signup2 form.auth-form');
      if (!formStep2) return;

      const f = document.createElement('form');
      f.method = 'post';
      f.action = '<?= site_url('savePage2') ?>';

      const csrfTokenName = '<?= csrf_token() ?>';
      const csrfTokenValue = '<?= csrf_hash() ?>';
      const csrfInput = document.createElement('input');
      csrfInput.type = 'hidden';
      csrfInput.name = csrfTokenName;
      csrfInput.value = csrfTokenValue;
      f.appendChild(csrfInput);

      ['phone', 'genre', 'date_naissance', 'age', 'taille', 'poids'].forEach((name) => {
        const source = formStep2.querySelector(`[name="${name}"]`);
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = source ? source.value : '';
        f.appendChild(input);
      });

      document.body.appendChild(f);
      f.submit();
    }

    function validateCode() {
      const input = document.getElementById('programCode');
      const code = input.value.trim().toUpperCase();
      if (!code) {
        input.focus();
        input.style.boxShadow = '0 0 0 4px rgba(255,90,31,.18)';
        return;
      }
      if (code === 'NUTRI2026' || code === 'WELCOME' || code === 'FIT2026') {
        showPage('profile');
      } else {
        alert('Code non reconnu. Exemple de code test : NUTRI2026');
      }
    }
    document.getElementById('dishModal').addEventListener('click', e => { if (e.target.id === 'dishModal') closeModal(); });

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
    }, { threshold: .12 });

    function revealVisible() {
      document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    }

    <?php
      $requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
      $path = trim($requestPath, '/');
      $parts = $path === '' ? [] : explode('/', $path);
      $last = end($parts) ?: '';
      $initialPage = 'home';

      if (!empty($admin_view)) {
          $initialPage = $admin_view;
      } elseif ($last === 'login') {
          $initialPage = 'login';
      } elseif ($last === 'inscription') {
          $initialPage = 'signup1';
      } elseif ($last === 'step2') {
          $initialPage = 'signup2';
      } elseif ($last === 'profil') {
          $initialPage = 'profile';
      } elseif ($last === 'dashboard') {
          $initialPage = 'admin-dashboard';
      } elseif ($last === 'ingredient') {
          $initialPage = 'admin-ingredient';
      }
    ?>
    showPage('<?= esc($initialPage) ?>');

    renderDishes();
    revealVisible();
  </script>
</body>
</html>
