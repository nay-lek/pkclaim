<?php
        include("libs/function.php"); 
        include("conn/conn.php");
       
        require_once "excel/PHPExcel.php";//เรียกใช้ library สำหรับอ่านไฟล์ excel        
?>


<!DOCTYPE html>
<html lang="en">
 
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
    <title>pkhosp_eclaim_import</title>
    <link href="dist/css/bootstrap.min.css">
    <link href="dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>  


    <style>
        table {
          font-family: arial, sans-serif;
          border-collapse: collapse;
          width: 100%;
        }

        td, th {
          border: 1px solid #dddddd;
          text-align: left;
          padding: 8px;
        }

        tr:nth-child(even) {
          background-color: #dddddd;

        }

        table, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }

        #myProgress {
              width: 100%;
              background-color: grey;
            }

            #myBar {
              width: 1%;
              height: 30px;
              background-color: green;
            }
    </style>
</head>
<body>

            <header class="navbar navbar-dark bg-dark fixed-top">
                          <div class="container-fluid">
                              <a class="navbar-brand" href="index.php">ระบบ Authen Eclaim : โรงพยาบาลผาขาว  V1.65.11.4</a>
                              <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
                              <span class="navbar-toggler-icon"></span>
                              </button>
                              <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                              <div class="offcanvas-header">
                                  <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">เลือกเมนู</h5>
                                  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                              </div>
                              <div class="offcanvas-body">
                                  <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                  <li class="nav-item">
                                      <a class="nav-link active" aria-current="page" href="index.php">หน้าแรก</a>
                                  </li>
                                  <li class="nav-item">
                                      <a class="nav-link" href="index_import.php">นำเข้าข้อมูลจากโปรแกรม</a>
                                  </li>
                                  <li class="nav-item dropdown">
                                      <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                      Dropdown
                                      </a>
                                      <ul class="dropdown-menu dropdown-menu-dark">
                                      <li><a class="dropdown-item" href="#">Action</a></li>
                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                      <li>
                                          <hr class="dropdown-divider">
                                      </li>
                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                      </ul>
                                  </li>
                                  </ul>
                                  <form class="d-flex mt-3" role="search">
                                  <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                  <button class="btn btn-success" type="submit">Search</button>
                                  </form>
                              </div>
                              </div>
                          </div>
              </header>
        

<pre>
                            
                              <!-- ส่วนของฟอร์มส่งค่า --> 
                                    <div  class="row" style="background: rgba(0, 128, 0, 0.3); text-align: left;"><!-- /* Green background with 30% opacity */ --> 
                                                <form action="" method="post" enctype="multipart/form-data" name="form1">
                                                    เลือกไฟล์ที่ต้องการอัพโหลด : <input type="file" name="_fileup" id="_fileup"><br>
                                                    <button type="submit" name="btn_submit" class="btn-success">แสดงรายละเอียดและนำเข้าข้อมูล</button>                     
                                                    
     
                                                  </form>

                                  
             
                                            <?php

                                                if(isset($_POST['btn_submit'])  && isset($_FILES['_fileup']['name']) && $_FILES['_fileup']['name']!=""){
                                                    $tmpfname = $_FILES['_fileup']['tmp_name'];  
                                                    $fileName = $_FILES['_fileup']['name'];  // เก็บชื่อไฟล์
                                                    $_fileup = $_FILES['_fileup'];
                                                    $info = pathinfo($fileName);
                                                    $allow_file = array("xls","xlsx");
                                                    $startrow = 2 ;  // ตั้งค่าการอ่านจากแถวเริ่มต้น                                  

                                                    $filetype =  explode('.',$fileName); // ดึงข้อมูลชริดของไฟล์มาเก็บที่ตัวแปล $filetype 
                                                    //print_r($filetype[1]);
                                                  //  echo $filetype[1];

                                                    
                                                  if(chk_file_tyep($filetype[1])<>1){  //เช็คว่าชนิดของไฟล์เป็น Excel หรือไม่
                                                    print_r("รูปแบบไฟล์ไม่ใช่ Excel(.xls หรือ .xlsx)ไฟล์! กรุณาตรวจสอบรุปแบบใหม่อีกครั้ง. " );
                                                    exit;
                                                    

                                                    }else{

                                                              if($fileName!="" && in_array($info['extension'],$allow_file)){
                                                                      $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
                                                                      $excelObj = $excelReader->load($tmpfname);//อ่านข้อมูลจากไฟล์
                                                                      $worksheet = $excelObj->getSheet(0);//อ่านข้อมูลจาก sheet แรก
                                                                    // $lastRow = $worksheet->getHighestRow(''); //นับว่า sheet แรกมีทั้งหมดกี่แถวแล้วเก็บจำนวนแถวไว้ในตัวแปรชื่อ $lastRow                            
                                                                    $lastRow = $worksheet->getHighestDataRow('C'); //นับว่า sheet แรกมีทั้งหมดกี่แถว(อ้างอิงด้วย Colunm B)แล้วเก็บจำนวนแถวไว้ในตัวแปรชื่อ 
                                                                    $hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);  // อ่านชื่อเครื่องที่กำลังใช้งานระบบ
                                                                    $nameworksheet = $excelObj->getSheetNames()[0]; //อ่านชื่อ sheetName
                                                                            
                                                              }

                                                              
                                                                    if($nameworksheet!="authencode"){ // เช็คว่าชื่อ sheet เป็นไฟล์ที่โหลดจากเว็บหรือไม่โดยกำหนดเป็น "authencode" เท่านั้น
                                                                        print_r("รูปแบบไฟล์ไม่ได้ส่งมาจากหน้าเว็บ สปสช. กรุณาตรวจสอบรุปแบบใหม่อีกครั้ง! " );
                                                                        exit;
                                                                    }
                                                    }

                                        ?>


                                        <!--  ส่วนของการอ่านค่า -->
                                        <div class="container" style="background: rgba(128, 0, 0, 0.3); text-align: left;"><!-- /* Green background with 30% opacity */ --> 

                                                   <?php                                              
                                                                    
                                                          //   $get_id =  $worksheet->getCell('A'.$startrow)->getValue(). $worksheet->getCell('C'.$startrow)->getValue(). $worksheet->getCell('P'.$startrow)->getValue();
                                                                        echo("<b>ไฟล์ที่แสดงขณะนี้</b> : ".$fileName ."<br>") ;  
                                                                        echo "<b>จำนวน</b> : ". ($lastRow-($startrow-1)) ." ราย<br>" ;                                    
                                                                        echo "<b>เครื่องคอมพิวเตอร์</b> : ". $hostname ."<br>";
                                                                        echo  "<b>สถานะการนำเข้า</b> : <font style='color:green;'> นำเข้าสำเร็จ Success.</font> <br>";
                                                                        print_r("<b>Sheet name</b> : ".$nameworksheet );

                                                    ?>                            
                                      
                                  
                                    </div>

                      </div>
                      <!--  ส่วนของการแสดงค่า -->
                      <div class="container-fluid" >           
                         <button type="submit" name="btn_submit" class="btn-primary">แสดงรายละเอียดข้อมูลของไฟล์ : <?php echo $fileName; ?></button>                     
                      <?php   $tb_show_affther_import  =  "";       
                              $tb_show_affther_import =$tb_show_affther_import . "<table>";
                              $tb_show_affther_import =$tb_show_affther_import . "  <tr>
                                          <th>รหัสหน่วย</th>
                                          <th>ชื่อหน่วย</th>
                                          <th>เลขบัตร</th>
                                          <th>ชื่อ-สกุล</th>
                                          <th>วันเกิด(YMD)</th>
                                          <th>เบอร์โทร</th>
                                          <th>สิทธิหลัก</th>
                                          <th>สิทธิย่อย</th>                                          
                                          <th>รหัสการเข้ารับบริการ</th>   
                                          <th>CLAIM_CODE</th>                                      
                                          <th>ประเภทการเข้ารับบริการ</th>
                                          <th>รหัสบริการ</th>
                                          <th>บริการ</th>
                                          <th>HN</th>
                                          <th>AN</th>
                                          <th>วันที่เข้ารับบริการ</th>
                                          <th>วันที่บันทึก-AuthenCode</th>
                                          <th>สถานะใช้งาน</th>
                                          <th>ช่องทางการขอ-AuthenCode</th>
                                          <th>วิธีการพิสูจน์ตัวตน</th>
                                          <th>ผู้จับของการเข้ารับบริการ</th>
                                          <th>วันที่แก้ไข-AuthenCode</th>
                                          <th>ชื่อผู้ที่แก้ใข-AuthenCode</th>
                                          <th>หมายเหตุการยกเลิก</th>
                                          <th>สถานะ Update</th>
                              
                                    </tr>";

                              $vn_vv  = [];
                         for ($row = $startrow; $row <= $lastRow; $row++)//วน loop อ่านข้อมูลเอามาแสดงทีละแถว
                            {   
                                $id_visit = substr($worksheet->getCell('Q'.$row)->getValue(),8,2); //ตัดข้อมูล Year
                                $id_visit =  $id_visit.substr($worksheet->getCell('Q'.$row)->getValue(),3,2); //ตัดข้อมูล Month
                                $id_visit =  $id_visit.substr($worksheet->getCell('Q'.$row)->getValue(),0,2); //ตัดข้อมูล DAY 
                                $vn6_id = $id_visit ;
                                $id_visit = $id_visit . $worksheet->getCell('C'.$row)->getValue();//ถอดรหัส id_visit
                                $claim_code =  $worksheet->getCell('J'.$row)->getValue(); //ดึงรหัส ClaimCode
                                
                                $vn_vv[$row] = get_vn_his( $vn6_id , $id_visit,$claim_code);


                                if($vn_vv[$row]=="0 results"){
                                    $bg_color = "red";
                                 } else{
                                   $bg_color = "";
                                }

                                $tb_show_affther_import = $tb_show_affther_import . "<tr style='background-color:$bg_color'><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('A'.$row)->getValue();//แสดงข้อมูลใน colum A  >> รหัสหน่วย
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('B'.$row)->getValue();//แสดงข้อมูลใน colum B >>ชื่อหน่วย
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('C'.$row)->getValue();//แสดงข้อมูลใน colum C >> เลขบัตร
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('D'.$row)->getValue();//แสดงข้อมูลใน colum D >> ชื่อ-สกุล
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>"; 
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('E'.$row)->getValue();//แสดงข้อมูลใน colum E >> วันเกิด 
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('F'.$row)->getValue();//แสดงข้อมูลใน colum G >> เบอร์โทร
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('G'.$row)->getValue();//แสดงข้อมูลใน colum H >> สิทธิหลัก
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('H'.$row)->getValue();//แสดงข้อมูลใน colum I  >> สิทธิย่อย
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('I'.$row)->getValue();//แสดงข้อมูลใน colum J >> รหัสการเข้ารับบริการ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('J'.$row)->getValue(); //แสดงข้อมูลใน colum K >> CLAIM_CODE
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('K'.$row)->getValue();//แสดงข้อมูลใน colum L >> ประเภทการเข้ารับบริการ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('L'.$row)->getValue();//แสดงข้อมูลใน colum M >> รหัสบริการ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('M'.$row)->getValue();//แสดงข้อมูลใน colum N >> บริการ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('N'.$row)->getValue();//แสดงข้อมูลใน colum O >> HN
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('O'.$row)->getValue();//แสดงข้อมูลใน colum P >> AN
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('P'.$row)->getValue();//แสดงข้อมูลใน colum Q >> วันที่เข้ารับบริการ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('Q'.$row)->getValue();//แสดงข้อมูลใน colum R >> วันที่บันทึก
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('R'.$row)->getValue();//แสดงข้อมูลใน colum S >> สถานะใช้งาน
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('S'.$row)->getValue();//แสดงข้อมูลใน colum T >> ช่องทางการขอ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('T'.$row)->getValue();//แสดงข้อมูลใน colum U >> วิธีการพิสูจน์ตัวตน
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('U'.$row)->getValue();//แสดงข้อมูลใน colum V >> ผู้จับของการเข้ารับบริการ
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('V'.$row)->getValue();//แสดงข้อมูลใน colum W >> วันที่แก้ไข-AuthenCode
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('W'.$row)->getValue();//แสดงข้อมูลใน colum X >> ชื่อผู้ที่แก้ใข-AuthenCode
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import . $worksheet->getCell('X'.$row)->getValue();//แสดงข้อมูลใน colum X >> หมายเหตุการยกเลิก
                                $tb_show_affther_import =$tb_show_affther_import . "</td><td>";
                                  $tb_show_affther_import =$tb_show_affther_import .   $vn_vv[$row] ;  
                                $tb_show_affther_import =$tb_show_affther_import . "</td>";
                              }
                              $tb_show_affther_import =$tb_show_affther_import . "</table>";  

                      ?>


                      <?php  
                                      // อ่านข้อมูลลงฐานข้อมูล


                                      $new_record = 0;
                                      $duplicate_record = 0;
                                      
                                      for ($row = $startrow; $row <= $lastRow; $row++) {                         
                                      

                                                $strSQL = "";
                                                  $strSQL .= "INSERT INTO pk_authen_data ";
                                                  $strSQL .= "(hosp_code,hosp_name,cid,pt_name,dob,phone,main_pttype,sub_pttype,service_in_code,claim_code,service_in_type,service_code,service_name,hn_code,an_code,date_serv,date_authen,sts,route_authen,method_authen,user_authen,date_modify_authen,user_modify_authen,comment_cancel,vn_visit_pttype) ";
                                                  $strSQL .= "VALUES ";
                                                  $strSQL .= "('".$worksheet->getCell('A'.$row)->getValue()."','". $worksheet->getCell('B'.$row)->getValue() ."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('C'.$row)->getValue()."','".$worksheet->getCell('D'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('E'.$row)->getValue()."','".$worksheet->getCell('F'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('G'.$row)->getValue()."','".$worksheet->getCell('H'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('I'.$row)->getValue()."','".$worksheet->getCell('J'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('K'.$row)->getValue()."','".$worksheet->getCell('L'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('M'.$row)->getValue()."','".$worksheet->getCell('N'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('O'.$row)->getValue()."','".$worksheet->getCell('P'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('Q'.$row)->getValue()."','".$worksheet->getCell('R'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('S'.$row)->getValue()."','".$worksheet->getCell('T'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('U'.$row)->getValue()."','".$worksheet->getCell('V'.$row)->getValue()."' ";
                                                  $strSQL .= ",'".$worksheet->getCell('W'.$row)->getValue()."','".$worksheet->getCell('X'.$row)->getValue()."' ";
                                                  $strSQL .= " ,'".$vn_vv[$row]."') ;"; 

                                                  //echo $strSQL ."<br>";        
                                                 
                                                  if ($conn->query($strSQL) === TRUE) {  //นำเข้าตาราง
                                                    $new_record = $new_record+1;
                                                  } else {
                                                    $duplicate_record = $duplicate_record+1;  
                                                      if($vn_vv[$row]==""){
                                                         $sql_update_authen_code = "update pk_authen_data set vn_visit_pttype = '' where claim_code = '".$worksheet->getCell('J'.$row)->getValue()."' ";
                                                          //echo  $sql_update_authen_code;
                                                      }else{
                                                        $sql_update_authen_code = "update pk_authen_data set vn_visit_pttype = '".$vn_vv[$row]."' where claim_code = '".$worksheet->getCell('J'.$row)->getValue()."' and (vn_visit_pttype ='' || vn_visit_pttype is null)";
                                                      }
                                                       
                                                       update_vn_pk_authen_claim( $sql_update_authen_code) ;  // เรียกใช้ Fn เพื่อ update ข้อมูล                                                     
                                                     
                                                  }
                                                 // echo $sql_update_authen_code  ."<br>"; 

                                          }                                       
                            
                                                 
                                          $conn->close();
                            
                          
                                          //แสดงผลตารางที่อ่านค่า
                                          echo  $tb_show_affther_import ; 

                                          

                      ?>
                                <div class="container" >  
                                  <?php   echo   "รายการนำเข้าใหม่ :" .$new_record ." รายการ <br>";  ?>
                                  <?php   echo   "นำเข้ารายการไม่ได้หรืออาจจะซ้ำซ้อน :" .$duplicate_record ." รายการ <br>";  ?>
                                </div>






                      </div>
                      <?php }else{ //กรณียังไม่เลือกไฟล์  ?>
                      <div class="container" >                    
                          ยังไม่ได้เลือกไฟล์เลย! กรุณาเลือกไฟล์ที่นำเข้าด้วยคะ!                    
                      </div>

                      <?php  }   ?>


</pre>
<script src="dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>


</body>
<br>
<?php  require_once "footer.php"; ?>
</html>


