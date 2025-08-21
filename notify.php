<?php
// notify.php — Telegram पर non-sensitive activity log भेजने के लिए
// आप ही के बताए token और chat id सेट कर रहा हूँ

$BOT_TOKEN = "7250347146:AAHNSzDLSOLYLGh5XcgNB1NLTI76PfzaX5k";
$CHAT_ID   = "5112680061";

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok' => false, 'error' => 'Method Not Allowed']);
  exit;
}

$raw = file_get_contents('php://input');
$payload = json_decode($raw, true);
if (!is_array($payload)) {
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => 'Invalid JSON']);
  exit;
}

$when = $payload['when'] ?? date('c');
$tz   = $payload['tz'] ?? 'Unknown TZ';
$note = $payload['note'] ?? 'No note';

$msg = "DigiShakti × Instagram — Activity Log\n"
     . "When: {$when}\n"
     . "TimeZone: {$tz}\n"
     . "Note: {$note}";

$apiUrl = "https://api.telegram.org/bot{$BOT_TOKEN}/sendMessage";

$ch = curl_init($apiUrl);
curl_setopt_array($ch, [
  CURLOPT_POST => true,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
  CURLOPT_POSTFIELDS => json_encode([
    'chat_id' => $CHAT_ID,
    'text'    => $msg
  ])
]);

$resp = curl_exec($ch);
$err  = curl_error($ch);
curl_close($ch);

if ($err) {
  http_response_code(500);
  echo json_encode(['ok' => false, 'error' => $err]);
  exit;
}

echo json_encode(['ok' => true, 'response' => json_decode($resp, true)]);