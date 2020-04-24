  <style>
  .custom-combobox {
    position: relative;
    display: inline-block;
  }
  .custom-combobox-toggle {
    position: absolute;
    top: 5px;
    bottom: 5px;
    margin-left: -1px;
    padding: 0;
  }
  .custom-combobox-input {
    /* margin: 0; */
    /* padding: 5px 10px; */
  }
  </style>
<script>

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
        formpedido = `<form>
          <label for="cliente">Cliente: </label>
          <input type="text" id="cliente-`+id+`" name="cliente" size="40">
          <label for="cliente">Portador: </label>
          <input type="text" id="portador-`+id+`" name="portador"><br>
          <label for="status">Status:&nbsp; </label>
          <input type="text" id="status-`+id+`" name="status"><br>
        </form>`;
        $('#avspan-'+(id)).prepend(formpedido);               
        $()
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
                data = $('#grid'+id).jqGrid("getRowData", rowid);
                console.log(data);
                $.get( "oci_ped.php?OP=DADOSPEDIDO&NR_PED="+data.nr_ped, ( data )=> {
                    jsonData = JSON.parse(data);
                    $('#grid'+(id+1)).clearGridData(true); 
                    $('#grid'+(id+1)).setGridParam({ data: jsonData.prod, rowNum: jsonData.length }).trigger('reloadGrid');
                    //console.log(jsonData.ped[0]);
                    
                    $('#cliente-'+(id+1)).val(jsonData.ped[0]['NOME_CLI']);
                    $('#portador-'+(id+1)).val(jsonData.ped[0]['PORT_NOTAFRAG']);
                    $('#status-'+(id+1)).val(jsonData.ped[0]['STAT_PED']);
                });
            },
            // datatype: 'json',
            height: '400px',
            width: 'auto',
            altRows: true,
            loadonce: true,
            scroll:true
         // rowNum: 10,

        };
        createGrid(options,'avgrid-'+id,'local','grid'+id).then(result=>{
          console.log('#'+result);
            $("#"+result).jqGrid('bindKeys', {
            "onEnter":function(rowid){
                alert("You enter a row with id:"+rowid);
                data = $('#'+result).jqGrid("getLocalRow", rowid);
            }
            });
            $('#'+result).jqGrid('gridResize');
        });
        formpedidos = `<form>
            <div class="ui-widget">
              <label>Cliente</label>
              <select id="combobox-`+id+`">
                  <option value=""></option>
              </select>
            </div>
            <input type="date" id="periodo1-`+id+`" name="periodo1">
             à 
            <input type="date" id="periodo2-`+id+`" name="periodo2">
             Status:
            <select id="status-`+id+`" name="status">
                <option value="ALL">Todos</option>
                <option value="A" selected>Aberto</option>
                <option value="B">No caixa</option>
                <option value="E">Faturado</option>
                <option value="C">Cancelado</option>
            </select>
        </form>`;
        $('#avspan-'+id).prepend(formpedidos);
        /**
         * ON CHANGE STATUS SELECT FORM
         */
        // $('#status-'+id).change(function (e) { 
        //   e.preventDefault();
        //   status = $('#status-'+id).val();
        //   console.log(status);
        //   $.get( "oci_ped.php?OP=PEDIDOS&STATUS="+status, ( data )=> {
        //       //console.log(data);
        //         jsonData = JSON.parse(data);
        //         console.log(jsonData);
        //         $('#grid'+id).clearGridData(true); 
        //         $('#grid'+id).setGridParam({ data: jsonData, rowNum: jsonData.length }).trigger('reloadGrid');
        //         //console.log(jsonData.ped[0]);
        //     }); 
        // });
        /**
         * ON CHANGE DATE SELECT FORM
         */
        $(document).on("change", '#periodo1-'+id+', #periodo2-'+id+', #status-'+id+', input', function() {
          console.log($('#combobox-'+id).children("option:selected").val());
          
          status = $('#status-'+id).val();
          if ($('#combobox-'+id).children("option:selected").val()) {
            cliente = $('#combobox-'+id).children("option:selected").val();
            clientestr = '&CLIENTE='+cliente;
          } else {
            clientestr = ''; 
          }
          if ($('#periodo1-'+id).val()) {
            data1 = $('#periodo1-'+id).val();
            data1 = data1.split('-');
            data1 = data1[2]+'/'+data1[1]+'/'+data1[0];
            data1str = "&DATA1="+data1;
          }else{
            data1str='';
          }
          if ($('#periodo2-'+id).val()) {
            data2 = $('#periodo2-'+id).val();
            data2 = data2.split('-');
            data2 = data2[2]+'/'+data2[1]+'/'+data2[0];
            data2str = "&DATA2="+data2;
          }else{
            data2str='';
          }

          $.get( "oci_ped.php?OP=PEDIDOS&STATUS="+status+data1str+data2str+clientestr, ( data )=> {
              //console.log(data);
                jsonData = JSON.parse(data);
                console.log(jsonData);
                $('#grid'+id).clearGridData(true); 
                $('#grid'+id).setGridParam({ data: jsonData, rowNum: jsonData.length }).trigger('reloadGrid');
                // console.log(jsonData.ped[0]);
            }); 
        });
        // $('#periodo1-'+id+', #periodo2-'+id+', #status-'+id).change(function (e) { 
        //   e.preventDefault();
        //   console.log($('#combobox-'+id).children("option:selected").val());
          
        //   status = $('#status-'+id).val();
        //   if ($('#combobox-'+id).children("option:selected").val()) {
        //     cliente = $('#combobox-'+id).children("option:selected").val();
        //     clientestr = '&CLIENTE='+cliente;
        //   } else {
        //     clientestr = ''; 
        //   }
        //   if ($('#periodo1-'+id).val()) {
        //     data1 = $('#periodo1-'+id).val();
        //     data1 = data1.split('-');
        //     data1 = data1[2]+'/'+data1[1]+'/'+data1[0];
        //     data1str = "&DATA1="+data1;
        //   }else{
        //     data1str='';
        //   }
        //   if ($('#periodo2-'+id).val()) {
        //     data2 = $('#periodo2-'+id).val();
        //     data2 = data2.split('-');
        //     data2 = data2[2]+'/'+data2[1]+'/'+data2[0];
        //     data2str = "&DATA2="+data2;
        //   }else{
        //     data2str='';
        //   }

        //   $.get( "oci_ped.php?OP=PEDIDOS&STATUS="+status+data1str+data2str+clientestr, ( data )=> {
        //       //console.log(data);
        //         jsonData = JSON.parse(data);
        //         console.log(jsonData);
        //         $('#grid'+id).clearGridData(true); 
        //         $('#grid'+id).setGridParam({ data: jsonData, rowNum: jsonData.length }).trigger('reloadGrid');
        //         // console.log(jsonData.ped[0]);
        //     }); 
        // });        

        $.get("oci_ped?OP=AUTOCOMPLETECLIENTES",(data)=>{
            $('#combobox-'+id).append(data);
        }).then(result=>{
          $('#combobox-'+id).combobox();

        }).catch(reason=>{
            console.warn('Failed: ', reason);
        });;
    
        $.get( "oci_ped.php?OP=PEDIDOS&STATUS=A", ( data )=> {
              //console.log(data);
                jsonData = JSON.parse(data);
                console.log(jsonData);
                $('#grid'+id).clearGridData(true); 
                $('#grid'+id).setGridParam({ data: jsonData, rowNum: jsonData.length }).trigger('reloadGrid');
            });    
    }
</script>

