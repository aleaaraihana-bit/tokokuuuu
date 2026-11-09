<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function e($value): string {
    return htmlspecialchars((string)($value ?? ""), ENT_QUOTES, "UTF-8");
}
function rupiah($angka): string {
    return "Rp " . number_format((float)$angka, 0, ",", ".");
}
function wajibLogin(): void {
    if (empty($_SESSION["user"])) {
        header("Location: login.php");
        exit;
    }
}
function wajibAdmin(): void {
    wajibLogin();
    if (($_SESSION["user"]["role"] ?? "") !== "admin") {
        header("Location: dashboard.php?pesan=akses");
        exit;
    }
}
function csrfToken(): string {
    if (empty($_SESSION["csrf"])) $_SESSION["csrf"] = bin2hex(random_bytes(32));
    return $_SESSION["csrf"];
}
function cekCsrf(): void {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $token = $_POST["csrf"] ?? "";
        if (!hash_equals($_SESSION["csrf"] ?? "", $token)) {
            http_response_code(403);
            exit("Permintaan tidak valid. Silakan kembali dan coba lagi.");
        }
    }
}
function pesan($jenis, $isi): void {
    $_SESSION["flash"] = ["jenis" => $jenis, "isi" => $isi];
}
function tampilPesan(): void {
    if (!empty($_SESSION["flash"])) {
        $f = $_SESSION["flash"];
        echo '<div class="alert ' . e($f["jenis"]) . '">' . e($f["isi"]) . '</div>';
        unset($_SESSION["flash"]);
    }
}
