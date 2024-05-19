<?php
require "header.php";
?>

    <main>
        <div class="jumbotron" style="background-color: #0e0e0e; margin-top: -30px;">
            <div class="jumbotron" style="background-color: #0e0e0e; margin-top: -30px; margin-bottom: -40px;">
                <h1 class="title" style="text-align: center;">Mobile Version</h1>
            </div>


            <div class="jumbotron" style="background-color: #0e0e0e; margin-bottom: -15px; color: #ffffff">
                <?php
                $localIP = getHostByName(getHostName());
                echo "<div class='text-center p-3'>HOST IP: $localIP</div>";
                $qrCodeLink = "http://" . $localIP . "/Cinema";
                ?>
                <div style="text-align: center;">
                    <h4>Scan the QR code to access the website</h4>
                    <div class='text-center p-3'>Need to be on the same device, since the app is not published
                        anywhere!
                    </div>
                    <a href="./qrcode.php?text=<?php echo $qrCodeLink ?>" target="_blank"><img
                            alt="<?php echo $qrCodeLink ?>" src="./qrcode.php?text=<?php echo $qrCodeLink ?>"/></a>
                    <div class='text-center p-3'>❤️ Thanks for visiting ❤️</div>
                </div>
            </div>

        </div>

    </main>

<?php
require "footer.php";
?>