<?php
include("conn/conn.php");
function get_date_sql($date_th_format){
		
    $date_insert  =  substr($date_th_format,6,4)-543;
    $date_insert  =  $date_insert."/".substr($date_th_format,3,2);
    $date_insert  =  $date_insert."/".(substr($date_th_format,0,2));
    return $date_insert;
}

function get_date_show($date_f){		
    $date_show  =  substr($date_f,8,2);
    $date_show  =  $date_show."-".substr($date_f,5,2);
    $date_show  =  $date_show."-".(substr($date_f,0,4)+543);
    return $date_show;
}

function chk_file_tyep($filetype){
            $result_chk_file =  0;
            if($filetype=='xls'){
                    $result_chk_file = 1 ;

            }elseif($filetype=='xlsx' ){
                $result_chk_file = 1 ;

            }else{

                $result_chk_file =  0;
            }
                return $result_chk_file ;
}




function get_vn_his($vn6 , $visit_id,$claim_code){	
    
    include("conn/conn.php");

    $sql = "SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as vvst , GROUP_CONCAT('''',ovst.vn ,'''') as vn , visit_pttype.claim_code ,  count(concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn))) as CC  
                from ovst 
                LEFT JOIN visit_pttype on ovst.vn = visit_pttype.vn 
                where ovst.vn like'$vn6%' and  concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) = '$visit_id'
                  ";


   // echo $sql . "<br>";

    $vn = "";
    $claim_code_chk = "";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        //$claim_code_chk = $rows['claim_code'];
        while($rows = $result->fetch_assoc()) {
                
                $vn = $rows['vn'];
                $sql_update_claim_code = "update visit_pttype set claim_code = '".$claim_code."' where vn in(".$rows['vn'].") and( claim_code ='' || claim_code is null)";
                update_visitpttype($sql_update_claim_code );
        }

    } else {

         $vn =  "0 results";
      }
          
      $conn->close();
     return  $vn;

}


function update_visitpttype($sql_update_claim_code){	
    include("conn/conn.php");
      
         $conn->query($sql_update_claim_code);        

      $conn->close();

   //   echo $sql_update_claim_code ."<br>";

}




function update_vn_pk_authen_claim($sql_update_vn_authen_code){

   
    include("conn/conn.php");   
      $conn->query($sql_update_vn_authen_code);  
    $conn->close();
}




function get_all_visit($day){

    include("conn/conn.php");
    $sql = "SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                                    visit_pttype.claim_code as his_claim_code, pk_authen_data.claim_code as web_claim_code
                                from visit_pttype
                                INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                                LEFT JOIN pk_authen_data on visit_pttype.claim_code = pk_authen_data.claim_code
                                where ovst.vstdate = '$day' 
                                GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn))";

       $result = $conn->query($sql);
       $num_rows = $result->num_rows;
        $conn->close();

        return $num_rows;
}



function get_visit_authen_pass($day){
    include("conn/conn.php");
    $sql = "SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                                    visit_pttype.claim_code as his_claim_code, pk_authen_data.claim_code as web_claim_code
                                from visit_pttype
                                INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                                LEFT JOIN pk_authen_data on visit_pttype.claim_code = pk_authen_data.claim_code
                                where ovst.vstdate = '$day' 
                                GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) , pk_authen_data.claim_code 
                                HAVING his_claim_code is not null   ";


       $result = $conn->query($sql);
       $num_rows = $result->num_rows;
        $conn->close();

    return $num_rows;
}




function get_visit_authen_wait($day){
    include("conn/conn.php");
    $sql = "SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                                    visit_pttype.claim_code as his_claim_code, pk_authen_data.claim_code as web_claim_code
                                from visit_pttype
                                INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                                LEFT JOIN pk_authen_data on visit_pttype.claim_code = pk_authen_data.claim_code
                                where ovst.vstdate = '$day' 
                                GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn))
                                HAVING his_claim_code is  null   ";

       // echo $sql;

       $result = $conn->query($sql);
       $num_rows = $result->num_rows;
        $conn->close();

        return $num_rows;
}



function get_non_visit($day){

    include("conn/conn.php");
    $sql = "SELECT * from pk_authen_data where  pk_authen_data.vn_visit_pttype = '' and concat( SUBSTR(date_serv,7,4)-543,'/', SUBSTR(date_serv,4,2),'/' , SUBSTR(date_serv,1,2) )  = '".$day."' ";

      //  echo $sql;

        $result = $conn->query($sql);
        $num_rows = $result->num_rows;
        $conn->close();

        return $num_rows;
}



function get_claim_code_Error($day){

    include("conn/conn.php");
    
    $sql  = "SELECT concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn)) as id_visit,
                concat(patient.fname,' ' ,patient.lname) as ptname , patient.hn , ovst.vstdate , 
                        visit_pttype.claim_code as his_claim_code, pk_authen_data_chk.claim_code as web_claim_code 
                , method_authen,vn_visit_pttype , cc
                from visit_pttype
                INNER JOIN ovst on visit_pttype.vn = ovst.vn 
                INNER JOIN (SELECT vn_visit_pttype , service_code , claim_code ,method_authen ,count(vn_visit_pttype) as cc
                            from pk_authen_data GROUP BY vn_visit_pttype , service_code , claim_code ,method_authen 
                            HAVING count(vn_visit_pttype) =1 ) pk_authen_data_chk on visit_pttype.vn = pk_authen_data_chk.vn_visit_pttype
                LEFT JOIN patient on ovst.hn = patient.hn 
                where ovst.vstdate = '".$day."' and pk_authen_data_chk.cc > 1 
                GROUP BY concat(substr(ovst.vn,1,6),(SELECT cid from patient where hn = ovst.hn))  ";

            $result = $conn->query($sql);
            $num_rows = $result->num_rows;
            $conn->close();
    
            return $num_rows;

}




?>