$(function() {
  'use strict';

  $(function() {
    $('#dataTableExample').DataTable({
      "aLengthMenu": [
        [10, 30, 50, -1],
        [10, 30, 50, "All"]
      ],
      "iDisplayLength": 10,
      "language": {
        search: "",
        "sSearchPlaceholder": "   "
      }, "search": {
            "width": ""
        }
    });
      $('.dataTables_filter input').css(   { 'width': '300px','padding':'10px' });
      $(document).ready(function() {
          var datatable = $('#dataTableExample').DataTable();


          $(searchInput).on('keyup', function() {
              var searchValue = this.value.trim().toLowerCase();
              datatable.column(0).search(searchValue, true, false).draw();
          });

          // Insert the search input field into the table header
          $('#dataTableExample thead tr').append('<th></th>');
          $('#dataTableExample thead tr').eq(1).append(searchInput);
      });





  });

});
