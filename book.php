<?php
$conn = new mysqli("localhost", "root", "", "railway_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit;
}

$name = trim($_POST['name'] ?? '');
$train_id = filter_input(INPUT_POST, 'train_id', FILTER_VALIDATE_INT);
$jdate = $_POST['jdate'] ?? '';

if ($name === '' || !$train_id || $jdate === '') {
    die("Please fill in all required fields.");
}

/* Validate date format and prevent past dates. */
$date = DateTime::createFromFormat('Y-m-d', $jdate);
if (!$date || $date->format('Y-m-d') !== $jdate || $jdate < date('Y-m-d')) {
    die("Please select a valid future journey date.");
}

/* Check that the selected train exists. */
$train_stmt = $conn->prepare("SELECT train_name, source, destination FROM trains WHERE train_id = ?");
$train_stmt->bind_param("i", $train_id);
$train_stmt->execute();
$train_result = $train_stmt->get_result();

if ($train_result->num_rows === 0) {
    die("Selected train does not exist.");
}

$train = $train_result->fetch_assoc();
$train_stmt->close();

/* Store passenger name in the users table. */
$user_stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
$placeholder_email = "passenger_" . time() . "_" . random_int(1000, 9999) . "@demo.local";
$user_stmt->bind_param("ss", $name, $placeholder_email);

if (!$user_stmt->execute()) {
    die("Unable to create passenger record: " . $user_stmt->error);
}

$user_id = $user_stmt->insert_id;
$user_stmt->close();

/* Store the booking in the bookings table. */
$booking_stmt = $conn->prepare(
    "INSERT INTO bookings (user_id, train_id, journey_date) VALUES (?, ?, ?)"
);
$booking_stmt->bind_param("iis", $user_id, $train_id, $jdate);

if (!$booking_stmt->execute()) {
    die("Unable to save booking: " . $booking_stmt->error);
}

$booking_id = $booking_stmt->insert_id;
$booking_stmt->close();

$pnr = "PNR" . str_pad((string)$booking_id, 8, "0", STR_PAD_LEFT);
?>
<!DOCTYPE html>
<html>
<head>
<title>Booked - RailYatri</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#0f172a;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.success-box{animation:pop 0.6s ease}
@keyframes pop{0%{transform:scale(0.5);opacity:0}100%{transform:scale(1);opacity:1}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-10px)}}
.ticket{background:white;width:420px;max-width:100%;border-radius:24px;overflow:hidden;box-shadow:0 30px 80px rgba(0,0,0,0.5);position:relative}
.top{background:linear-gradient(135deg,#2563eb,#7c3aed);padding:30px;text-align:center;color:white;position:relative}
.check{width:80px;height:80px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 15px;font-size:40px;animation:float 2s infinite}
.body{padding:30px;color:#0f172a}
.row{display:flex;justify-content:space-between;gap:20px;margin:15px 0;padding-bottom:12px;border-bottom:1px dashed #e2e8f0}
.label{color:#64748b;font-size:13px;text-transform:uppercase}.value{font-weight:600;font-size:16px}
.pnr-box{background:#f1f5f9;border:2px dashed #60a5fa;border-radius:12px;padding:15px;text-align:center;margin:20px 0}
.btn{display:block;width:100%;padding:15px;background:#0f172a;color:white;text-align:center;border-radius:12px;text-decoration:none;margin-top:10px;transition:0.3s;border:0;cursor:pointer;font-size:15px}
.btn:hover{background:#2563eb;transform:scale(1.02)}
.cut{position:absolute;left:-10px;top:58%;width:20px;height:20px;background:#0f172a;border-radius:50%}.cut2{position:absolute;right:-10px;top:58%;width:20px;height:20px;background:#0f172a;border-radius:50%}
@media print{body{background:white}.btn{display:none}.ticket{box-shadow:none}}
</style>
</head>
<body>
<div class="success-box">
<div class="ticket">
<div class="top">
<div class="check">✅</div>
<h2>Booking Confirmed!</h2>
<p style="opacity:0.9">Your e-ticket is ready</p>
<div class="cut"></div><div class="cut2"></div>
</div>
<div class="body">
<div class="pnr-box">
<div class="label">PNR Number</div>
<div class="value" style="font-size:22px;letter-spacing:2px;color:#2563eb"><?= htmlspecialchars($pnr) ?></div>
</div>

<div class="row">
<div><div class="label">Passenger</div><div class="value"><?= htmlspecialchars($name) ?></div></div>
<div><div class="label">Train ID</div><div class="value"><?= htmlspecialchars($train_id) ?></div></div>
</div>

<div class="row">
<div><div class="label">Train</div><div class="value"><?= htmlspecialchars($train['train_name']) ?></div></div>
<div><div class="label">Status</div><div class="value" style="color:#22c55e">CONFIRMED</div></div>
</div>

<div class="row">
<div><div class="label">Journey Date</div><div class="value"><?= htmlspecialchars($jdate) ?></div></div>
<div><div class="label">Route</div><div class="value"><?= htmlspecialchars($train['source']) ?> → <?= htmlspecialchars($train['destination']) ?></div></div>
</div>

<a class="btn" href="index.php">🎫 Book Another Ticket</a>
<button class="btn" style="background:white;color:#0f172a;border:2px solid #e2e8f0" onclick="window.print()">🖨️ Print Ticket</button>
</div>
</div>
<p style="text-align:center;color:#64748b;margin-top:20px;font-size:14px">Saved in RDBMS database railway_db • bookings table</p>
</div>
</body>
</html>
<?php $conn->close(); ?>
