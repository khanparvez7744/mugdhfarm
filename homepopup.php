<!-- important files linked -->
   <?php
   if($_SERVER['REQUEST_METHOD']=="POST")
   {
    if(isset($_POST['prt_btn'])){
            $name=$_POST['prt_name'];
            $address=$_POST['prt_address'];
            $phone=$_POST['prt_mobile'];
    $statement = $pdo->prepare("INSERT INTO tbl_mamber (name,account_type,address,phone) VALUES('$name','partner','$address','$phone')");
    $statement->execute();
    }
   }
    ?>
<!-- model popup for partner -->
<div class="modal p-5" id="Modal_partner">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <div class="">
              <h4 class="modal-title" style="font-size:20px;">Submit Your Detail</h4>
              <hr>
          </div>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
        <div class="modal-body">
                <div class="containe bg-light" style="font-size:16px;">
                    <form method="post">
                        <div class="form-group">
                            <label>Your Name:</label>
                            <input type="text" class="form-control" id="prt_name" placeholder="Enter your name" name="prt_name" autocomplete="off" style="font-size:16px;" required>
                        </div>
                        <div class="form-group">
                            <label>Address:</label>
                            <input type="text" class="form-control" id="prt_address" placeholder="Enter your address" name="prt_address" style="font-size:16px;">
                        </div>
                        <div class="form-group">
                            <label>Mobile Number:</label>
                            <input type="text" class="form-control" id="prt_mobile" placeholder="Enter mobile number" name="prt_mobile" style="font-size:16px;">
                        </div>
                            <button type="submit" class="btn btn-primary p-1" name="prt_btn" style="font-size:16px;">Submit</button>
                    </form>
     </div>
    </div>  
        <!-- close of body -->        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>
