<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance — {{ $settings->salon_name ?? 'SalonTime' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1a2e1c 0%, #303B32 60%, #1a2e1c 100%);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Inter', sans-serif; color: white; text-align: center; padding: 2rem;
        }
        .card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.12);
            backdrop-filter: blur(12px);
            border-radius: 2rem; padding: 3rem 2.5rem;
            max-width: 520px; width: 100%;
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
        }
        .icon { font-size: 3.5rem; margin-bottom: 1.5rem; color: #829780; }
        h1 { font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 1rem; }
        .badge {
            display: inline-flex; align-items: center; gap: .5rem;
            background: rgba(130,151,128,0.2); border: 1px solid rgba(130,151,128,0.4);
            color: #A0B29E; border-radius: 999px; padding: .4rem 1rem;
            font-size: .75rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .05em; margin-bottom: 1.5rem;
        }
        p { color: #D3DDD2; line-height: 1.7; font-size: .95rem; }
        .divider { width: 3rem; height: 2px; background: #829780; margin: 1.5rem auto; border-radius: 999px; }
        .contacts { display: flex; flex-wrap: wrap; gap: .75rem; justify-content: center; margin-top: 1.5rem; }
        .contact-chip {
            display: inline-flex; align-items: center; gap: .4rem;
            background: rgba(255,255,255,0.07); border: 1px solid rgba(255,255,255,0.1);
            border-radius: .75rem; padding: .5rem 1rem; font-size: .82rem; color: #D3DDD2;
        }
        .pulse { display: inline-block; width: .6rem; height: .6rem; background: #f59e0b; border-radius: 50%; animation: ping 1.2s ease-in-out infinite; }
        @keyframes ping { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.5;transform:scale(1.4)} }
        .admin-link {
            color: #A0B29E; text-decoration: none; font-size: .85rem; font-weight: 500;
            display: inline-flex; align-items: center; gap: .5rem; transition: color .2s;
        }
        .admin-link:hover { color: #ffffff; }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon"><i class="fas fa-scissors"></i></div>
        <span class="badge"><span class="pulse"></span> Maintenance en cours</span>
        <h1>{{ $settings->salon_name ?? 'SalonTime' }}</h1>
        <div class="divider"></div>
        <p>{{ $message }}</p>
        @if($settings->telephone ?? null)
            <div class="contacts">
                <span class="contact-chip"><i class="fas fa-phone"></i> {{ $settings->telephone }}</span>
                @if($settings->telephone2)
                    <span class="contact-chip"><i class="fab fa-whatsapp"></i> {{ $settings->telephone2 }}</span>
                @endif
                @if($settings->email)
                    <span class="contact-chip"><i class="fas fa-envelope"></i> {{ $settings->email }}</span>
                @endif
            </div>
        @endif

        <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.12);">
            @if(auth()->check() && auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; gap: .5rem; background: #829780; color: #fff; padding: .65rem 1.4rem; border-radius: .75rem; text-decoration: none; font-size: .85rem; font-weight: 600; box-shadow: 0 4px 12px rgba(0,0,0,0.2);">
                    <i class="fas fa-chart-line"></i> Accéder au Tableau de Bord Admin
                </a>
            @else
                <a href="{{ route('login') }}" class="admin-link">
                    <i class="fas fa-user-shield"></i> Espace Administrateur &bull; Se connecter
                </a>
            @endif
        </div>
    </div>
</body>
</html>
