<style>
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto;
  /* background-color: #2196F3; */
  /* padding: 10px; */
  grid-gap: 10px 10px;
}
.grid-item {
  /* background-color: rgba(255, 255, 255, 0.8); */
  /* border: 1px dashed rgba(0, 0, 0, 0.8); */
  /* padding: 20px; */
  /* font-size: 30px; */
  text-align: center;
  font-size: 0.8em;
  font-family: 'Courier New', Courier, monospace;
}
</style>

<script>


$(document).ready(()=>{
    $(document).keyup(function(event) {
        console.log(event);
        switch (event.which) {
            case 113://F2
                $( "#Pesquisar" ).click();
                return false;
                break;
        
            default:
                break;
        }
    });
});
    
    $(document).ready(()=>{
        // setGrid(2,'tabs-1');
        // createGridPedidos();
        // createGridPedido();
    });
    function createGridPedido(id) {
        options = {
            colNames:['Código', 'Descrição', 'Referência', 'Loca.', 'Preço', 'Qtd', 'Total'],
            colModel:[
                {name:'codi_itped',index:'codi_itped', width:140, sorttype:"date",align:"center"},
                {name:'desc_prod',index:'desc_prod', width:310, sorttype:"int", align:"center"},
                {name:'codifab_prod',index:'codifab_prod', width:160, align:"left"},
                {name:'loca_qtdd',index:'loca_qtdd', width:70, align:"right"},	
                {name:'unit_itped',index:'unit_itped', width:60, sorttype:"float"},		
                {name:'qtdd_itped',index:'qtdd_itped', width:20},		
                {name:'total_itped',index:'total_itped', width:80, sorttype:"float"}		
            ],
            caption:'Pedido Selecionado'
        };
        createGrid(options,'avgrid-'+id,'local','grid'+id);        
    }
    function createGridPedidos(id) {
        options = {
            colNames:['Date','Pedido', 'Cliente', 'Valor','Observação'],
            colModel:[
                {name:'data_ped',index:'data_ped', width:50, sorttype:"date",align:"center"},
                {name:'nr_ped',index:'nr_ped', width:50, sorttype:"int", align:"center"},
                {name:'cgcpf_ped',index:'cgcpf_ped', width:160, align:"left"},
                {name:'tt_ped',index:'tt_ped', width:60, align:"right",sorttype:"float", align:"right"},	
                {name:'obs_ped',index:'obs_ped', width:250}		
            ],
            caption:'Últimos pedidos',
            onSelectRow:(rowid,status,e)=>{
                data = $('#grid'+id).jqGrid("getLocalRow", rowid);
                $.get( "oci_ped.php?NR_PED="+data.nr_ped, ( data )=> {
                    jsonData = JSON.parse(data);
                    $('#grid'+(id+1)).clearGridData(true); 
                    $('#grid'+(id+1)).setGridParam({ data: jsonData, rowNum: jsonData.length }).trigger('reloadGrid');
                });

            }
        };
        createGrid(options,'avgrid-'+id,'oci_ped.php','grid'+id).then(result=>{
            $("#"+result).jqGrid('bindKeys', {
            "onEnter":function(rowid){
                alert("You enter a row with id:"+rowid);
                data = $('#'+result).jqGrid("getLocalRow", rowid);
            }
            });
            $('#'+result).jqGrid('gridResize');
        });
    }
    
</script>

