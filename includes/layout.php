<?php
function page_header(string $title, array $active=[]): void { global $config,$db; $name=$_SESSION['name']??''; $role=$_SESSION['login_type']??''; ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?=e($title)?> | <?=e($config['app_name'])?></title><link rel="stylesheet" href="assets/css/app.css"></head><body>
<header class="top"><div class="brand"><a href="dashboard.php"><?=e($config['app_name'])?></a></div><div class="user"><?=e($name)?> (<?=e($role)?>) · <a href="logout.php">Logout</a></div></header>
<div class="layout"><aside><a href="dashboard.php">Dashboard</a><?php foreach($active as $item=>$url): ?><a href="<?=e($url)?>"><?=e($item)?></a><?php endforeach; ?><a href="profile.php">My Profile</a></aside><main><h1><?=e($title)?></h1><?php show_flash(); ?>
<?php }
function page_footer(): void { ?></main></div><footer>PHP 8.3 Native Application</footer><script src="assets/js/app.js"></script></body></html><?php }
