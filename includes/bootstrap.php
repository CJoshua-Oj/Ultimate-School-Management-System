<?php
declare(strict_types=1);
session_start();
$config = require __DIR__ . '/../config/config.php';
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $db = new mysqli($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name']);
    $db->set_charset($config['db_charset']);
} catch (Throwable $e) {
    http_response_code(500);
    exit('Database connection failed. Check config/config.php.');
}
function e(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function post(string $key, string $default=''): string { return trim((string)($_POST[$key] ?? $default)); }
function get(string $key, string $default=''): string { return trim((string)($_GET[$key] ?? $default)); }
function redirect(string $url): never { header('Location: '.$url); exit; }
function logged_in(): bool { return !empty($_SESSION['user_id']) && !empty($_SESSION['login_type']); }
function require_login(): void { if (!logged_in()) redirect('login.php'); }
function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', post('csrf'))) { http_response_code(419); exit('Invalid security token.'); } }
function flash(string $msg, string $type='success'): void { $_SESSION['flash']=[$type,$msg]; }
function show_flash(): void { if (!empty($_SESSION['flash'])) { [$t,$m]=$_SESSION['flash']; unset($_SESSION['flash']); echo '<div class="alert '.e($t).'">'.e($m).'</div>'; } }
function setting(mysqli $db,string $type,string $fallback=''): string { $s=$db->prepare('SELECT description FROM settings WHERE type=? LIMIT 1'); $s->bind_param('s',$type); $s->execute(); $r=$s->get_result()->fetch_assoc(); return $r['description'] ?? $fallback; }
function user_table(string $role): string { return match($role){ 'admin'=>'admin','teacher'=>'teacher','student'=>'student','parent'=>'parent','librarian'=>'librarian','accountant'=>'accountant','hostel'=>'hostel', default=>''}; }
function login_user(mysqli $db,string $email,string $password): bool {
    foreach (['admin','teacher','student','parent','librarian','accountant','hostel'] as $role) {
        $table=user_table($role); $q=$db->prepare("SELECT * FROM `$table` WHERE email=? LIMIT 1"); $q->bind_param('s',$email); $q->execute(); $row=$q->get_result()->fetch_assoc();
        if ($row && hash_equals((string)$row['password'], $password)) {
            $_SESSION['user_id']=(int)($row[$role.'_id'] ?? $row['admin_id'] ?? 0); $_SESSION['login_type']=$role; $_SESSION['name']=$row['name'] ?? $email; $_SESSION['email']=$email; return true;
        }
    } return false;
}
function current_user(mysqli $db): ?array { if(!logged_in()) return null; $t=user_table($_SESSION['login_type']); $id=$_SESSION['user_id']; $pk=$_SESSION['login_type'].'_id'; $q=$db->prepare("SELECT * FROM `$t` WHERE `$pk`=? LIMIT 1"); $q->bind_param('i',$id); $q->execute(); return $q->get_result()->fetch_assoc() ?: null; }
