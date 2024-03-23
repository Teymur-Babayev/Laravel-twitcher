<?php
require_once '../../vendor/autoload.php';
require_once 'filesList.php';

try {
    // parse .env for DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME
    $dotenv = Dotenv\Dotenv::createImmutable('../../');
    $dotenv->load();

    $db = new PDO('mysql:host=' . env("DB_HOST") . ';dbname=' . env("DB_DATABASE"), env("DB_USERNAME"), env("DB_PASSWORD"));

    echo 'Adding <strong>room bans</strong> table<br/>';

    $db->query("
    CREATE TABLE IF NOT EXISTS `room_bans` (
      `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
      `streamer_id` int UNSIGNED NOT NULL,
      `user_id` int UNSIGNED NOT NULL,
      `ip` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
      `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    );
    ");

    // echo 'Altering <strong>subscriptions</strong> table<br>';

    #$db->query("ALTER TABLE `subscriptions` CHANGE `subscription_expires` `subscription_expires` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;");
    #$db->query("ALTER TABLE `subscriptions` CHANGE `subscription_price` `subscription_price` DOUBLE(10,2) NULL DEFAULT NULL;");

    // $alterProductsQuery = "ALTER TABLE `products`
    // ADD `is_digital` ENUM('yes','no') NOT NULL DEFAULT 'no' AFTER `views`,
    // ADD `zip_file` VARCHAR(255) NULL DEFAULT NULL AFTER `is_digital`,
    // ADD `zip_disk` VARCHAR(255) NULL DEFAULT NULL AFTER `zip_file`;";
    //
    // $db->query($alterProductsQuery);
} catch (\Exception $e) {
    echo 'Cannot connect to database.';
    die($e->getMessage());
}

?>

<style>
    body {
        font-size: 18px;
        line-height: 30px;
        ;
    }
</style>
<?php


use Illuminate\Filesystem\Filesystem;

$file = new Filesystem();

$pathToUpgradeFiles = getcwd();
$pathToActualFiles = $pathToUpgradeFiles . '/../../';

// first, let's mirror public/build/*

$toBuildPath = getcwd() . '/../build';
$fromUpgraderBuildPath = getcwd() . '/upgrade-files/build';

$isCreatingUpgrade = true;

if (!$isCreatingUpgrade) {
    print 'Copying from <strong>' . $toBuildPath . '</strong> to <strong>' . $fromUpgraderBuildPath . '</strong><br>';
    $file->ensureDirectoryExists($fromUpgraderBuildPath);
    $file->copyDirectory($toBuildPath, $fromUpgraderBuildPath);
} else {
    print 'Copying from <strong>' . $fromUpgraderBuildPath . '</strong> to <strong>' . $toBuildPath . '</strong><br>';
    $file->deleteDirectory($toBuildPath);
    $file->ensureDirectoryExists($toBuildPath);
    $file->copyDirectory($fromUpgraderBuildPath, $toBuildPath);
}

foreach ($filesList as $f) {
    if (empty($f)) {
        continue;
    }

    if ($f == 'index.php') {
        $file->copy('upgrade-files/index.php', '../index.php');
        continue;
    }


    echo 'Replacing <strong>' . $f . '</strong><br>';

    $copyFile = $pathToUpgradeFiles . '/upgrade-files/' . $f;
    $toFile = $pathToActualFiles . $f;


    try {

        // copy from upgrade-files/ to ../
        if ($isCreatingUpgrade) {
            $file->copy($copyFile, $toFile, true);
            print $copyFile . ' -> ' . $toFile . '<br/>';
        }

        // don't uncomment this - it's used by @crivion
        // to generate upgrade-files
        // copy from files ../ to upgrade-files/
        if (!$isCreatingUpgrade) {
            $file->ensureDirectoryExists($file->dirname($copyFile));
            $file->copy($toFile, $copyFile);
            print $toFile . ' -> ' . $copyFile . '<br/>';
        }
    } catch (\Exception $e) {
        echo $e->getMessage() . '<br>';
    }
}

?>
<hr>
<h3 style="color: #cc0000">Congratulations, you are now on v1.0.6 - Remove /upgrader/ folder for SECURITY REASONS</h3>
