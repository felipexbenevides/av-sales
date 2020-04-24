<script>
$(document).ready(()=>{

  //FUNCOES DO TECLADO
    $(document).keyup((event)=>{
        // console.log(event);
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
  $( ()=> {
    var tabTitle = $( "#tab_title" ),
      tabContent = $( "#tab_content" ),
      tabTemplate = "<li><a href='#{href}'>#{label}</a> <span class='ui-icon ui-icon-close' role='presentation'>Remove Tab</span></li>",
      tabCounter = 1;
      gridCounter = 1;
    
    //INIT TABS
    var tabs = $( "#tabs" ).tabs();

    //CLOSE TABS
    tabs.on( "click", "span.ui-icon-close", function() {
      var panelId = $( this ).closest( "li" ).remove().attr( "aria-controls" );
      $( "#" + panelId ).remove();
      tabs.tabs( "refresh" );
    });
    //KEYUP BACKSPACE
    $(document).keyup((event)=>{
      switch (event.which) {
        case $.ui.keyCode.BACKSPACE:
          if (!(event.altKey)) return false;
          var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
          $( "#" + panelId ).remove();
          tabs.tabs( "refresh" );
        return false;
          break;
      
        default:
          break;
      }

    });
    tabs.on( "keyup", function( event ) {
      if ( event.altKey && event.keyCode === $.ui.keyCode.BACKSPACE ) {
        var panelId = tabs.find( ".ui-tabs-active" ).remove().attr( "aria-controls" );
        $( "#" + panelId ).remove();
        tabs.tabs( "refresh" );
      }
    });    
 
    // // Modal dialog init: custom buttons and a "close" callback resetting the form inside
    // var dialog = $( "#dialog" ).dialog({
    //   autoOpen: false,
    //   modal: true,
    //   buttons: {
    //     Add: function() {
    //       addTab();
    //       $( this ).dialog( "close" );
    //     },
    //     Cancel: function() {
    //       $( this ).dialog( "close" );
    //     }
    //   },
    //   close: function() {
    //     form[ 0 ].reset();
    //   }
    // });
 
    // // AddTab form: calls addTab function on submit and closes the dialog
    // var form = dialog.find( "form" ).on( "submit", function( event ) {
    //   addTab();
    //   dialog.dialog( "close" );
    //   event.preventDefault();
    // });
 
    // // Actual addTab function: adds new tab using the input from the form above
    // function addTab() {
    //   var label = tabTitle.val() || "Tab " + tabCounter,
    //     id = "tabs-" + tabCounter,
    //     li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
    //     tabContentHtml = tabContent.val() || "Tab " + tabCounter + " content.";
 
    //   tabs.find( ".ui-tabs-nav" ).append( li );
    //   tabs.append( "<div id='" + id + "'><p>" + tabContentHtml + "</p></div>" );
    //   tabs.tabs( "refresh" );
    //   tabCounter++;
    // }




    function addTabPesquisa() {
      var label = 'Pesquisar',
        id = "tabs-" + tabCounter,
        li = $( tabTemplate.replace( /#\{href\}/g, "#" + id ).replace( /#\{label\}/g, label ) ),
        tabContentHtml = tabContent.val() || "Tab " + '' + " content.";
 
      tabs.find( ".ui-tabs-nav" ).append( li );
      tabs.append( "<div id='" + id + "'></div>" );
      tabs.tabs( "refresh" );
      
      
      setGrid(2,id);
      createGridPedidos(gridCounter-2);
      createGridPedido(gridCounter-1);
      tabs = $( "#tabs" ).tabs();
      
      $('#'+($("li:last a")[0].id)).click();
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
      // tabCounter++;
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
    

/**
 * 
 * 
 * 
 * COMBOBOX
 * 
 * 
 * 
 */    
$( function() {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            classes: {
              "ui-tooltip": "ui-state-highlight"
            }
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .on( "mousedown", function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .on( "click", function() {
            input.trigger( "focus" );
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
 
    $( "#combobox-1" ).combobox();
    
    $( "#toggle" ).on( "click", function() {
      $( "#combobox-1" ).toggle();
    });
  } );        
    
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * *  
    *                                                      *
    *                                                      *
    * TESTE                                                *
    */                                                   //*

    // addTabPesquisa();

    /*                                                     *
    *                                                      *
    * * * * * * * * * * * * * * * * * * * * * * * * * * * */
    
 
  } );
</script>
