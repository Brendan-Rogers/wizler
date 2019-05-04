<?php
    ini_set('display_errors',1);
    error_reporting(E_ALL);
    
    include('admin/scripts/config.php');

    if (isset($_GET['display'])) {
        $mode = $_GET['display'];
        $display = index_photos($mode);
    } else {
        $display = index_photos('all');
    }  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>WIZLER | Gallery</title>
    <link rel="stylesheet" href="css/master.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
</head>
<body>

    <main class="container page">
        <h1 class="siteTitle">WIZLER</h1>

        

        <ul class="imgFilter">
            <li class="filterChoice"><a href="index.php?display=all">All</a></li>
            <li class="filterChoice"><a href="index.php?display=recent">Recent</a></li>
            <li class="filterChoice"><a href="index.php?display=featured">Featured</a></li>
        </ul>



        <section class="imgSect">

            <?php  while ($row = $display->fetch(PDO::FETCH_ASSOC)): ?>

                <div class="orgPoster">
                    <img src="images/user_images/<?php echo $row['file_name']; ?>" alt="submission <?php echo $row['id']; ?>" class="orgPosterImg">
                    <h3 class="pArtist">Artist: <?php echo $row['f_name'].' '.$row['l_name']; ?></h3>
                    <h4 class="pDate">Submitted on <?php $date = gmdate("Y/m/d", strtotime($row['upload_time'])); echo $date; ?></h4>
                </div>

            <?php endwhile; ?>


        </section>

        <footer>
            
            <h1 class="siteTitle">WIZLER</h1>

            <h4 class="copyright"><span class="centerer"></span><span class="centered">brendan rogers 2019</span></h4>

        </footer>
    </main>

    <section class="lightbox">
        <h2 class="hidden">light box</h2>
        <span class="closeLightbox">x</span>

        <div class="imgCon">
            <img src="images/user_images/#" alt="user poster" class="lbImg">
        </div>

    </section>

    <div class="submit_button">
        <a href="submit.php"><img src="images/submit_button.svg" alt="submit button"></a>
    </div>

    <script src="js/nav.js"></script>
    <script src="js/lightbox.js"></script>
</body>
</html>