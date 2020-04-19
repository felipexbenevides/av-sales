function setGrid (num,id) { 
    return new Promise ((resolve, reject)=>{
        switch (num) {
            case 2:
                console.log('grid');
                $('#'+id).html('<div class="grid-container"><div id="avgrid-'+gridCounter+'" data-grid="'+gridCounter+'" class="grid-item">a</div><div id="avgrid-'+(gridCounter+1)+'" data-grid="'+(gridCounter+1)+'" class="grid-item">b</div></div>');
                gridCounter++;
                gridCounter++;
                resolve(id+' '+num);
                break;
            case 3:
                console.log('grid');
                $('#'+id).html('<div class="grid-container"><div id="avgrid-1" data-grid="1" class="grid-item"></div><div id="avgrid-2" data-grid="2" class="grid-item"></div><div id="avgrid-3" data-grid="3" class="grid-item"></div></div>');
                gridCounter++;
                gridCounter++;
                gridCounter++;
                resolve(id+' '+num);
                break;
                    
            default:
                $('#'+id).html('<div id="avgrid-1"  data-grid="1" class="grid-item">a</div>');
                resolve(id+' '+num);                    
                break;
        }
    });
}
function createGrid (options,selector='avgrid-1',source='oci_ped.php',id='grid1') { 
    return new Promise ((resolve, reject)=>{
        $('#'+selector).html('<table id="'+id+'"></table><div id="pager'+id+'"></div>');
        gridOptions = {
            url:source,
            datatype: 'json',
            height: 'auto',
            width: 'auto',
            altRows: true,
            loadonce: true,
            rowNum: 20,
            rowList: [10,20,30]
        };
        if(source == "local"){
            gridOptions.datatype = 'local';
            delete gridOptions.url;
        }
        $('#'+id).jqGrid({...gridOptions,...options});
        resolve(id);
    });
}
