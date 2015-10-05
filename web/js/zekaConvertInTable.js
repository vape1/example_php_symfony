(function($) {
  $.fn.convertInTable = function(options) {
    options = $.extend({}, $.fn.convertInTable.defaults, options);
    
    var callSubcategoryTable = $("<table/>");
    var countRows = 0;
    
    $(this).find(options.sel).each(function(i, val) {
        if( countRows % options.td == 0 ){
            callSubcategoryTable.append($("<tr></tr>"));
        }
        callSubcategoryTable.find("tr:last")
            .append($("<td style='padding-right:20px;'></td>"));
        callSubcategoryTable.find("tr:last").find("td:last")
            .append(val)
            .append('&nbsp;')
            .append($("label[for='" + $(this).attr('id') + "']"));
        countRows++;
    });
    
    $(this).html(callSubcategoryTable);
  }
  $.fn.convertInTable.defaults = {
    td: 5,
    sel: 'input:radio'
  };
})(jQuery);
