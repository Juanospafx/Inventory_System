/*
  Archivo de funciones reescrito en Vanilla JavaScript para eliminar la dependencia de jQuery.
  Se han modernizado las llamadas AJAX con la API Fetch y se han adaptado los selectores y manejadores de eventos.
*/

function suggestion() {
    const sugInput = document.getElementById('sug_input');
    if (!sugInput) return;

    sugInput.addEventListener('keyup', function (e) {
        const productName = this.value;
        const resultDiv = document.getElementById('result');

        if (productName.length >= 1) {
            fetch(`${window.APP_BASE_URL}/api/ajax.php?product_name=${encodeURIComponent(productName)}`)
                .then(response => response.text())
                .then(data => {
                    resultDiv.innerHTML = data;
                    resultDiv.style.display = 'block';

                    resultDiv.querySelectorAll('li').forEach(li => {
                        li.addEventListener('click', function () {
                            sugInput.value = this.textContent.trim();
                            resultDiv.style.display = 'none';
                        });
                    });
                }).catch(error => console.error('Error en la sugerencia:', error));
        } else {
            resultDiv.style.display = 'none';
        }
    });

    sugInput.addEventListener('blur', function () {
        // Pequeño retraso para permitir el click en la lista de resultados
        setTimeout(() => {
            const resultDiv = document.getElementById('result');
            if (resultDiv) resultDiv.style.display = 'none';
        }, 200);
    });
}

/**
 * Función genérica para filtrar tablas en el lado del cliente.
 * @param {string} inputId - El ID del campo de búsqueda.
 * @param {string} tableId - El ID de la tabla a filtrar.
 */
function clientSideFilter(inputId, tableId) {
    const searchInput = document.getElementById(inputId);
    const table = document.getElementById(tableId);
    if (!searchInput || !table) return;

    searchInput.addEventListener('keyup', function () {
        const filterValue = this.value.toLowerCase();
        const rows = table.querySelectorAll('tbody tr');

        rows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(filterValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function () {
    // Establecer la URL base para la aplicación
    const baseUrl = document.body.dataset.baseUrl || '';
    window.APP_BASE_URL = baseUrl;

    // Tema global (dark/light)
    const themeToggleBtn = document.getElementById('themeToggle');
    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            document.documentElement.classList.add('theme-transition');
            if (window.__toggleTheme) window.__toggleTheme();
            setTimeout(() => document.documentElement.classList.remove('theme-transition'), 350);
        });
    }

    // Inicializar tooltips de Bootstrap 5
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Manejador para los submenús
    document.querySelectorAll('.submenu-toggle').forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;
            if (submenu && submenu.classList.contains('submenu')) {
                // Simple toggle, para animación se necesitaría más CSS
                if (submenu.style.display === 'block') {
                    submenu.style.display = 'none';
                    this.setAttribute('aria-expanded', 'false');
                } else {
                    submenu.style.display = 'block';
                    this.setAttribute('aria-expanded', 'true');
                }
            }
        });
    });

    // Inicializar la función de sugerencias
    suggestion();

    // Inicializar filtros de tablas
    clientSideFilter('searchInput', 'productsTable');
    clientSideFilter('searchMovementsInput', 'movementsTable');
    clientSideFilter('shelfSearch', 'shelfTable');
    clientSideFilter('projectSearch', 'projectTable');
    clientSideFilter('userSearch', 'userTable');

    // --- Lógica de la barra lateral (Sidebar) ---
    function setSidebarState(isCollapsed) {
        const body = document.body;
        if (isCollapsed) {
            body.classList.add('sidebar-collapsed');
        } else {
            body.classList.remove('sidebar-collapsed');
        }
        localStorage.setItem('sidebar-collapsed', isCollapsed ? '1' : '0');
    }

    function setMobileSidebar(isOpen) {
        const body = document.body;
        if (isOpen) {
            body.classList.add('sidebar-open');
        } else {
            body.classList.remove('sidebar-open');
        }
    }

    // Restaurar estado de la barra lateral al cargar la página
    const isMobile = window.innerWidth <= 767;
    const collapsed = !isMobile && localStorage.getItem('sidebar-collapsed') === '1';
    setSidebarState(collapsed);

    // Manejador del botón para colapsar/mostrar la barra lateral
    const toggleBtn = document.querySelector('.sidebar-toggle-btn');
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();
            if (window.innerWidth <= 767) {
                setMobileSidebar(!document.body.classList.contains('sidebar-open'));
            } else {
                setSidebarState(!document.body.classList.contains('sidebar-collapsed'));
            }
        });
    }

    // Ocultar barra lateral móvil al hacer clic en el overlay
    const overlay = document.getElementById('sidebarOverlay');
    if (overlay) {
        overlay.addEventListener('click', () => setMobileSidebar(false));
    }

    // Cerrar sidebar móvil al seleccionar opción
    document.querySelectorAll('.sidebar a').forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 767) {
                setMobileSidebar(false);
            }
        });
    });

    // Cerrar con tecla Escape en móvil
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && window.innerWidth <= 767) {
            setMobileSidebar(false);
        }
    });

    // Ajustar la barra lateral en cambios de tamaño de ventana
    window.addEventListener('resize', function () {
        if (window.innerWidth > 767) {
            setMobileSidebar(false);
            const wantCollapsed = localStorage.getItem('sidebar-collapsed') === '1';
            setSidebarState(wantCollapsed);
        } else {
            document.body.classList.remove('sidebar-collapsed');
            setSidebarState(false);
        }
    });
});
