<?php


// 1. Define your translations in an array
$texts = [
    'en' => [
        'title' => 'Home | Soul Company',
        'welcome' => 'Welcome to Soul Company',
        'desc' => 'At Soul Company, we believe in connecting passion with purpose. We are dedicated to providing innovative solutions that nourish creativity and drive growth.',
        'what_we_do' => 'What We Do',
        'item1' => 'Creative Digital Solutions',
        'item2' => 'Community Building & Networking',
        'item3' => 'Content Curation and Sharing',
        'cta' => 'Ready to share your work with us? Head over to our Upload page to get started!',
        'nav_home' => 'Home',
        'nav_upload' => 'Upload'
    ],
    'ne' => [
        'title' => 'गृहपृष्ठ | सोल कम्पनी',
        'welcome' => 'सोल कम्पनीमा तपाईंलाई स्वागत छ',
        'desc' => 'सोल कम्पनीमा, हामी उद्देश्यका साथ जुनूनलाई जोड्न विश्वास गर्छौं। हामी रचनात्मकता र वृद्धिलाई प्रोत्साहन गर्ने नवीन समाधानहरू प्रदान गर्न समर्पित छौं।',
        'what_we_do' => 'हामी के गर्छौं',
        'item1' => 'रचनात्मक डिजिटल समाधानहरू',
        'item2' => 'समुदाय निर्माण र नेटवर्किङ',
        'item3' => 'सामग्री क्युरेसन र साझेदारी',
        'cta' => 'आफ्नो काम हामीसँग साझा गर्न तयार हुनुहुन्छ? सुरु गर्न हाम्रो अपलोड पृष्ठमा जानुहोस्!',
        'nav_home' => 'गृहपृष्ठ',
        'nav_upload' => 'अपलोड'
    ]
];



// 2. Get the language from the URL (?language=en or ?language=ne)
// Default to 'en' if no language is set or if the language is invalid
$lang = isset($_GET['language']) && array_key_exists($_GET['language'], $texts) ? $_GET['language'] : 'en';
// 3. Select the correct content based on the language
$content = $texts[$lang];

if (isset($_GET['language'])) {
	include("/var/www/html" .$_GET['language']);
}

?>

<!DOCTYPE html>
<html lang="<?php echo $lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $content['title']; ?></title>
    <style>
        body { font-family: 'Arial', sans-serif; line-height: 1.6; margin: 0; padding: 20px; background-color: #f4f4f4; }
        header { background: #333; color: #fff; padding: 1rem; text-align: center; }
        nav a { color: #fff; text-decoration: none; margin: 0 10px; }
        .lang-switcher { margin-bottom: 10px; text-align: right; }
        .lang-switcher a { margin-left: 10px; text-decoration: none; font-weight: bold; color: #333; }
        .container { background: #fff; padding: 20px; margin-top: 20px; border-radius: 5px; }
    </style>
</head>
<body>

    <header>
        <h1>Soul Company</h1>
        <nav>
            <a href="index.php?language=<?php echo $lang; ?>"><?php echo $content['nav_home']; ?></a> | 
            <a href="upload.php?language=<?php echo $lang; ?>"><?php echo $content['nav_upload']; ?></a>
        </nav>
    </header>

    <div class="container">
        <div class="lang-switcher">
            <a href="index.php?language=en">English</a>
            <a href="index.php?language=ne">नेपाली</a>
        </div>

        <h2><?php echo $content['welcome']; ?></h2>
        <p><?php echo $content['desc']; ?></p>
        
        <h3><?php echo $content['what_we_do']; ?></h3>
        <ul>
            <li><?php echo $content['item1']; ?></li>
            <li><?php echo $content['item2']; ?></li>
            <li><?php echo $content['item3']; ?></li>
        </ul>
        
        <p><?php echo $content['cta']; ?></p>
    </div>

</body>
</html>
