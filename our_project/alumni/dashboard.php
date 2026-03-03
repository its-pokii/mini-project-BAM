<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'alumni') {
    header("Location: ../login.php");
    exit;
}

require_once("../auth/config.php");

$user_id = $_SESSION['user_id'];

// Get alumni info
$stmt = mysqli_prepare($connector, "SELECT first_name, last_name, profile_picture, job_title, company FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $first_name, $last_name, $profile_picture, $job_title, $company);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Pending requests count
$stmt2 = mysqli_prepare($connector, "SELECT COUNT(*) FROM connections WHERE alumni_id = ? AND status = 'pending'");
mysqli_stmt_bind_param($stmt2, 'i', $user_id);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $pending_count);
mysqli_stmt_fetch($stmt2);
mysqli_stmt_close($stmt2);

// Accepted connections count
$stmt3 = mysqli_prepare($connector, "SELECT COUNT(*) FROM connections WHERE alumni_id = ? AND status = 'accepted'");
mysqli_stmt_bind_param($stmt3, 'i', $user_id);
mysqli_stmt_execute($stmt3);
mysqli_stmt_bind_result($stmt3, $accepted_count);
mysqli_stmt_fetch($stmt3);
mysqli_stmt_close($stmt3);

// Unread messages count
$stmt4 = mysqli_prepare($connector, "SELECT COUNT(*) FROM messages WHERE receiver_id = ? AND is_read = 0");
mysqli_stmt_bind_param($stmt4, 'i', $user_id);
mysqli_stmt_execute($stmt4);
mysqli_stmt_bind_result($stmt4, $unread_count);
mysqli_stmt_fetch($stmt4);
mysqli_stmt_close($stmt4);

// Story views
$stmt5 = mysqli_prepare($connector, "SELECT COALESCE(SUM(views), 0) FROM stories WHERE alumni_id = ?");
mysqli_stmt_bind_param($stmt5, 'i', $user_id);
mysqli_stmt_execute($stmt5);
mysqli_stmt_bind_result($stmt5, $story_views);
mysqli_stmt_fetch($stmt5);
mysqli_stmt_close($stmt5);

// Last 3 pending requests
$stmt6 = mysqli_prepare($connector, "SELECT u.first_name, u.last_name, u.major, u.graduation_year, c.id, c.message
             FROM connections c JOIN users u ON c.student_id = u.id
             WHERE c.alumni_id = ? AND c.status = 'pending'
             ORDER BY c.created_at DESC LIMIT 3");
mysqli_stmt_bind_param($stmt6, 'i', $user_id);
mysqli_stmt_execute($stmt6);
mysqli_stmt_bind_result($stmt6, $r_first, $r_last, $r_major, $r_year, $r_id, $r_message);
$pending_requests = [];
while (mysqli_stmt_fetch($stmt6)) {
    $pending_requests[] = [
        'first_name'      => $r_first,
        'last_name'       => $r_last,
        'major'           => $r_major,
        'graduation_year' => $r_year,
        'connection_id'   => $r_id,
        'message'         => $r_message,
    ];
}
mysqli_stmt_close($stmt6);

$full_name      = htmlspecialchars(($first_name ?? 'Alumni') . ' ' . ($last_name ?? ''));
$first_only     = htmlspecialchars($first_name ?? 'Alumni');
$avatar_letter  = strtoupper(substr($first_name ?? 'A', 0, 1));
$pending_count  = (int)($pending_count  ?? 0);
$accepted_count = (int)($accepted_count ?? 0);
$unread_count   = (int)($unread_count   ?? 0);
$story_views    = (int)($story_views    ?? 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — UCA Connect</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:       '#2563eb',
                        'primary-dark':'#1d4ed8',
                        surface:       '#f8fafc',
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        .nav-link { transition: all .15s ease; }
        .nav-link:hover { background:#eff6ff; color:#2563eb; }
        .nav-link.active { background:#eff6ff; color:#2563eb; font-weight:600; }

        .stat-card { transition: transform .2s ease, box-shadow .2s ease; }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 8px 24px rgba(37,99,235,.10); }

        @keyframes fadeUp {
            from { opacity:0; transform:translateY(14px); }
            to   { opacity:1; transform:translateY(0); }
        }
        .fade-up { animation: fadeUp .4s ease both; }
        .fade-up:nth-child(1){animation-delay:.05s}
        .fade-up:nth-child(2){animation-delay:.10s}
        .fade-up:nth-child(3){animation-delay:.15s}
        .fade-up:nth-child(4){animation-delay:.20s}

        .req-row { transition: background .15s; }
        .req-row:hover { background:#f8fafc; }

        ::-webkit-scrollbar { width:5px; }
        ::-webkit-scrollbar-track { background:transparent; }
        ::-webkit-scrollbar-thumb { background:#cbd5e1; border-radius:99px; }
    </style>
</head>

<body class="bg-surface flex h-screen overflow-hidden text-gray-800">

    <!-- ===== SIDEBAR ===== -->
    <aside class="w-[230px] shrink-0 bg-white border-r border-gray-100 flex flex-col h-full">

        <div class="h-16 flex items-center gap-2.5 px-5 border-b border-gray-100">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center">
                <i data-lucide="activity" class="w-4 h-4 text-white"></i>
            </div>
            <span class="font-bold text-gray-900 text-[15px] tracking-tight">UCA Connect</span>
        </div>

        <nav class="flex-1 p-3 flex flex-col gap-0.5 overflow-y-auto">
            <a href="dashboard.php" class="nav-link active flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
            <a href="requests.php" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600">
                <i data-lucide="users" class="w-4 h-4"></i> Requests & Connections
                <?php if ($pending_count > 0): ?>
                <span class="ml-auto bg-primary text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?= $pending_count ?></span>
                <?php endif; ?>
            </a>
            <a href="messages.php" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600">
                <i data-lucide="message-square" class="w-4 h-4"></i> Messages
                <?php if ($unread_count > 0): ?>
                <span class="ml-auto bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full"><?= $unread_count ?></span>
                <?php endif; ?>
            </a>
            <a href="stories.php" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600">
                <i data-lucide="book-open" class="w-4 h-4"></i> Stories Management
            </a>
        </nav>

        <div class="p-3 border-t border-gray-100">
            <a href="profile.php" class="nav-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm text-gray-600">
                <i data-lucide="settings" class="w-4 h-4"></i> Profile & Settings
            </a>
            <div class="mt-2 flex items-center gap-3 px-3 py-2">
                <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-bold text-sm shrink-0">
                    <?= $avatar_letter ?>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-gray-800 truncate"><?= $full_name ?></p>
                    <p class="text-[11px] text-gray-400 truncate"><?= htmlspecialchars($job_title ?? 'Alumni') ?></p>
                </div>
            </div>
        </div>
    </aside>

    <!-- ===== MAIN ===== -->
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-6 shrink-0">
            <div class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 w-60">
                <i data-lucide="search" class="w-4 h-4 text-gray-400 shrink-0"></i>
                <input type="text" placeholder="Search..."
                       class="bg-transparent text-sm text-gray-600 outline-none w-full placeholder-gray-400">
            </div>
            <div class="flex items-center gap-3">
                <button class="relative w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 transition-colors">
                    <i data-lucide="bell" class="w-4 h-4 text-gray-500"></i>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
                <div class="w-9 h-9 rounded-xl bg-primary flex items-center justify-center text-white font-bold text-sm cursor-pointer">
                    <?= $avatar_letter ?>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto p-6">
            <div class="max-w-5xl mx-auto space-y-7">

                <!-- Welcome -->
                <div>
                    <h1 class="text-2xl font-extrabold text-gray-900 tracking-tight">Welcome back, <?= $first_only ?>! 👋</h1>
                    <p class="text-sm text-gray-400 mt-1">Here's a snapshot of your UCA Connect activity.</p>
                </div>

                <!-- Stat Cards -->
                <div>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Your Engagement at a Glance</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                        <div class="stat-card fade-up bg-white rounded-2xl border border-gray-100 p-5">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 bg-blue-50 rounded-xl flex items-center justify-center">
                                    <i data-lucide="user-plus" class="w-4 h-4 text-primary"></i>
                                </div>
                                <span class="text-[11px] text-gray-400">Requests</span>
                            </div>
                            <p class="text-3xl font-extrabold text-gray-900"><?= $pending_count ?></p>
                            <p class="text-xs text-gray-400 mt-1 mb-4">pending from students</p>
                            <a href="requests.php" class="flex items-center gap-1 text-xs text-primary font-semibold hover:underline">
                                View Pending <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>

                        <div class="stat-card fade-up bg-white rounded-2xl border border-gray-100 p-5">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 bg-emerald-50 rounded-xl flex items-center justify-center">
                                    <i data-lucide="user-check" class="w-4 h-4 text-emerald-600"></i>
                                </div>
                                <span class="text-[11px] text-gray-400">Connections</span>
                            </div>
                            <p class="text-3xl font-extrabold text-gray-900"><?= $accepted_count ?></p>
                            <p class="text-xs text-gray-400 mt-1">active connections</p>
                        </div>

                        <div class="stat-card fade-up bg-white rounded-2xl border border-gray-100 p-5">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 bg-orange-50 rounded-xl flex items-center justify-center">
                                    <i data-lucide="message-circle" class="w-4 h-4 text-orange-500"></i>
                                </div>
                                <span class="text-[11px] text-gray-400">Messages</span>
                            </div>
                            <p class="text-3xl font-extrabold text-gray-900"><?= $unread_count ?></p>
                            <p class="text-xs text-gray-400 mt-1 mb-4">unread messages</p>
                            <a href="messages.php" class="flex items-center gap-1 text-xs text-primary font-semibold hover:underline">
                                Go to Inbox <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>

                        <div class="stat-card fade-up bg-white rounded-2xl border border-gray-100 p-5">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-9 h-9 bg-purple-50 rounded-xl flex items-center justify-center">
                                    <i data-lucide="bar-chart-2" class="w-4 h-4 text-purple-600"></i>
                                </div>
                                <span class="text-[11px] text-gray-400">Story Views</span>
                            </div>
                            <p class="text-3xl font-extrabold text-gray-900"><?= number_format($story_views) ?></p>
                            <p class="text-xs text-gray-400 mt-1 mb-4">on your stories</p>
                            <a href="stories.php" class="flex items-center gap-1 text-xs text-primary font-semibold hover:underline">
                                Manage Stories <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </a>
                        </div>

                    </div>
                </div>

                <!-- Pending Requests -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                        <div>
                            <h2 class="font-bold text-gray-900">Pending Connection Requests</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Students waiting for your response</p>
                        </div>
                        <a href="requests.php" class="text-xs text-primary font-semibold hover:underline flex items-center gap-1">
                            View All <i data-lucide="arrow-right" class="w-3 h-3"></i>
                        </a>
                    </div>

                    <?php if (empty($pending_requests)): ?>
                        <div class="flex flex-col items-center justify-center py-12">
                            <i data-lucide="inbox" class="w-10 h-10 text-gray-200 mb-2"></i>
                            <p class="text-sm text-gray-400">No pending requests right now</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($pending_requests as $req): ?>
                        <div class="req-row flex items-center gap-4 px-5 py-4 border-b border-gray-50 last:border-0">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-primary font-bold text-sm shrink-0">
                                <?= strtoupper(substr($req['first_name'] ?? '', 0, 1)) ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800">
                                    <?= htmlspecialchars($req['first_name'] . ' ' . $req['last_name']) ?>
                                </p>
                                <p class="text-xs text-gray-400 truncate">
                                    <?= htmlspecialchars($req['major'] ?? 'Student') ?>
                                    <?= $req['graduation_year'] ? ' · ' . htmlspecialchars($req['graduation_year']) : '' ?>
                                </p>
                                <?php if (!empty($req['message'])): ?>
                                <p class="text-xs text-gray-500 mt-1 truncate italic">"<?= htmlspecialchars($req['message']) ?>"</p>
                                <?php endif; ?>
                            </div>
                            <div class="flex gap-2 shrink-0">
                                <form method="POST" action="connection-handler.php">
                                    <input type="hidden" name="connection_id" value="<?= (int)$req['connection_id'] ?>">
                                    <input type="hidden" name="action" value="decline">
                                    <button type="submit" class="px-4 py-1.5 text-xs font-semibold border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                                        Decline
                                    </button>
                                </form>
                                <form method="POST" action="connection-handler.php">
                                    <input type="hidden" name="connection_id" value="<?= (int)$req['connection_id'] ?>">
                                    <input type="hidden" name="action" value="accept">
                                    <button type="submit" class="px-4 py-1.5 text-xs font-semibold bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                                        Accept
                                    </button>
                                </form>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Quick Actions -->
                <div>
                    <h2 class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Quick Actions</h2>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">

                        <a href="requests.php" class="stat-card bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 hover:border-blue-200 group">
                            <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center group-hover:bg-primary transition-colors">
                                <i data-lucide="users" class="w-5 h-5 text-primary group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Manage Connections</p>
                                <p class="text-xs text-gray-400 mt-0.5">Review & organize your network</p>
                            </div>
                            <span class="text-xs text-primary font-semibold flex items-center gap-1 mt-auto">
                                View All <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </span>
                        </a>

                        <a href="stories.php" class="stat-card bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 hover:border-purple-200 group">
                            <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center group-hover:bg-purple-600 transition-colors">
                                <i data-lucide="book-open" class="w-5 h-5 text-purple-600 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Manage Stories</p>
                                <p class="text-xs text-gray-400 mt-0.5">Create, edit & share stories</p>
                            </div>
                            <span class="text-xs text-primary font-semibold flex items-center gap-1 mt-auto">
                                Go to Stories <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </span>
                        </a>

                        <a href="messages.php" class="stat-card bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 hover:border-orange-200 group">
                            <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center group-hover:bg-orange-500 transition-colors">
                                <i data-lucide="message-square" class="w-5 h-5 text-orange-500 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">View Messages</p>
                                <p class="text-xs text-gray-400 mt-0.5">Read & reply to your inbox</p>
                            </div>
                            <span class="text-xs text-primary font-semibold flex items-center gap-1 mt-auto">
                                Open Inbox <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </span>
                        </a>

                        <a href="profile.php" class="stat-card bg-white rounded-2xl border border-gray-100 p-5 flex flex-col gap-3 hover:border-emerald-200 group">
                            <div class="w-10 h-10 bg-emerald-50 rounded-xl flex items-center justify-center group-hover:bg-emerald-600 transition-colors">
                                <i data-lucide="settings" class="w-5 h-5 text-emerald-600 group-hover:text-white transition-colors"></i>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-800">Update Profile</p>
                                <p class="text-xs text-gray-400 mt-0.5">Keep your details current</p>
                            </div>
                            <span class="text-xs text-primary font-semibold flex items-center gap-1 mt-auto">
                                Edit Profile <i data-lucide="arrow-right" class="w-3 h-3"></i>
                            </span>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
<script>lucide.createIcons();</script>
</html>