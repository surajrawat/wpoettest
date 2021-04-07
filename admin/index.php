<?php 

require_once '../config/database.php';
include '../config/helper.php';


$tabresult = $db->query("SELECT * FROM tab");

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Repair - Add tab</title>
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
					<h4 class="card-title">Add Tab</h4>
					<p class="text-danger" id="main-error-message"></p>
					<form class="forms-sample no-pad-lf" id="add_tab_form" method="POST" enctype="multipart/form-data" novalidate>
              <div class="row">
                  <div class="col-sm-4">
                      <div class="form-group">
                        <label for="tab_name">Tab Name <span class="text-danger err_mes_tab" id="tab_name_err"></span></label>
                        <input type="text" class="form-control" name="tab_name" id="tab_name">
                      </div>
                  </div>
                  <div class="col-sm-4">
                      <div class="form-group">
                        <label for="tab_image">Tab Icon Image <span class="text-danger err_mes_tab" id="tab_image_err"></span></label>
                        <input type="file" name="tab_image" id="tab_image" class="form-control">
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
                  <h4 class="card-title">Tab List</h4>
                  <p class="text-danger" id="main-error-message"></p>
                  <div class="table-responsive pt-3">
                    <table id="view_device_table" class="table table-bordered">
                      <thead>
                        <tr>
                          <th>
                            Tab Name
                          </th>
                          <th>
                            Icon Image
                          </th>
                          <th>
                            Actions
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($data = mysqli_fetch_assoc($tabresult)) : ?>
                        <tr>
                            <td><?=$data['name'];?></td>
                            <td><img src="../uploads/tabiconimage/<?=$data['icon_image'];?>" class="table_img"></td>
                            <td>
                                <a href="edit_tab.php?id=<?=$data['id'];?>" class="btn btn-dark btn-icon-text">Edit <i class="ti-file btn-icon-append"></i></a>
                                <button class="btn btn-dark btn-icon-text" onclick="removetab(<?=$data['id'];?>)">Delete <i class="mdi mdi-delete-forever"></i></button>
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

    function removetab(id){
      $.ajaxSetup({
          url : 'validation/delete_tab.php',
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
    $('#add_tab_form').submit(function(e){
        e.preventDefault();

        $('#main-error-message').hide();
        $('#main-error-message').html("");

            var formData = new FormData($(this)[0]);

            $.ajaxSetup({
                url: "validation/add_tab.php",
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
