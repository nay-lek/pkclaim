<?php 
  session_start();
  error_reporting (E_ALL ^ E_NOTICE);
include("libs/function.php"); 
require_once "header.php";



if(isset($_POST['sts'])){

    $sts_ = $_POST['sts'];
    $_SESSION['date_visit']  =   str_replace('-','-',$_POST['date_visit']);
    $msg = "แสดงผลข้อมูลของวันที่ " . get_date_show($_SESSION['date_visit']) ;
    $date_visit_value = $_SESSION['date_visit'];
}else{
    
    $sts_  ="";  
    $date_visit_value = date("Y-m-d");
    $msg  = "แสดงผลข้อมูลของวันที่ " . get_date_show($date_visit_value) ;
    $_SESSION['date_visit'] =  date("Y-m-d");
}


?>

 <br>
 <br>
 <br>

<div class="container-fluid"> 
            <form class="form-inline" method="post">
                     <div class="input-group mb-2 mr-sm-2">
                            <div class="input-group-text" >เลือกวันที่รับบริการ</div>   
                    </div>   
                            
                    <input type="date" class="form-control mb-2 mr-sm-2" id="date_visit" name="date_visit"  value="<?php echo $_SESSION['date_visit'];?>" max =<?php echo date("Y-m-d");?>  required>

                    <div class="input-group mb-2 mr-sm-2">                        

                       <!-- <input type="date" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Username"> -->

                    </div>
                    <input type="hidden" name="sts" value="confirm">
                    <button type="submit" class="btn btn-primary mb-2">เลือก</button>
        
                    <div class="input-group mb-2 mr-sm-2">
                        
                            <div class="input-group"> <?php echo $msg; ?></div>   
                    </div>  

                </form>
                <div class="input-group mb-2 mr-sm-2">
                    <div class="input-group"> <button onClick="window.location.reload();" class="btn btn-success mb-2">แสดงผล</button>
                </div>   </div>  

</div>
<br>


        <div class="container-fluid">       
            <div class="card-deck">
                <div class="card bg-primary">
                    <div class="card-header text-center">
                        <h1><b>ทั้งหมด</b></h1>
                    </div>
                    <div class="card-body text-center">
                        <p class="card-text"> <h1 class="display-1" style="color:#FFFFFF"> <a href='index_show.php' style='color:#FFFFFF'><?php echo  get_all_visit($date_visit_value);?></a></h1></p>
                   
                    </div>
                </div>
                <div class="card bg-success">
                    <div class="card-header text-center">
                        <h1><b>ขอแล้ว</b></h1>
                    </div>
                    <div class="card-body text-center">
                       <p class="card-text"><h1 class="display-1" style="color:#FFFFFF;align-text:center"> <a href='index_show.php?st=P' style='color:#FFFFFF'> <?php echo get_visit_authen_pass($date_visit_value);?></a></h1> </p> 
                    </div>
                </div>
                <div class="card bg-danger">
                    <div class="card-header text-center">
                        <h1><b>รอการขอ</b></h1>
                    </div>
                    <div class="card-body text-center">
                      <p class="card-text"><h1 class="display-1"> <a href='index_show.php?st=W' style='color:#FFFFFF'><?php echo  get_visit_authen_wait($date_visit_value);?></a></h1></p>
                    </div>
                </div>
                <div class="card bg-warning">
                    <div class="card-header text-center">
                        <h1><b>ไม่มีVisit</b></h1>
                    </div>
                    <div class="card-body text-center">
                    <p class="card-text"><h1 class="display-1"> <a href='index_show.php?st=NV' style='color:#FFFFFF'><?php echo (get_non_visit($date_visit_value)); ?></a> </h1></p>
                    </div>
                </div>     
                
            </div>
            <br>

                <!-- แสดง Card แนวนอน -->
                <div class="card-deck">
                    <div class="card bg-danger">
                        <div class="card-body text-center">
                            <p class="card-text"><h1><b>ClaimCode ไม่ตรง | <a href='index_show.php?st=ERR' style='color:#FFFFFF'> <?php echo (get_claim_code_Error($date_visit_value)) ; ?> </a></b></h1> </p>
                        </div>
                    </div>
                    
                    <div class="card bg-info">
                        <div class="card-body text-center">
                            <p class="card-text"><h1><b>ยืนยัน % | <?php echo round(((get_visit_authen_pass($date_visit_value)/ get_all_visit($date_visit_value))*100)) . "%"; ?> </b></h1> </p>
                        </div>
                    </div>
                </div>
        </div>









    <script src="dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
  <br>
  <?php  require_once "footer.php"; ?>
</html>