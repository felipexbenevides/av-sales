<link rel="stylesheet" type="text/css" media="screen" href="css/av.css" />
<script src="js/app.js" type="text/javascript"></script>

<!-- <script src="http://192.168.1.7/av-sales/external/"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="http://192.168.1.7/av-sales/external/"> -->

<!-- JQUERY -->
<!-- <script src="http://192.168.1.7/av-sales/external/jquery/jquery-3.5.0.min.js"></script> -->
<!-- JQGRID -->


<link rel="stylesheet" type="text/css" media="screen" href="css/ui.jqgrid.css" />
 
<script src="js/jquery-3.5.0.min.js" type="text/javascript"></script>
<script src="js/i18n/grid.locale-en.js" type="text/javascript"></script>
<script src="js/jquery.jqGrid.min.js" type="text/javascript"></script>


<!-- JQUERY UI -->
<link rel="stylesheet" type="text/css" href="external/jquery-ui/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="external/jquery-ui/jquery-ui.structure.css">
<link rel="stylesheet" type="text/css" href="external/jquery-ui/jquery-ui.theme.css">
<script src="external/jquery-ui/jquery-ui.js"></script>

<script>
  $( ()=> {
    var tabTitle = $( "#tab_title" ),
      tabContent = $( "#tab_content" ),
      tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
      tabCounter = 1;
      gridCounter = 1;
 
    var tabs = $( "#tabs" ).tabs();
 
    // Modal dialog init: custom buttons and a "close" callback resetting the form inside
    var dialog = $( "#dialog" ).dialog({
      autoOpen: false,
      modal: true,
      buttons: {
        Add: function() {
          addTab();
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
      }
    });
 
    // AddTab form: calls addTab function on submit and closes the dialog
    var form = dialog.find( "form" ).on( "submit", function( event ) {
      addTab();
      dialog.dialog( "close" );
      event.preventDefault();
    });
 
    // Actual addTab function: adds new tab using the input from the form above
    function addTab() {
      var label = tabTitle.val() || "Tab " + tabCounter,
        id = "tabs-" + tabCounter,
        li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
        tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
 
      tabs.find( ".ui-tabs-nav" ).append( li );
      tabs.append( "<div id='" + id + "'><p>" + tabContentHtml + "</p></div>" );
      tabs.tabs( "refresh" );
      tabCounter++;
    }




    function addTabPesquisa() {
      var label = 'Pesquisar',
        id = "tabs-" + tabCounter,
        li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
        tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
 
      tabs.find( ".ui-tabs-nav" ).append( li );
      tabs.append( "<div id='" + id + "'></div>" );
      tabs.tabs( "refresh" );
      
      setGrid(2,id);
      createGridPedidos(gridCounter-2);
      createGridPedido(gridCounter-1);
      $('#ui-id-'+tabCounter).click();
      tabCounter++;
    }    




    function tab(title,url=null) {
      var label = title || tabTitle.val() || "Tab " + tabCounter,
        id = "tabs-" + tabCounter,
        li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
        tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
        
      tabs.find( ".ui-tabs-nav" ).append( li );
      tabs.append( "<div id='" + id + "'><p>" + tabContentHtml + "</p></div>" );
      tabs.tabs( "refresh" );
      tabCounter++;
      if(url){
        $.get( "includes/page/"+url+".php", function( data ) {
            $('#'+id).html(data);
        });
      }  
    }    
 
    // AddTab button: just opens the dialog
    $( "#Pesquisar" ).click((e)=>{
        addTabPesquisa();
    });
    //   .on( "click", function() {
    //     // dialog.dialog( "open" );
    //     addTab();
    //   });
 
    // Close icon: removing the tab on click
    tabs.on( "click", "span.ui-icon-close", function() {
      var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
      $( "#" + panelId ).remove();
      tabs.tabs( "refresh" );
    });
 
    tabs.on( "keyup", function( event ) {
      if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
        var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        tabs.tabs( "refresh" );
      }
    });
  } );

</script>