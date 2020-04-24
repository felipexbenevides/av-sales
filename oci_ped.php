<?php 
    error_reporting(1);
    include 'c:/web/www/global/oci.php';
    $oci = new oci();

    if(isset($_GET['OP'])){
       $OP = $_GET['OP'];
    }else{
       $OP = 'PEDIDOS';
    }
    if(isset($_GET['DATA1'])){
        $data1 = $_GET['DATA1'];
        $data1 = "'$data1'";
     }else{
        $data1 = 'sysdate-10';
     }
     if(isset($_GET['DATA2'])){
        $data2 = $_GET['DATA2'];
        $data2 = "'$data2'";
     }else{
        $data2 = 'sysdate+1';
     }    
     if(isset($_GET['CLIENTE'])){
        $cliente = $_GET['CLIENTE'];
        $cliente = " and t.cgcpf_ped = '$cliente'";
     }else{
        $cliente = '';
     }

    switch ($OP) {
        case 'AUTOCOMPLETECLIENTES':
            autocompleteclientes($oci);
            return true;
            break;
        case 'DADOSPEDIDO':
            dadospedido($oci,$_GET['NR_PED']);
            return true;
            break;        
        case 'PEDIDOS':
            pedidos($oci,$_GET['STATUS']);
            return true;
            break;        
        default:
            # code...
            break;
    }



    if(isset($_GET['NR_PED'])){
  

    // }else if($OP == 'PEDIDOS'){
    }else if(false){
        $query = "select SUBSTR(t.data_ped,0,5) as data_ped, 
            t.nr_ped, 
            t007.nome_cli as cgcpf_ped, 
            t.tt_ped, 
            t.obs_ped, 
            t.stat_ped 
        from arqt209 t
        left join arqt007 t007 on t007.cgcpf_cli = t.cgcpf_ped
        where t.data_ped between sysdate-10 and sysdate+1 
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

    function dadospedido($oci, $NR_PED){
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
            $result=array('prod'=>array(),'ped'=>array());
            foreach ($oci->select($query) as $row) {
                // $result->rows[$i]['id']=$i;
                 $row[4]= number_format($row[4], 2, ',', '');
                 $row[6]= number_format($row[6], 2, ',', '');
                array_push($result['prod'],array("codi_itped"=>$row[0],"desc_prod"=>$row[1],"codifab_prod"=>$row[2], "loca_qtdd"=>$row[3], "unit_itped"=>$row[4],"qtdd_itped"=>$row[5],"total_itped"=>$row[6]));
                $i++;
            }
        $query = "select DECODE(t.stat_ped, 'A', 'ABERTO', 'B','NO CAIXA', 'C','CANCELADO','E','FATURADO', t.stat_ped) as stat_ped,
        t007.nome_cli,
        DECODE(t204.port_notafrag, 1, 'A VISTA',
          2, 'CARTEIRA',                                   
          5, 'BOLETO',
          7, 'DEVOLUCAO',
          '-')  port_notafrag
        from arqt209 t 
        left join arqt007 t007 on t007.cgcpf_cli = t.cgcpf_ped
        left join arqt204 t204 on t204.nrped_notafrag = t.nr_ped
        where t.nr_ped = '$NR_PED'";
        foreach ($oci->select($query) as $row) {
            array_push($result['ped'],$row);
        }
        echo json_encode($result,512);        
    }
    /**
     * autocompleteclientes
     *
     * @param Oracle Conn $oci
     * @return html plain text
     */
    function autocompleteclientes($oci){
        $query = "select t.*, t.cgcpf_cli, t.nome_cli ||'('|| t.fant_cli || ')' as nome_Cli from arqt007 t where t.bloq_cli <> 4 and t.cgcpf_cli in (select arqt209.cgcpf_ped from arqt209) order by t.nome_cli asc";
        $result = '';
        foreach ($oci->select($query) as $row) {
            $result .= "<option value=".'"'.$row['CGCPF_CLI'].'">'.$row['NOME_CLI']."</option>";
        }                
        echo $result;
        
    }

    function pedidos($oci, $status){
        global $data1, $data2, $cliente;
        switch ($status) {
            case 'ALL':
                $strstatus = '';
                break;            
            default:
                $strstatus = "and t.stat_ped = '$status'";
                break;
        }

        $query = "select SUBSTR(t.data_ped,0,5) as data_ped, 
            t.nr_ped, 
            t007.nome_cli as cgcpf_ped, 
            t.tt_ped, 
            t.obs_ped, 
            t.stat_ped 
        from arqt209 t
        left join arqt007 t007 on t007.cgcpf_cli = t.cgcpf_ped
        where t.data_ped between $data1 and $data2 ".$strstatus. 
        " and t.nr_ped < '99999' ".$cliente." order by t.nr_ped desc";
        // print_r($query);
        //$i=0;
        $result = array();
        foreach ($oci->select($query) as $row) {
            //$result->rows[$i]['id']=$i;
            $row[3]= number_format($row[3], 2, ',', '');
            array_push($result, array("data_ped"=>$row[0],"nr_ped"=>$row[1],"cgcpf_ped"=>$row[2],"tt_ped"=> $row[3],"obs_ped"=> $row[4],"stat_ped"=>$row[5]));
            //$i++;
        }                
        echo json_encode($result,512);
    }
?>