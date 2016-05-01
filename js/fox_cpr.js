(function(foxcpr) 
{
    foxcpr(window.jQuery, window, document);
}

(function($, window, document) 
{

    setTimeout(function(){
        $('.messages').remove();
    }, 15000);

    $(function() {
        $('div.actions_menu').width(Math.floor($('#menu_holder').width()/147)*147+'px');
    });


    $( window ).resize(function() {
        $('div.actions_menu').width(Math.floor($('#menu_holder').width()/147)*147+'px');
    });
    

}
));


  $(function() {
    $( "#datepicker" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
  });
  
  $(function() {
    $( ".spinner" ).spinner({
      spin: function( event, ui ) {
        
      }
    });
  });
  
 
    function loadDoc(hPath) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                $('<div></div>').dialog({
                    modal: true,
                    width: "80%",
                    show: {
                        effect: "fade",
                        duration: 200
                      },
                    hide: {
                        effect: "fade",
                        duration: 200
                      },
                    position: { my: "top", at: "top", of: "div#content"},
                    title: "Code for Selected Plugin",
                    open: function() {
                      var markup = xhttp.responseText;
                      $(this).html(markup); 
                    },
                    buttons: [{
                        text: "Close",
                        icons: {
                            primary: "ui-icon-close"
                        },
                        click: function() {
                            $( this ).dialog( "close" );
                        }
                    }]
                }); 

            }
        };
        xhttp.open("GET", aSvars['sFoxRoot']+"fox_cpr/index.php?type=ajax&call=getPlugin&param=" + hPath, true);
        xhttp.send();
    } 
    
    function updateItem(item_id) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
 
            }
        };
        xhttp.open("GET", aSvars['sFoxRoot']+"index.php?type=ajax&call=adjustItem&param=" + item_id, true);
        xhttp.send();
    }     

    function deleteItem(item_id) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (xhttp.readyState == 4 && xhttp.status == 200) {
                //alert(xhttp.responseText);
                //$( "#row_"+item_id ).remove();
                $( "#row_"+item_id ).fadeOut(800, function() { $(this).remove(); });
            }
        };
        xhttp.open("GET", aSvars['sFoxRoot']+"index.php?type=ajax&call=deleteItem&param=" + item_id, true);
        xhttp.send();
    }     

$(function() {
    
              $(function() {
            $( "#dialog-1" ).dialog({
               autoOpen: false,
               modal: true,
                show: {
                    effect: "drop",
                    duration: 500
                      },
                hide: {
                    effect: "fade",
                    duration: 500
                      },
                    buttons: [
                    {
                        text: "Submit",
                        click: function() {
                            $('form#login').submit();
                        }
                    }                
                    ]
            });
            $( "#opener" ).click(function() {
               $( "#dialog-1" ).dialog( "open" );
            });
         });
         
         
$(".tworowout").height($(".tworow").height()); 

$( ".spinner" ).spinner({
  icons: { down: "ui-icon-minusthick", up: "ui-icon-plusthick" }
});
         
$( ".ui-spinner-up" ).click(function() {
    updateItem($(this).prev( 'input' ).attr('id'));
//         alert($(this).prev( 'input' ).attr('id'));
});      

$( ".ui-spinner-down" ).click(function() {
        updateItem('-'+$(this).prev().prev().attr('id'));
//             alert('-'+$(this).prev().prev().attr('id'));
}); 

$( ".di" ).click(function() {
    if(confirm('Delete this item?')) {
        deleteItem($(this).attr('id').substring(3));
    } else {
        return false;
    }
  //alert('delete '+$(this).attr('id').substring(3));
  return false;
}); 

$( ".ei" ).click(function() {
        //editItem($(this).attr('id'));
  //alert('edit '+$(this).attr('id'));
  window.location.href = "index.php?page=edit&item_id="+$(this).attr('id').substring(3);
  return false;
}); 

});    


