</div>
</div>
<!-- Eliminado jQuery y Bootstrap 3 JS. Se reemplaza con el bundle de Bootstrap 5 que incluye Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- El archivo functions.js ha sido reescrito en Vanilla JS para eliminar la dependencia de jQuery -->
<script type="text/javascript" src="<?php echo base_url('libs/js/functions.js'); ?>"></script>
<script>
  // La lógica del reloj se reescribe en Vanilla JS, eliminando la dependencia de jQuery.
  document.addEventListener('DOMContentLoaded', function() {
    function updateTime() {
      var date = new Date();
      var options = { timeZone: 'America/New_York', hour12: true, hour: 'numeric', minute: 'numeric', second: 'numeric' };
      var timeEl = document.getElementById('time');
      if(timeEl) timeEl.textContent = date.toLocaleDateString('en-US') + ' ' + date.toLocaleTimeString('en-US', options);
    }

    setInterval(updateTime, 1000);
    updateTime();
  });
</script>

</body>

</html>

<?php if (isset($db)) {
  $db->db_disconnect();
} ?>
