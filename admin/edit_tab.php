<?php 
require_once '../config/database.php';
include '../config/helper.php';

$id = (int)$_GET['id'];
$editquery = $db->query("SELECT * FROM tab WHERE id ='$id' ");
$edit_result = mysqli_fetch_assoc($editquery);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Repair - Edit Tab</title>
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
 			<div class="row">
				<div class="col-md-12 grid-margin stretch-card">
				  <div class="card">
				    <div class="card-body">
						<h4 class="card-title">Edit Tab</h4>
						<p class="text-danger" id="main-error-message"></p>
                        <form class="forms-sample col-sm-4" id="edit_tab_form" method="POST" enctype="multipart/form-data" novalidate>
                            <div class="form-group">
                              <label for="tab_name">Tab Name <span class="text-danger err_mes_tab" id="tab_name_err"></span></label>
                              <input type="text" class="form-control" name="tab_name" id="tab_name" value="<?=$edit_result['name'];?>">
                              <input type="hidden" class="form-control" name="id" value="<?=$edit_result['id'];?>">
                            </div>
                            <?php if (!empty($edit_result['icon_image'])) { ?>
                                <div class="image_prev" id="image_prev">
                                    <img src="../uploads/tabiconimage/<?=$edit_result['icon_image'];?>">
                                    <a onclick="delete_image(<?=$edit_result['id'];?>)" class="btn btn-dark btn-icon-text">Delete <i class="mdi mdi-delete-forever"></i></a>
                                </div>
                            <?php }else{ ?>
                                <div class="form-group" id="image_input">
                                    <label>Tab Icon Image <span class="text-danger err_mes_tab" id="tab_image_err"></span></label>
                                    <input type="file" name="tab_image" class="form-control">
                                </div>                     
                            <?php } ?>
                            <button type="submit" class="btn btn-primary mt-4 d-block">Submit</button>
                            <div class="form-preloader spinner-border text-primary preloader" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </form>
				    </div>
				  </div>
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
                url : 'validation/delete_image.php',
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

    $('#edit_tab_form').submit(function(e){
        e.preventDefault();

        $('#main-error-message').hide();
        $('#main-error-message').html("");

            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
                url: "validation/edit_tab.php",
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
