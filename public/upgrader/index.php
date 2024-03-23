<?php require_once 'filesList.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Twitcher Upgrader</title>


    <link rel="stylesheet" href="/css/style.min.css" />
</head>

<body>
    <div class="container mt-5 max-w-md mx-auto">
        <div class="card shadow p-5">
            <h1 class="font-bold text-xl">PHP Twitcher Upgrader 1.2</h1>
            <h3 class="font-semibold text-lg">What's new?</h3>

            <?php if (!isset($_GET['backup'])) : ?>
                <div class="bg-indigo-700 text-white rounded-lg p-3">
                    MAKE SURE TO HAVE A BACKUP OF EVERYTHING BEFORE PROCEEDING IN CASE OF FAILURE.<br>
                    Your current version MUST BE v1.1
                </div>

                <div class="alert alert-secondary">
                    <ul class="p-3 list-disc text-stone-600 font-semibold">
                        <li>Ability for streamers to ban users from viewing their live streaming/chat</li>
                        <li>For a streamer to ban an user, they can simply click the user in the live chat and a popup with the option will appear</li>
                        <li>Streamers can also overview banned users in their account and lift a ban if wanted</li>
                        <li>Admin can also view/lift bans from streamers towards users</li>
                    </ul>
                </div>

                <h3 class="mt-3">What files have changed?</h3>

                <div class="alert alert-secondary p-4">
                    <ol class="p-3 list-disc text-stone-600">
                        <li>public/build/*.*</li>
                        <?php
                        foreach ($filesList as $f) {
                            if (empty($f)) {
                                continue;
                            }
                            if (is_array($f)) {
                                continue;
                            }
                            echo '<li>' . $f . '</li>';
                        }
                        ?>
                    </ol>
                </div>

            <?php endif; ?>

            <h3 class="my-3">Proceed with the update. Attention: make sure your current version is v1.1</h3>

            <?php if (!isset($_GET['backup'])) { ?>
                <a href="/upgrader/index.php?backup=true" class="font-semibold rounded-lg mt-5 px-3 py-1.5 bg-indigo-700 text-white">
                    I have a backup - Continue
                </a>
            <?php } ?>

            <?php if (isset($_GET['backup'])) { ?>

                <div class="alert alert-info">
                    Ok, you have confirmed that you have a backup - click below to proceed
                </div>

                <br />
                <a href="process-upgrade.php" class="font-semibold rounded-lg mt-5 px-3 py-1.5 bg-indigo-700 text-white">
                    Proceed with the upgrader
                </a>
            <?php } ?>

            <div class="ugrade-message"></div>


        </div>
</body>

</html>
