<?php 
require_once '../config/database.php';
include '../config/helper.php';

$tab_result = $db->query("SELECT * FROM tab");
$slide_result = $db->query("SELECT * FROM slides");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Repair - Add Slides</title>
  <?php include 'includes/style.php';?>

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
					<h4 class="card-title">Add Slides</h4>
					<p class="text-danger" id="main-error-message"></p>
					<form class="forms-sample no-pad-lf" id="add_slide_form" method="POST" enctype="multipart/form-data" novalidate>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="tab_id">Select Tab <span class="text-danger err_mes_tab" id="tab_id_err"></span></label>
                                  <select class="form-control" name="tab_id" id="tab_id">
                                    <option value="">Select tab</option>
                                    <?php while ($data = mysqli_fetch_assoc($tab_result)) : ?>
                                    <option value="<?=$data['id'];?>"><?=$data['name'];?></option>
                                    <?php endwhile; ?>                                    
                                  </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="heading">Slider Heading <span class="text-danger err_mes_tab" id="heading_err"></span></label>
                                  <input type="text" name="heading" class="form-control" id="heading">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="subheading">Slider Sub heading <span class="text-danger err_mes_tab" id="subheading_err"></span></label>
                                  <textarea name="subheading" class="form-control" id="subheading" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                  <label for="slide_image">Slider Image <span class="text-danger err_mes_tab" id="slide_image_err"></span></label>
                                  <input type="file" name="slide_image" class="form-control" id="slide_image">
                                </div>
                            </div>
                        </div>
						<button type="submit" class="btn btn-primary mr-2">Submit</button>
                        <div class="form-preloader spinner-border text-primary preloader" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
					</form>
			    </div>
			  </div>
              <div class="card mt-4">
                <div class="card-body">
                  <h4 class="card-title">Slide List</h4>
                  <p class="text-danger" id="main-error-message"></p>
                  <div class="table-responsive pt-3">
                    <table id="view_device_table" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Tab Name
                          </th>
                          <th>
                            Heading
                          </th>
                          <th>
                            SubHeading
                          </th>
                          <th>
                            Slide Image
                          </th>
                          <th>
                            Action
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($data = mysqli_fetch_assoc($slide_result)) : 
                            $tab_id = $data['tab_id'];
                            $tab_query = $db->query("SELECT * FROM tab WHERE id = '$tab_id' ");
                            $tab_result = mysqli_fetch_assoc($tab_query);
                            ?>
                        <tr>
                            <td><?=$tab_result['name'];?></td>
                            <td><?=$data['heading'];?></td>
                            <td><?=$data['subheading'];?></td>
                            <td><img src="../uploads/slideimage/<?=$data['image'];?>" class="table_img" style="width: 200px !important;"></td>
                            <td>
                                <a href="edit_slide.php?id=<?=$data['id'];?>" class="btn btn-dark btn-icon-text">Edit <i class="ti-file btn-icon-append"></i></a>
                                <button class="btn btn-dark btn-icon-text" onclick="removeslide(<?=$data['id'];?>)">Delete <i class="mdi mdi-delete-forever"></i></button>
                            </td>
                        </tr>                           
                        <?php endwhile; ?>
                      </tbody>
                    </table>
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

    function removeslide(id){
      $.ajaxSetup({
          url : 'validation/delete_slide.php',
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
    $('#add_slide_form').submit(function(e){
        e.preventDefault();

        $('#main-error-message').hide();
        $('#main-error-message').html("");

            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
                url: "validation/add_slides.php",
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
