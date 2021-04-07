<?php 
require_once 'config/database.php';

$tab_result = $db->query("SELECT * FROM tab");
$tab_content_result = $db->query("SELECT * FROM tab");

$mobiletab_content_result = $db->query("SELECT * FROM tab");


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Wpoet</title>
  <?php include 'includes/style.php';?>

</head>
<body>
    <?php include 'includes/header.php';?>
    <section class="section" id="tab_section">
        <div class="container">
            <div class="row" id="desktop_row">
                <div class="col-md-3" id="nav_pill">
                    <!-- Tabs nav -->
                    <div class="nav flex-column nav-pills nav-pills-custom" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <?php while ($data = mysqli_fetch_assoc($tab_result)) : ?>
                            <a class="nav-link p-3 shadow" id="v-pills-<?=$data['id'];?>-tab" data-toggle="pill" href="#v-pills-<?=$data['id'];?>" role="tab" aria-controls="v-pills-<?=$data['id'];?>" aria-selected="false">
                                <img src="uploads/tabiconimage/<?=$data['icon_image'];?>" class="icon_img">
                                <span class="font-weight-bold small text-uppercase"><?=$data['name'];?></span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <div class="col-md-4 no-pad-lf" id="nav_pill_content">
                    <!-- Tabs content -->
                    <div class="tab-content" id="v-pills-tabContent">
                        <?php while ($content_data = mysqli_fetch_assoc($tab_content_result)) : ?>
                            <div class="tab-pane p-5" id="v-pills-<?=$content_data['id'];?>" role="tabpanel" aria-labelledby="v-pills-<?=$content_data['id'];?>-tab">
                                <?php 
                                $tab_id = $content_data['id'];
                                $slide_result = $db->query("SELECT * FROM slides WHERE tab_id = '$tab_id' "); 
                                $slide_count = mysqli_num_rows($slide_result); 
                                //echo($slide_count);
                                ?>
                                <div id="carousel_<?=$content_data['id'];?>" class="carousel slide" data-ride="carousel">

                                  <!-- Indicators -->
                                  <ul class="carousel-indicators">
                                    <?php for ($i=0; $i < $slide_count; $i++) { ?> 
                                        <li data-target="#carousel_<?=$content_data['id'];?>" data-slide-to="<?=$i;?>"></li>                                    
                                    <?php } ?>

                                  </ul>

                                  <!-- The slideshow -->
                                    <div class="carousel-inner">
                                        <?php while ($slide_data = mysqli_fetch_assoc($slide_result)) : ?>
                                            <div class="carousel-item">
                                                <h4 class="heading"><?=$slide_data['heading'];?></h4>
                                                <p class="sub_heading"><?=$slide_data['subheading'];?></p>
                                                <img class="slide_image d-none" src="uploads/slideimage/<?=$slide_data['image'];?>">
                                            </div>
                                        <?php endwhile; ?>
                                    </div>
                                      <!-- Left and right controls -->
                                    <a class="carousel-control-prev" href="#carousel_<?=$content_data['id'];?>" data-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </a>
                                    <a class="carousel-control-next" href="#carousel_<?=$content_data['id'];?>" data-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </a>
                                    <script type="text/javascript">

                                        $('#carousel_<?=$content_data['id'];?>').on('slide.bs.carousel', function () { 
                                            var src = $('#carousel_<?=$content_data['id'];?> .carousel-inner .active').find('img').attr('src'); 
                                            console.log(src);
                                            $('#nav_pill_image img').attr('src',src);
                                        });

                                    </script>
                                </div>
                           </div>
                        <?php endwhile; ?>

                    </div>
                </div>
                <div class="col-md-4 no-pad-lf nav_pill_image" id="nav_pill_image">
                    <img src="">
                </div>
            </div>
            <div class="row" id="mobile_row">
                <div id="accordion" class="col-xs-12">
                  <?php while ($mobcontent_data = mysqli_fetch_assoc($mobiletab_content_result)) : 
                    $tab_id = $mobcontent_data['id'];
                    $mobslide_result = $db->query("SELECT * FROM slides WHERE tab_id = '$tab_id' "); 
                    $slide_count = mysqli_num_rows($mobslide_result);
                  ?>
                  <div class="card">
                    <div class="card-header" id="headingOne">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne<?=$mobcontent_data['id'];?>" aria-expanded="true" aria-controls="collapseOne">
                          <img src="uploads/tabiconimage/<?=$mobcontent_data['icon_image'];?>"> <?=$mobcontent_data['name'];?>
                        </button>
                    </div>

                    <div id="collapseOne<?=$mobcontent_data['id'];?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                      <div class="card-body">
                            <div id="mob_carousel_<?=$mobcontent_data['id'];?>" class="carousel slide" data-ride="carousel">

                              <!-- Indicators -->
                              <ul class="carousel-indicators">
                                <?php for ($i=0; $i < $slide_count; $i++) { ?> 
                                    <li data-target="#mob_carousel_<?=$mobcontent_data['id'];?>" data-slide-to="<?=$i;?>"></li>                                    
                                <?php } ?>

                              </ul>

                              <!-- The slideshow -->
                                <div class="carousel-inner">
                                    <?php while ($mobslide_data = mysqli_fetch_assoc($mobslide_result)) : ?>
                                        <div style="background-image:linear-gradient(rgba(92,165,184,0.7), rgba(92,165,184,0.7)), url(uploads/slideimage/<?=$mobslide_data['image'];?>);" class="carousel-item">
                                            <h4 class="heading"><?=$mobslide_data['heading'];?></h4>
                                            <p class="sub_heading"><?=$mobslide_data['subheading'];?></p>
                                            <img class="slide_image d-none" src="uploads/slideimage/<?=$mobslide_data['image'];?>">
                                        </div>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                      </div>
                    </div>
                  </div>
                  <?php endwhile; ?>
                </div>
            </div>
        </div>
    </section>
	<?php include 'includes/footer.php';?>    

<?php include 'includes/script.php';?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".nav-pills-custom .nav-link:first-child").addClass("active");
        $(".tab-content .tab-pane:first-child").addClass("show active");
        $(".carousel .carousel-inner .carousel-item:first-child").addClass("active");
        $(".carousel .carousel-indicators li:first-child").addClass("active");
        $("#accordion .card:first-child .collapse").addClass("show");


        var imgsrc = $(".tab-content .tab-pane:first-child .carousel .carousel-inner .active").find('img').attr('src');
        $('#nav_pill_image img').attr('src',imgsrc);

    });
</script>

</body>
</html>
