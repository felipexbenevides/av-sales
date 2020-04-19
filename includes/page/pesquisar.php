<style>
#list4{
    font-size: 0.8em;
    font-family: 'Courier New', Courier, monospace;
}
#list5{
    font-size: 0.8em;
    font-family: 'Courier New', Courier, monospace;
}    
.grid-container {
    display: grid;
    grid-template-columns: auto auto auto;
}
</style>

<script>
$(document).ready(()=>{
        jQuery("#list4").jqGrid({
            url:'oci_ped.php',
	        datatype: "json",
            height: 'auto',
            // pgbuttons:false,
            // pginput:false,
            width: 'auto',
            altRows:true,
            colNames:['Date','Pedido', 'Cliente', 'Valor','Observação'],
            colModel:[
                {name:'data_ped',index:'data_ped', width:50, sorttype:"date",align:"center"},
                {name:'nr_ped',index:'nr_ped', width:50, sorttype:"int", align:"center"},
                {name:'cgcpf_ped',index:'cgcpf_ped', width:160, align:"left"},
                {name:'tt_ped',index:'tt_ped', width:60, align:"right",sorttype:"float", align:"right"},	
                {name:'obs_ped',index:'obs_ped', width:250, sortable:false}		
            ],
            loadonce: true,
            rowNum:20,
   	        rowList:[10,20,30],
            pager: '#pager4',
            // multiselect: true,
            caption: "",
            onSelectRow:(rowid,status,e)=>{
                selectPed(rowid,status,e);
            }
        });

        jQuery("#list4").jqGrid('navGrid','#pager4',{ add: false, del: false, edit: false, search: false,refresh:false,view:false });

        // Bind the navigation and set the onEnter event
        jQuery("#list4").jqGrid('bindKeys', {
            "onEnter":function(rowid){alert("You enter a row with id:"+rowid);
                data = $('#list4').jqGrid("getLocalRow", rowid);
            }
        });
        jQuery('#list4').jqGrid('gridResize');

        function selectPed(rowid,status,e) {
            console.log('select '+ rowid);
            data = $('#list4').jqGrid("getLocalRow", rowid);
            $.get( "oci_ped.php?NR_PED="+data.nr_ped, ( data )=> {
                //  myjsongrid = eval("("+data+")");
    
                // data = JSON.parse(data);
                //  mygrid = jQuery("#list5")[0];
                //     mygrid.addJSONData(data);
                jsonData = JSON.parse(data);
                // Clear the grid if you only want the new data
                $('#list5').clearGridData(true); 
                // Set the data the tell the grid to refresh
                $('#list5').setGridParam({ data: jsonData, rowNum: jsonData.length }).trigger('reloadGrid');
            });
        }
        jQuery("#list5").jqGrid({
            datatype: "local", 
            height: 'auto',
            // pgbuttons:false,
            // pginput:false,
            width: 'auto',
            altRows:true,
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
            loadonce: true,
            rowNum:20,
            rowList:[10,20,30],
            // multiselect: true,
            caption: "",
            onSelectRow:(rowid)=>{
                selectPed(rowid);
            }
            });
            jQuery("#list5").jqGrid('navGrid','#pager5',{ add: false, del: false, edit: false, search: false,refresh:false,view:false });            
            jQuery('#list5').jqGrid('gridResize');
    });
</script>

<div class="grid-container">
		<div class="grid-item">
			<table id="list4"></table>
			<div id="pager4"></div>
		</div>
		<div class="grid-item">
			<table id="list5" ></table>
			<div id="pager5"></div>
		</div>
	</div>