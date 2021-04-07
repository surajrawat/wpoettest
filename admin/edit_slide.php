<?php 
require_once '../config/database.php';
include '../config/helper.php';

$id = (int)$_GET['id'];
$editquery = $db->query("SELECT * FROM slides WHERE id ='$id' ");
$edit_result = mysqli_fetch_assoc($editquery);

$tab_result = $db->query("SELECT * FROM tab");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Repair - Edit Slide</title>
  <?php include 'includes/style.php';?>
  <style type="text/css">
  </style>

</head>
<body>
<div class="container-scroller">
	<?php include 'includes/header.php';?>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
	<?php include 'includes/sidebar.php';?>
		<div class="main-panel">
			<div class="content-wrapper">
				  <div class="card">
				    <div class="card-body">
						<h4 class="card-title">Edit Slide</h4>
						<p class="text-danger" id="main-error-message"></p>
                        <form class="forms-sample no-pad-lf" id="edit_slide_form" method="POST" enctype="multipart/form-data" novalidate>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                      <label for="tab_id">Select Tab <span class="text-danger err_mes_tab" id="tab_id_err"></span></label>
                                      <select class="form-control" name="tab_id" id="tab_id">
                                        <option value="">Select tab</option>
                                        <?php while ($data = mysqli_fetch_assoc($tab_result)) : ?>
                                        <option value="<?=$data['id'];?>" <?=(($data['id'] == $edit_result['tab_id'])?' selected="selected"':'');?> ><?=$data['name'];?></option>
                                        <?php endwhile; ?>                                    
                                      </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                      <label for="heading">Slider Heading <span class="text-danger err_mes_tab" id="heading_err"></span></label>
                                      <input type="text" name="heading" class="form-control" id="heading" value="<?=$edit_result['heading'];?>">
                                      <input type="hidden" class="form-control" name="id" value="<?=$edit_result['id'];?>">                                      
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                      <label for="subheading">Slider Sub heading <span class="text-danger err_mes_tab" id="subheading_err"></span></label>
                                      <textarea name="subheading" class="form-control" id="subheading" rows="4"><?=$edit_result['subheading'];?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <?php if (!empty($edit_result['image'])) { ?>
                                        <div class="image_prev" id="image_prev">
                                            <img src="../uploads/slideimage/<?=$edit_result['image'];?>">
                                            <a onclick="delete_image(<?=$edit_result['id'];?>)" class="btn btn-dark btn-icon-text">Delete <i class="mdi mdi-delete-forever"></i></a>
                                        </div>
                                    <?php }else{ ?>
                                        <div class="form-group" id="image_input">
                                            <label>Slide Image <span class="text-danger err_mes_tab" id="slide_image_err"></span></label>
                                            <input type="file" name="slide_image" class="form-control">
                                        </div>                     
                                    <?php } ?>

                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2 mt-4">Submit</button>
                            <div class="form-preloader spinner-border text-primary preloader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>
				    </div>
				  </div>
			</div>
			<?php include 'includes/footer.php';?>
		</div>
	</div>
</div>
<?php
    mysqli_close($db);
    include 'includes/script.php';?>

<script type="text/javascript">
    function delete_image(id) {
        $.ajaxSetup({
                url : 'validation/delete_slide_image.php',
                method : 'POST',
                data : {id: id},
                async: true,
                beforeSend: function(){
                    $(".form-preloader").show();
                    $(".form-preloader").css("display","inline-block");
                },
                complete: function(){
                   $(".form-preloader").hide();
                }
            });
            $.post()
            .done(function(response) {
                var res = JSON.parse(response);
                var status = res['status'];
                var message = res['message'];
                var error = res['error'];

                if ( status == 'success' ){
                    location.reload();
                }else{
                    $('#main-error-message').show();
                    $('#main-error-message').html(message);
                }
            })
            .fail(function() {
                alert('failed to process');
            })
    }
</script>

<script type="text/javascript">

    $('#edit_slide_form').submit(function(e){
        e.preventDefault();

        $('#main-error-message').hide();
        $('#main-error-message').html("");

            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
                url: "validation/edit_slide.php",
                data: formData,
                async: true,
                cache: false,
                enctype: 'multipart/form-data',
                contentType: false,
                processData: false,
                beforeSend: function(){
                    $(".form-preloader").show();
                    $(".form-preloader").css("display","inline-block");
                },
                complete: function(){
                   $(".form-preloader").hide();
                }
            });
            $.post()
            .done(function(response) {
                var res = JSON.parse(response);
                var status = res['status'];
                var message = res['message'];
                var error = res['error'];

                if ( status == 'success' ){
                    location.reload();
                }
                else{
                    $('.err_mes_tab').html("");
                    if(Object.keys(error).length > 0)
                    {
                        for (x in error)
                        {
                            $('#'+x+'_err').html('('+error[x]+')');
                        }
                    }

                    $("html, body").animate({ scrollTop: 100 }, "slow");
                    $('#main-error-message').show();
                    $('#main-error-message').html(message);
                }
            })
            .fail(function() {
                alert('failed to process');
            })
            return false;
    });
</script>

</body>
</html>
