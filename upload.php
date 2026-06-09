<?php
// ============================================================
// EDUCATIONAL DEMO ONLY — INTENTIONALLY VULNERABLE
// ============================================================

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = $_POST['name'];
    $email = $_POST['email'];

    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] == 0) {

        $filename = $_FILES['userfile']['name'];

        // 🔴 VULNERABILITY 1: No file type check — accepts ANY file (including .php)
        // 🔴 VULNERABILITY 2: User-controlled filename — no renaming
        $target = "uploads/" .$filename ;

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $target)) {

            // Strip .php extension for the ?page= parameter
            // because view.php adds .php automatically (just like index.php did)
            $page_param = "uploads/" . pathinfo($filename, PATHINFO_FILENAME);

            // 🔴 VULNERABILITY 3: Direct link to LFI page — attacker knows exact path
            $message = "
            <div class='success'>
                ✅ Thank you, <strong>" . htmlspecialchars($name) . "</strong>!<br>
                File uploaded: <code>" . htmlspecialchars($filename) . "</code><br>
                Saved at: <code>uploads/" . htmlspecialchars($filename) . "</code><br><br>
                <a href='view.php?page=" . $page_param . "'>📂 View Uploaded File →</a>
            </div>
            <div class='edu'>
                🎓 <strong>RFI Chain:</strong> If you uploaded <code>shell.php</code>, clicking the link above
                will make <code>view.php</code> execute it via <code>include()</code>!
            </div>";
        } else {
            $message = "<div class='error'>❌ Upload failed. Run: <code>chmod 777 uploads/</code></div>";
        }

    } else {
        $message = "<div class='error'>❌ No file selected or upload error.</div>";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CV | Soul Company</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        header { background: #333; color: #fff; padding: 1rem; text-align: center; }
        nav a { color: #fff; text-decoration: none; margin: 0 10px; }
        .container { background: #fff; padding: 24px; margin: 20px auto; border-radius: 6px; max-width: 520px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="email"], input[type="file"] {
            width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;
        }
        button { background: #333; color: #fff; padding: 10px 18px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #555; }

        .success { background: #eaffea; border: 1px solid #5cb85c; border-radius: 4px; padding: 14px; margin-bottom: 12px; color: #2d6a2d; }
        .success a { color: #1a6a1a; font-weight: bold; }
        .error   { background: #fff0f0; border: 1px solid #e74c3c; border-radius: 4px; padding: 14px; margin-bottom: 12px; color: #c0392b; }
        .edu     { background: #fff8e1; border-left: 4px solid #f39c12; padding: 12px 16px; font-size: 0.88rem; color: #7d5a00; }
        code     { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .warn    { background: #fff3cd; border: 1px solid #f39c12; border-radius: 4px; padding: 10px 14px; margin-bottom: 16px; font-size: 0.85rem; color: #856404; }
    </style>
</head>
<body>

<header>
    <h1>Soul Company</h1>
    <nav>
        <a href="index.php">Home</a> |
        <a href="upload.php">Upload CV</a> |
        <a href="view.php?page=home">View Page</a>
    </nav>
</header>

<div class="container">
    <h2>Register &amp; Upload CV</h2>

    <?php echo $message; ?>

    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="e.g. Jane Doe">
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required placeholder="jane@example.com">
        </div>
        <div class="form-group">
            <label for="userfile">Upload File 
            <input type="file" id="userfile" name="userfile" required>
        </div>
        <button type="submit">Submit</button>
    </form>

    <br>
    <div class="edu">
 <!--       <strong>🎓 How the RFI attack works here:</strong><br><br>
        <strong>Step 1:</strong> Create a file called <code>shell.php</code> on your computer:<br>
        <code>&lt;?php system($_GET['cmd']); ?&gt;</code><br><br>
        <strong>Step 2:</strong> Upload it using this form — no validation stops it.<br><br>
        <strong>Step 3:</strong> Click the "View Uploaded File" link after upload.<br><br>
        <strong>Step 4:</strong> <code>view.php</code> does <code>include("uploads/shell.php")</code> — your PHP runs!<br><br>
        <strong>Step 5:</strong> Add <code>&amp;cmd=whoami</code> to the URL to execute commands.
    </div> --!>
</div>

</body>
</html>

