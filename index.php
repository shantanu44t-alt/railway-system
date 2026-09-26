<?php
$conn = new mysqli("localhost", "root", "", "railway_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM trains");

if (!$result) {
    die("Unable to load trains: " . $conn->error);
}
?>
<!DOCTYPE html>
<html>
<head>
<title>RailYatri - Railway Booking</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif}
body{background:#0f172a;color:white;overflow-x:hidden}
.navbar{background:rgba(255,255,255,0.05);backdrop-filter:blur(20px);padding:15px 5%;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:100;border-bottom:1px solid rgba(255,255,255,0.1)}
.logo{font-size:24px;font-weight:700;background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero{padding:60px 5%;display:flex;gap:40px;align-items:center;flex-wrap:wrap}
.hero-text h1{font-size:50px;line-height:1.1;margin-bottom:15px}
.hero-text h1 span{background:linear-gradient(90deg,#60a5fa,#a78bfa);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero-text p{color:#94a3b8;font-size:18px;margin-bottom:20px}
.card-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;padding:20px 5%}
.train-card{background:linear-gradient(135deg,rgba(255,255,255,0.08),rgba(255,255,255,0.03));border:1px solid rgba(255,255,255,0.1);border-radius:20px;padding:25px;transition:0.4s;position:relative;overflow:hidden}
.train-card:hover{transform:translateY(-10px) scale(1.02);box-shadow:0 20px 40px rgba(96,165,250,0.2);border-color:#60a5fa}
.train-card h3{font-size:22px;color:#60a5fa}.badge{background:#22c55e;padding:3px 10px;border-radius:20px;font-size:12px;position:absolute;top:15px;right:15px}
.booking-section{background:white;color:#0f172a;margin:40px 5%;border-radius:30px;padding:40px;display:flex;gap:40px;flex-wrap:wrap;box-shadow:0 30px 60px rgba(0,0,0,0.3)}
.booking-form{flex:1;min-width:300px}
.booking-form h2{font-size:32px;margin-bottom:20px}
.booking-form input,.booking-form select{width:100%;padding:15px;margin:10px 0;border:2px solid #e2e8f0;border-radius:12px;font-size:16px;outline:none;transition:0.3s}
.booking-form input:focus,.booking-form select:focus{border-color:#60a5fa;box-shadow:0 0 0 4px rgba(96,165,250,0.2)}
.btn{width:100%;padding:16px;background:linear-gradient(90deg,#2563eb,#7c3aed);color:white;border:none;border-radius:12px;font-size:18px;font-weight:600;cursor:pointer;transition:0.3s;margin-top:10px}
.btn:hover{transform:scale(1.02);box-shadow:0 10px 30px rgba(37,99,235,0.4)}
.lottie{flex:1;min-width:300px;display:flex;align-items:center;justify-content:center;font-size:100px}
.note{margin:0 5% 40px;color:#94a3b8;text-align:center;font-size:14px}
</style>
</head>
<body>
<div class="navbar"><div class="logo">🚆 RailYatri</div><div>Live • Fast • Secure</div></div>

<div class="hero">
<div class="hero-text">
<h1>Book Your <span>Journey</span><br> In Seconds</h1>
<p>Trains are loaded directly from your RDBMS database. Fast booking, instant confirmation.</p>
</div>
</div>

<div class="card-grid">
<?php while($row = $result->fetch_assoc()){ ?>
<div class="train-card">
<span class="badge"><?= htmlspecialchars($row['seats']) ?> Seats</span>
<h3>🚄 <?= htmlspecialchars($row['train_name']) ?></h3>
<p style="margin:10px 0;color:#cbd5e1">Train No: <?= htmlspecialchars($row['train_id']) ?></p>
<p style="font-size:14px;color:#94a3b8">
<?= htmlspecialchars($row['source']) ?> ➔ <?= htmlspecialchars($row['destination']) ?>
</p>
</div>
<?php } ?>
</div>

<div class="booking-section">
<div class="booking-form">
<h2>Book Ticket Now</h2>
<form action="book.php" method="POST">
<input type="text" name="name" placeholder="👤 Your Full Name" maxlength="100" required>

<select name="train_id" required>
<option value="">🚆 Select Train</option>
<?php
$result2 = $conn->query("SELECT train_id, train_name, source, destination FROM trains ORDER BY train_id");
while($train = $result2->fetch_assoc()){
?>
<option value="<?= htmlspecialchars($train['train_id']) ?>">
<?= htmlspecialchars($train['train_id']) ?> - <?= htmlspecialchars($train['train_name']) ?>
(<?= htmlspecialchars($train['source']) ?> → <?= htmlspecialchars($train['destination']) ?>)
</option>
<?php } ?>
</select>

<input type="date" name="jdate" min="<?= date('Y-m-d') ?>" required>
<button class="btn" type="submit">Book Now - Instant Confirm ✨</button>
</form>
</div>
<div class="lottie">🎟️<br><span style="font-size:18px;color:#64748b">Secure Railway Booking</span></div>
</div>

<div class="note">Demo project — booking data is saved in the railway_db RDBMS database.</div>
</body>
</html>
<?php $conn->close(); ?>
