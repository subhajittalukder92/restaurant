$(document).ready(function() {
    $('#kot_print_btn').click(function(){
      $("#DivInvoiceToPrint").hide();
      $(this).hide();
      window.print('#DivKotToPrint');
      $(this).show();
      $("#DivInvoiceToPrint").show();
    });

    $('#invoice_print_btn').click(function(){
      $("#DivKotToPrint").hide();
      $(this).hide();
      window.print('#DivInvoiceToPrint');
      $(this).show();
      $("#DivKotToPrint").show();
    });
 });
 
 