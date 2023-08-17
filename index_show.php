<?php 
  session_start();
  error_reporting (E_ALL ^ E_NOTICE);
//header("Location: dist/");
//die();
include("libs/function.php"); 
require_once "header.php";
$st = $_GET['st'];

// $_SESSION['date_visit'] = $_GET['date_visit'];
if($st=="P"){
        $sql_all ="SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                        concat(patient.fname,' ' ,patient.lname) as ptname , patient.hn , ovst.vstdate , group_concat(ovst.vsttime) as ovsttime , 
                                visit_pttype.claim_code as his_claim_code, pk_authen_data.claim_code as web_claim_code , method_authen,vn_visit_pttype
                                ,visit_pttype.pttype , patient.cid
                        from visit_pttype
                        INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                        LEFT JOIN pk_authen_data on visit_pttype.claim_code = pk_authen_data.claim_code
                        LEFT JOIN patient on ovst.hn = patient.hn
                        where ovst.vstdate = '".$_SESSION['date_visit']."' 
                        GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) , pk_authen_data.claim_code 
                        HAVING his_claim_code is not null     "    ;

}elseif($st=="W"){
    $sql_all ="SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                concat(patient.fname,' ' ,patient.lname) as ptname , patient.hn , ovst.vstdate , group_concat(ovst.vsttime) as ovsttime , 
                        visit_pttype.claim_code as his_claim_code, pk_authen_data.claim_code as web_claim_code , method_authen,vn_visit_pttype ,
                        visit_pttype.pttype, patient.cid
                from visit_pttype
                INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                LEFT JOIN pk_authen_data on visit_pttype.claim_code = pk_authen_data.claim_code
                LEFT JOIN patient on ovst.hn = patient.hn
                where ovst.vstdate = '".$_SESSION['date_visit']."' 
                GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn))   
                 HAVING his_claim_code is null";

}elseif($st=="NV"){
    $sql_all =  "SELECT pt_name as ptname , hn_code as hn ,  concat( SUBSTR(date_serv,7,4)-543,'/', SUBSTR(date_serv,4,2),'/' , SUBSTR(date_serv,1,2) ) as vstdate , '' as ovsttime ,
                        pk_authen_data.claim_code as his_claim_code , method_authen as method_authen,visit_pttype.pttype , patient.cid
                         from pk_authen_data where  pk_authen_data.vn_visit_pttype = '' and 
                        concat( SUBSTR(date_serv,7,4)-543,'/', SUBSTR(date_serv,4,2),'/' , SUBSTR(date_serv,1,2) )  = '".$_SESSION['date_visit']."' ";
               // echo "<br><br><br><br>".$sql_all;
}elseif($st=="ERR"){
    
    $sql_all ="SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                        concat(patient.fname,' ' ,patient.lname) as ptname , patient.hn , ovst.vstdate , group_concat(ovst.vsttime) as ovsttime , 
                                visit_pttype.claim_code as his_claim_code, pk_authen_data_chk.claim_code as web_claim_code 
                        , method_authen,vn_visit_pttype , cc ,visit_pttype.pttype, patient.cid
                        from visit_pttype
                        INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                        INNER JOIN (SELECT vn_visit_pttype , service_code , claim_code ,method_authen ,count(vn_visit_pttype) as cc
                                from pk_authen_data GROUP BY vn_visit_pttype , service_code , claim_code ,method_authen 
                                HAVING count(vn_visit_pttype) =1 ) pk_authen_data_chk on visit_pttype.vn = pk_authen_data_chk.vn_visit_pttype
                        LEFT JOIN patient on ovst.hn = patient.hn 
                        where ovst.vstdate = '".$_SESSION['date_visit']."'  and pk_authen_data_chk.cc > 1 
                        GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn))   ";

              //  echo "<br><br><br><br><br>". $sql_all;

}else{
            $sql_all = "SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
            concat(patient.fname,' ' ,patient.lname) as ptname , patient.hn , ovst.vstdate , group_concat(ovst.vsttime) as ovsttime , 
                    visit_pttype.claim_code as his_claim_code, pk_authen_data.claim_code as web_claim_code , method_authen,vn_visit_pttype ,
                     visit_pttype.pttype , patient.cid
            from visit_pttype
            INNER JOIN ovst on visit_pttype.vn = ovst.vn 
            LEFT JOIN pk_authen_data on visit_pttype.claim_code = pk_authen_data.claim_code
            LEFT JOIN patient on ovst.hn = patient.hn
            where ovst.vstdate = '".$_SESSION['date_visit']."' 
            GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) ";

}




   // echo $sql_all;


$result = $conn->query($sql_all);   
$td_head = "";
$item = 1;
while($rows = $result->fetch_assoc()) {
    $td_head = $td_head."<tr><td> ".$item. "</td>";
    $td_head = $td_head."<td> ".$rows['hn']. "</td>";
    $td_head = $td_head."<td> ".$rows['ptname']. "</td>";
    $td_head = $td_head."<td> ".get_date_show($rows['vstdate']). "</td>";
    $td_head = $td_head."<td> ".$rows['ovsttime']. "</td>";
    $td_head = $td_head."<td> ".$rows['his_claim_code']. "</td>";
    $td_head = $td_head."<td> ".$rows['method_authen']. "</td>";
    $td_head = $td_head."<td> ".$rows['cid']. "</td>";
    $td_head = $td_head."<td> ".$rows['pttype']. "</td></tr>";
    $item = $item +1;
}


?>


 

<pre>
  
        <div class="container">
        <a href="index.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">กลับหน้าหลัก</a>
             <table> 
                    <tr>
                        <th>ลำดับ</th>
                        <th>HN</th>
                        <th>ชื่อ-สกุล</th>
                        <th>วันที่รับบริการ</th>
                        <th>เวลา</th>
                        <th>ClaimCode</th>    
                        <th>วิธีการพิสูจน์ตัวตน</th> 
                        <th>เลขบัตร</th> 
                        <th>สิทธิการรักษา</th> 
                    </tr>

                    <?php echo $td_head; ?>
            </table>
        </div>

</pre>





    <script src="dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
  <br>
  <?php  require_once "footer.php"; ?>
</html>