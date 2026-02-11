function suggetion() {
    $('#sug_input').keyup(function (e) {
        var formData = {
            'product_name': $('input[name=title]').val()
        };

        if (formData['product_name'].length >= 1) {
            // Procesa el formulario vía AJAX
            $.ajax({
                type: 'POST',
                url: (window.APP_BASE_URL || '') + '/api/ajax.php',
                data: formData,
                dataType: 'json',
                encode: true
            })
                .done(function (data) {
                    //console.log(data);
                    $('#result').html(data).fadeIn();
                    $('#result li').click(function () {
                        $('#sug_input').val($(this).text());
                        $('#result').fadeOut(500);
                    });

                    $("#sug_input").blur(function () {
                        $("#result").fadeOut(500);
                    });
                });
        } else {
            $("#result").hide();
        }
        e.preventDefault();
    });
}

$('#sug-form').submit(function (e) {
    var formData = {
        'p_name': $('input[name=title]').val()
    };
    // Procesa el formulario vía AJAX
$.ajax({
        type: 'POST',
        url: (window.APP_BASE_URL || '') + '/api/ajax.php',
        data: formData,
        dataType: 'json',
        encode: true
    })
        .done(function (data) {
            //console.log(data);
            $('#product_info').html(data).show();
            total();
            $('.datePicker').datepicker('update', new Date());
        }).fail(function (jqXHR, textStatus, errorThrown) {
            $('#product_info').html("Ocurrió un error: " + textStatus).show();
        });
    e.preventDefault();
});

function total() {
    $('#product_info input').change(function (e) {
        var price = +$('input[name=price]').val() || 0;
        var qty = +$('input[name=quantity]').val() || 0;
        var total = qty * price;
        $('input[name=total]').val(total.toFixed(2));
    });
}

// Función para filtrar productos en la página (filtrado en el cliente)
function filterProducts() {
    $("#searchInput").on("keyup", function () {
        // Obtiene el valor ingresado y lo convierte a minúsculas
        var value = $(this).val().toLowerCase();
        // Recorre cada fila del tbody de la tabla y muestra u oculta según el texto
        $("#productsTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
}

// Nueva función para filtrar movimientos en la página (filtrado en el cliente)
function filterMovements() {
    $("#searchMovementsInput").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#movementsTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
}

// Nueva función para filtrar anaqueles (shelves)
function filterShelves() {
    $("#shelfSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#shelfTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
}

// Nueva función para filtrar proyectos
function filterProjects() {
    $("#projectSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#projectTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
}

// Nueva función para filtrar usuarios
function filterUsers() {
    $("#userSearch").on("keyup", function () {
        var value = $(this).val().toLowerCase();
        $("#userTable tbody tr").filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
}

$(document).ready(function () {
    var baseUrl = $('body').data('base-url') || '';
    window.APP_BASE_URL = baseUrl;

    // Inicializa tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Toggle de submenús
    $('.submenu-toggle').click(function (e) {
        e.preventDefault();
        var $parent = $(this).parent();
        $parent.children('ul.submenu').slideToggle(200);
        $(this).attr('aria-expanded', $parent.children('ul.submenu').is(':visible'));
    });

    // Inicializa la sugerencia de productos vía AJAX
    suggetion();

    // Calcula totales
    total();

    // Inicializa datepicker
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
    });

    // Inicializa el filtrado de productos
    filterProducts();

    // Inicializa el filtrado de movimientos
    filterMovements();

    // Inicializa el filtrado de anaqueles
    filterShelves();

    // Inicializa el filtrado de proyectos
    filterProjects();

    // Inicializa el filtrado de usuarios
    filterUsers();

    function setSidebarState(isCollapsed) {
        if (isCollapsed) {
            $('body').addClass('sidebar-collapsed');
        } else {
            $('body').removeClass('sidebar-collapsed');
        }
        localStorage.setItem('sidebar-collapsed', isCollapsed ? '1' : '0');
    }

    function setMobileSidebar(isOpen) {
        if (isOpen) {
            $('body').addClass('sidebar-open');
        } else {
            $('body').removeClass('sidebar-open');
        }
    }

    var collapsed = localStorage.getItem('sidebar-collapsed') === '1';
    setSidebarState(collapsed);

    // Sidebar toggle (desktop collapse + mobile open)
    $('.sidebar-toggle-btn').click(function (e) {
        e.preventDefault();
        if (window.innerWidth <= 767) {
            setMobileSidebar(!$('body').hasClass('sidebar-open'));
            return;
        }
        setSidebarState(!$('body').hasClass('sidebar-collapsed'));
    });

    $('#sidebarOverlay').on('click', function () {
        setMobileSidebar(false);
    });

    $(window).on('resize', function () {
        if (window.innerWidth > 767) {
            setMobileSidebar(false);
        }
    });
});
