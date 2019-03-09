var Kategoriler = function () {

    var initPickers = function () {
        //init date pickers
        $('.date-picker').datepicker({
            rtl: Metronic.isRTL(),
            autoclose: true
        });
    }

    var handleItems = function() {
        var grid = new Datatable();

        grid.init({
            src: $("#datatable"),
            onSuccess: function (grid) {
                // execute some code after table records loaded
            },
            onError: function (grid) {
                // execute some code on network or other general error  
            },
            loadingMessage: 'Yükleniyor...',
            dataTable: { // here you can define a typical datatable settings from http://datatables.net/usage/options 

                // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
                // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/scripts/datatable.js). 
                // So when dropdowns used the scrollable div should be removed. 
                //"dom": "<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'<'table-group-actions pull-right'>>r>t<'row'<'col-md-8 col-sm-12'pli><'col-md-4 col-sm-12'>>",

                "lengthMenu": [
                    [10, 20, 50, 100, 150],
                    [10, 20, 50, 100, 150] // change per page values here 
                ],
                "pageLength": 10, // default record count per page
                "ajax": {
                    "url": "ajax/kategoriler.php" // ajax source
                },
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            }
        });

         // arama bölümü için
        grid.getTableWrapper().on('keyup', '.form-filter', function () {
            console.log($(this).attr("name") + " - " + $(this).val());
            grid.setAjaxParam($(this).attr("name"), $(this).val());
            grid.getDataTable().ajax.reload();
            grid.clearAjaxParams();
        });

        //kategori silme işlemi
        grid.getTableWrapper().on('click', '.sil', function () {
            var gelenid = $(this).attr("data-id");
            bootbox.dialog({
                message: "Silmek istediğinizden eminisiniz? Bu işlemin geri dönüşü yoktur.",
                title: "Silme İşlemi Onayı",
                buttons: {
                    danger: {
                        label: "Sil",
                        className: "red",
                        callback: function() {
                            //console.log(gelenid);
                            var request = $.ajax({
                                url: "ajax/sil.php",
                                method: "POST",
                                data: { sayfa: "kategorisil", id : gelenid },
                                dataType: "html"
                            });

                            request.done(function( msg ) {
                                grid.getDataTable().ajax.reload();
                            });

                            request.fail(function( jqXHR, textStatus ) {
                                alert( "Silme İşlemi Başarısız Oldu: " + textStatus );
                            });
                        }
                    },
                    main: {
                        label: "Geri",
                        className: "blue",
                        callback: function() {
                        }
                    }
                }
            });
        });

    }

    return {

        //main function to initiate the module
        init: function () {

            handleItems();
            initPickers();
            
        }

    };

}();