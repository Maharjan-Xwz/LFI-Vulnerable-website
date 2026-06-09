
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View | Soul Company</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        header { background: #333; color: #fff; padding: 1rem; text-align: center; }
        nav a { color: #fff; text-decoration: none; margin: 0 10px; }
        .container { background: #fff; padding: 24px; margin: 20px auto; border-radius: 6px; max-width: 800px; }
        .vuln-box { background: #fff8e1; border-left: 4px solid #f39c12; padding: 14px 18px; margin-bottom: 20px; font-size: 0.88rem; color: #7d5a00; }
        .vuln-box code { background: #f0e0a0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .result-box { background: #1e1e1e; color: #00ff00; padding: 18px; border-radius: 5px; font-family: monospace; min-height: 80px; }
        .error-box { background: #fff0f0; border: 1px solid #e74c3c; padding: 14px; border-radius: 4px; color: #c0392b; }
        code { background: #f0f0f0; padding: 2px 6px; border-radius: 3px; font-family: monospace; }
        .warn { background: #fff3cd; border: 1px solid #f39c12; border-radius: 4px; padding: 8px 14px; margin-bottom: 14px; font-size: 0.82rem; color: #856404; }
    </style>
</head>
<body>

<header>
    <h1>Soul Company</h1>
    <nav>
        <a href="index.php">Home</a> |
        <a href="upload.php">Upload CV</a> |
        <a href="view.php?page=uploads">View Page</a>
    </nav>
</header>

<?php
// ============================================================
// view.php — THE VULNERABLE FILE INCLUDER
// This is the file that makes LFI → RFI possible!
// ============================================================

$page = isset($_GET['page']) ? $_GET['page'] : 'home';
$see = pathinfo($page, PATHINFO_EXTENSION);



if ($see){
	echo "<img src='$page'>";
	//header('Content-Type: image/png');
}

// 🔴 VULNERABILITY: LFI (Local File Inclusion)
// $page comes directly from the URL with NO sanitization.
// We just add ".php" and include it. Attacker controls what gets included!
//
// Normal use:    ?page=home          → includes pages/home.php
// LFI attack:    ?page=../../../../etc/passwd  → reads system files (without .php trick)
// RFI via upload:?page=uploads/shell → includes & EXECUTES uploaded shell.php ← KEY STEP
//
$file = $page; // $file = $page . ".php";

?>




<?php
// ====================================================
// ⚠️  THIS IS THE VULNERABLE LINE  ⚠️
// include() executes whatever file $page points to.
// If $page = "uploads/shell" → it runs uploads/shell.php
// That's how LFI becomes Remote Code Execution!
// ====================================================
if (file_exists($page)) { //page
    include($page);
} else {
    echo "❌ File not found: " . htmlspecialchars($file) . "\n\n";
    echo "Hint: Make sure the file exists, or upload a shell.php via the Upload page!\n";
    echo "Then try: ?page=uploads/shell";
}




?>


    

</body>
</html>