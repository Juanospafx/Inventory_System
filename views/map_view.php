<div class="map-container" style="position: relative; display: table; min-width: 1000px; margin: 0 auto;">
    <!-- Imagen del Mapa -->
    <img src="<?php echo base_url('libs/images/Map.png'); ?>" alt="Warehouse Map" style="width: 100%; display: block;">

    <!-- Botones de Anaqueles -->
    <!-- Zona A (A1, A2, A3) -->
    <div class="shelf-btn" onclick="openShelfModal('A1')" style="top: 65%; left: 44.5%; width: 5%; height: 15%;" title="Shelf A1"></div>
    <div class="shelf-btn" onclick="openShelfModal('A2')" style="top: 48%; left: 44.5%; width: 5%; height: 15%;" title="Shelf A2"></div>
    <div class="shelf-btn" onclick="openShelfModal('A3')" style="top: 31%; left: 44.5%; width: 5%; height: 15%;" title="Shelf A3"></div>

    <!-- Zona B -->
    <div class="shelf-btn" onclick="openShelfModal('B')" style="top: 66%; left: 34.5%; width: 4.5%; height: 16%;" title="Shelf B"></div>

    <!-- Zona C -->
    <div class="shelf-btn" onclick="openShelfModal('C')" style="top: 49%; left: 34.5%; width: 4.5%; height: 16%;" title="Shelf C"></div>

    <!-- Zona D -->
    <div class="shelf-btn" onclick="openShelfModal('D')" style="top: 28%; left: 34.5%; width: 4.5%; height: 20%;" title="Shelf D"></div>

    <!-- Zona E -->
    <div class="shelf-btn" onclick="openShelfModal('E')" style="top: 28%; left: 23%; width: 11%; height: 7%;" title="Shelf E"></div>

    <!-- Zona F -->
    <div class="shelf-btn" onclick="openShelfModal('F')" style="top: 28%; left: 11.5%; width: 11%; height: 7%;" title="Shelf F"></div>

    <!-- Zona G -->
    <div class="shelf-btn" onclick="openShelfModal('G')" style="top: 86%; left: 12.5%; width: 18%; height: 6%;" title="Shelf G"></div>

    <!-- Zona H (H1, H2, H3) -->
    <div class="shelf-btn" onclick="openShelfModal('H1')" style="top: 11%; left: 40%; width: 8%; height: 7%;" title="Shelf H1"></div>
    <div class="shelf-btn" onclick="openShelfModal('H2')" style="top: 11%; left: 30%; width: 9%; height: 7%;" title="Shelf H2"></div>
    <div class="shelf-btn" onclick="openShelfModal('H3')" style="top: 11%; left: 20%; width: 9%; height: 7%;" title="Shelf H3"></div>

    <!-- Zona I -->
    <div class="shelf-btn" onclick="openShelfModal('I')" style="top: 57%; left: 66%; width: 4%; height: 17%;" title="Shelf I"></div>

    <!-- Zona J -->
    <div class="shelf-btn" onclick="openShelfModal('J')" style="top: 32%; left: 86.5%; width: 4%; height: 17%;" title="Shelf J"></div>

    <!-- Zona K -->
    <div class="shelf-btn" onclick="openShelfModal('K')" style="top: 50%; left: 86.5%; width: 4%; height: 17%;" title="Shelf K"></div>

    <!-- Zona L -->
    <div class="shelf-btn" onclick="openShelfModal('L')" style="top: 11%; left: 68.5%; width: 13.5%; height: 8%;" title="Shelf L"></div>

    <!-- Zona M -->
    <div class="shelf-btn" onclick="openShelfModal('M')" style="top: 11%; left: 55%; width: 13%; height: 8%;" title="Shelf M"></div>

    <!-- Zona N -->
    <div class="shelf-btn" onclick="openShelfModal('N')" style="top: 32%; left: 50.5%; width: 4.5%; height: 18%;" title="Shelf N"></div>

    <!-- Zona O -->
    <div class="shelf-btn" onclick="openShelfModal('O')" style="top: 32%; left: 57.5%; width: 4%; height: 18%;" title="Shelf O"></div>

    <!-- Zona P -->
    <div class="shelf-btn" onclick="openShelfModal('P')" style="top: 32%; left: 61.5%; width: 4%; height: 18%;" title="Shelf P"></div>

    <!-- Zona Q -->
    <div class="shelf-btn" onclick="openShelfModal('Q')" style="top: 11%; left: 50.5%; width: 4%; height: 6%; border-radius: 50%;" title="Shelf Q"></div>

    <!-- Zona R -->
    <div class="shelf-btn" onclick="openShelfModal('R')" style="top: 43%; left: 66%; width: 4%; height: 13%; border-radius: 20px;" title="Shelf R"></div>

    <!-- Zona S -->
    <div class="shelf-btn" onclick="openShelfModal('S')" style="top: 54%; left: 77.5%; width: 5%; height: 20%; border-radius: 20px;" title="Shelf S"></div>

    <!-- Zona T -->
    <div class="shelf-btn" onclick="openShelfModal('T')" style="top: 56%; left: 25.5%; width: 5%; height: 20%; border-radius: 20px;" title="Shelf T"></div>

    <!-- Zona U -->
    <div class="shelf-btn" onclick="openShelfModal('U')" style="top: 56%; left: 13%; width: 5%; height: 20%; border-radius: 20px;" title="Shelf U"></div>

    <!-- Zona V -->
    <div class="shelf-btn" onclick="openShelfModal('V')" style="top: 41%; left: 13%; width: 17%; height: 8%; border-radius: 20px;" title="Shelf V"></div>

    <!-- Zona W -->
    <div class="shelf-btn" onclick="openShelfModal('W')" style="top: 75%; left: 66%; width: 4%; height: 5%; border-radius: 50%;" title="Shelf W"></div>

    <!-- Zona X -->
    <div class="shelf-btn" onclick="openShelfModal('X')" style="top: 32%; left: 77.5%; width: 5%; height: 20%; border-radius: 20px;" title="Shelf X"></div>

    <!-- Zona Y -->
    <div class="shelf-btn" onclick="openShelfModal('Y')" style="top: 68%; left: 86.5%; width: 4%; height: 18%;" title="Shelf Y"></div>

    <!-- Zona Z -->
    <div class="shelf-btn" onclick="openShelfModal('Z')" style="top: 86%; left: 34.5%; width: 4%; height: 6%; border-radius: 50%;" title="Shelf Z"></div>
</div>

<!-- Modal de Selección de Acción -->
<div class="modal fade" id="shelfActionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content bg-panel border-subtle shadow-card">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title text-primary fw-bold fs-6">Shelf <span id="modalShelfName"></span></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <p class="text-muted mb-3 small">Select action:</p>
                <div class="d-grid gap-2">
                    <a href="#" id="btnAddItem" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i> Add Item
                    </a>
                    <a href="#" id="btnOutputItem" class="btn btn-warning text-white">
                        <i class="fa-solid fa-dolly me-2"></i> Output / Move
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openShelfModal(shelfName) {
        document.getElementById('modalShelfName').textContent = shelfName;
        document.getElementById('btnAddItem').href = 'add_product.php?shelf_filter=' + shelfName;
        document.getElementById('btnOutputItem').href = 'add_movement.php?shelf_filter=' + shelfName;

        var myModal = new bootstrap.Modal(document.getElementById('shelfActionModal'));
        myModal.show();
    }
</script>