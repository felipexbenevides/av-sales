<?php 
    include 'c:/web/www/global/oci.php';
    $oci = new oci();
    if(isset($_GET['NR_PED'])){
        $NR_PED = $_GET['NR_PED'];
        $query = "select t.codi_itped, 
                t008.desc_prod, 
                t008.codifab_prod, 
                t013.loca_qtdd,
                t.unit_itped, 
                t.qtdd_itped, 
                ROUND(t.total_itped,2 ) as total_itped
            from arqt211 t 
            left join arqt008 t008 on t008.codi_prod = t.codi_itped
            left join arqt013 t013 on t013.codi_qtdd = t.codi_itped
            where t.num_itped = '$NR_PED'";
            $i=0;
            $result=array();
            foreach ($oci->select($query) as $row) {

                // $result->rows[$i]['id']=$i;
                 $row[4]= number_format($row[4], 2, ',', '');
                 $row[6]= number_format($row[6], 2, ',', '');
                array_push($result,array("codi_itped"=>$row[0],"desc_prod"=>$row[1],"codifab_prod"=>$row[2], "loca_qtdd"=>$row[3], "unit_itped"=>$row[4],"qtdd_itped"=>$row[5],"total_itped"=>$row[6]));
                $i++;
            }          
    echo json_encode($result,512);

    }else{
        $query = "select SUBSTR(t.data_ped,0,5) as data_ped, 
            t.nr_ped, 
            t007.nome_cli as cgcpf_ped, 
            t.tt_ped, 
            t.obs_ped, 
            t.stat_ped 
        from arqt209 t
        left join arqt007 t007 on t007.cgcpf_cli = t.cgcpf_ped
        where t.data_ped between sysdate-3 and sysdate+1 
        and t.nr_ped < '99999' order by t.nr_ped desc";
        $i=0;
        foreach ($oci->select($query) as $row) {
            $result->rows[$i]['id']=$i;
            $row[3]= number_format($row[3], 2, ',', '');
            $result->rows[$i]['cell']=array($row[0],$row[1],$row[2], $row[3], $row[4],$row[5] );
            $i++;
        }                
    echo json_encode($result,512);

    }
    
    // $result = array("rows"->array());

    // $result->page = 2;
    // $result->total = 2;
    // $result->records = $i+1;
?>