<?php require_once "init.php" ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/main.css">
    <title>Outsider Heart</title>
</head>
<body>

<?php if($model->isLoggedIn()): ?>
<div>
    <ul id="nav">
        <img src="assets/OHLogoSmol.png" alt="Outsider Heart logo">
        <li><a href="index.php">Home</a></li>
        <li><a href="store.php">Store</a></li>
        <li>About</li>
        <li id="signin"><a href="logout.php">Sign Out</a></li>
    </ul>
</div>
<div id="profile">
    <?php if ($model->haveUserImage()): ?>
        <img src="get-image.php?id=<?=$model->getImageId()?>" alt="profile picture">
    <?php endif; ?>
</div>


<?php else: ?>

<div>
    
    <ul id="nav">
       <img src="assets/OHLogoSmol.png" alt="Outsider Heart logo">
        <li><a href="index.php">Home</a></li>
        <li><a href="store.php">Store</a></li>
        <li>About</li>
        <li id="signin"><a href="login.php">Sign in</a></li> 
    </ul>
</div>
<?php endif; ?>
    
