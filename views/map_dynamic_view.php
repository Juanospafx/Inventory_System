<?php
$defaultShelves = [
  ['id'=>'H3','x'=>130,'y'=>55,'width'=>3.0,'length'=>1.5,'depth'=>1.0,'levels'=>2,'capacity'=>500,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'H2','x'=>250,'y'=>55,'width'=>3.0,'length'=>1.5,'depth'=>1.0,'levels'=>2,'capacity'=>500,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'H1','x'=>370,'y'=>55,'width'=>3.0,'length'=>1.5,'depth'=>1.0,'levels'=>2,'capacity'=>500,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'Q','x'=>530,'y'=>55,'width'=>1.4,'length'=>1.4,'depth'=>1.0,'levels'=>1,'capacity'=>200,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>0],
  ['id'=>'M','x'=>595,'y'=>55,'width'=>4.5,'length'=>1.8,'depth'=>1.2,'levels'=>3,'capacity'=>850,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'L','x'=>775,'y'=>55,'width'=>4.5,'length'=>1.8,'depth'=>1.2,'levels'=>3,'capacity'=>850,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],

  ['id'=>'F','x'=>55,'y'=>205,'width'=>3.5,'length'=>1.8,'depth'=>1.2,'levels'=>3,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'E','x'=>195,'y'=>205,'width'=>3.5,'length'=>1.8,'depth'=>1.2,'levels'=>3,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'D','x'=>335,'y'=>205,'width'=>1.8,'length'=>4.5,'depth'=>1.2,'levels'=>4,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'C','x'=>335,'y'=>385,'width'=>1.8,'length'=>4.5,'depth'=>1.2,'levels'=>4,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'B','x'=>335,'y'=>565,'width'=>1.8,'length'=>4.5,'depth'=>1.2,'levels'=>4,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],

  ['id'=>'V','x'=>95,'y'=>330,'width'=>5.0,'length'=>1.8,'depth'=>1.0,'levels'=>2,'capacity'=>650,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>0],
  ['id'=>'U','x'=>85,'y'=>485,'width'=>2.0,'length'=>4.0,'depth'=>1.0,'levels'=>3,'capacity'=>500,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>90],
  ['id'=>'T','x'=>215,'y'=>485,'width'=>2.0,'length'=>4.0,'depth'=>1.0,'levels'=>3,'capacity'=>500,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>90],
  ['id'=>'G','x'=>70,'y'=>745,'width'=>6.0,'length'=>1.6,'depth'=>1.0,'levels'=>2,'capacity'=>800,'unit'=>'kg','color'=>'#b0bec5','rotation'=>0],
  ['id'=>'Z','x'=>345,'y'=>742,'width'=>1.4,'length'=>1.4,'depth'=>1.0,'levels'=>1,'capacity'=>200,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>0],

  ['id'=>'A3','x'=>470,'y'=>235,'width'=>1.7,'length'=>4.0,'depth'=>1.2,'levels'=>4,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'A2','x'=>470,'y'=>410,'width'=>1.7,'length'=>4.0,'depth'=>1.2,'levels'=>4,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'A1','x'=>470,'y'=>580,'width'=>1.7,'length'=>4.0,'depth'=>1.2,'levels'=>4,'capacity'=>700,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],

  ['id'=>'N','x'=>560,'y'=>260,'width'=>2.0,'length'=>4.8,'depth'=>1.0,'levels'=>4,'capacity'=>620,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'O','x'=>675,'y'=>260,'width'=>2.0,'length'=>4.8,'depth'=>1.0,'levels'=>4,'capacity'=>620,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'P','x'=>745,'y'=>260,'width'=>2.0,'length'=>4.8,'depth'=>1.0,'levels'=>4,'capacity'=>620,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'R','x'=>812,'y'=>360,'width'=>1.8,'length'=>2.5,'depth'=>1.0,'levels'=>3,'capacity'=>420,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>90],
  ['id'=>'I','x'=>812,'y'=>510,'width'=>1.8,'length'=>3.3,'depth'=>1.0,'levels'=>3,'capacity'=>420,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'W','x'=>812,'y'=>645,'width'=>1.3,'length'=>1.3,'depth'=>1.0,'levels'=>1,'capacity'=>150,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>0],

  ['id'=>'X','x'=>945,'y'=>295,'width'=>2.2,'length'=>4.2,'depth'=>1.0,'levels'=>3,'capacity'=>560,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>90],
  ['id'=>'S','x'=>945,'y'=>500,'width'=>2.2,'length'=>4.2,'depth'=>1.0,'levels'=>3,'capacity'=>560,'unit'=>'kg','color'=>'#cfd8dc','rotation'=>90],
  ['id'=>'J','x'=>1085,'y'=>240,'width'=>1.8,'length'=>4.8,'depth'=>1.0,'levels'=>4,'capacity'=>620,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'K','x'=>1085,'y'=>425,'width'=>1.8,'length'=>4.8,'depth'=>1.0,'levels'=>4,'capacity'=>620,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90],
  ['id'=>'Y','x'=>1085,'y'=>610,'width'=>1.8,'length'=>4.8,'depth'=>1.0,'levels'=>4,'capacity'=>620,'unit'=>'kg','color'=>'#b0bec5','rotation'=>90]
];
?>

<style>
  .warehouse-map-shell{min-width:1300px}
  .warehouse-toolbar{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px;align-items:center}
  .warehouse-scale{color:#9fb3c8;font-size:12px;margin-left:auto}
  .warehouse-stage{position:relative;width:1220px;height:860px;margin:0 auto;border:2px solid rgba(255,255,255,.15);border-radius:10px;background:#eceff1;overflow:hidden;box-shadow:inset 0 0 0 1px rgba(0,0,0,.06)}
  .warehouse-stage::before{content:"";position:absolute;inset:0;background-image:linear-gradient(to right, rgba(0,0,0,.05) 1px, transparent 1px),linear-gradient(to bottom, rgba(0,0,0,.05) 1px, transparent 1px);background-size:40px 40px;pointer-events:none}
  .fixed-zone{position:absolute;border:2px dashed rgba(0,0,0,.22);background:rgba(0,0,0,.03);color:#37474f;font-size:12px;display:flex;align-items:center;justify-content:center;text-align:center;z-index:1;user-select:none}
  .fixed-office{background:rgba(180,210,240,.45)!important;font-weight:700}

  .shelf-item{position:absolute;border:1px solid rgba(0,0,0,.18);border-radius:8px;cursor:grab;z-index:5;color:#212121;font-size:14px;display:flex;align-items:center;justify-content:center;font-weight:700;user-select:none;touch-action:none;transition:box-shadow .12s ease}
  .shelf-item.dragging,.shelf-item.resizing,.shelf-item.rotating{cursor:grabbing;box-shadow:0 8px 24px rgba(0,0,0,.25)}
  .shelf-item.selected{box-shadow:0 0 0 3px rgba(255,193,7,.45)}
  .shelf-item .label{pointer-events:none}
  .resize-handle,.rotate-handle{position:absolute;background:#1565c0;border:1px solid #fff;border-radius:50%;display:none;z-index:6}
  .resize-handle{width:10px;height:10px}
  .rotate-handle{width:12px;height:12px;top:-24px;left:calc(50% - 6px);cursor:grab;background:#ff7043}
  .shelf-item.selected .resize-handle,.shelf-item.selected .rotate-handle{display:block}
  .resize-handle.nw{left:-6px;top:-6px;cursor:nwse-resize}
  .resize-handle.ne{right:-6px;top:-6px;cursor:nesw-resize}
  .resize-handle.sw{left:-6px;bottom:-6px;cursor:nesw-resize}
  .resize-handle.se{right:-6px;bottom:-6px;cursor:nwse-resize}

  #shelfConfigModal{z-index:20000}
  .modal-backdrop.show{z-index:19990}
  #shelfConfigModal .modal-content{color:#eaf2ff;background:#1e293b}
  #shelfConfigModal .form-label,#shelfConfigModal .modal-title{color:#eaf2ff!important;font-weight:600}
  #shelfConfigModal .form-control,#shelfConfigModal .form-select{background:#0f172a;color:#f8fafc;border:1px solid #334155;font-size:16px}
  #shelfConfigModal .form-control:focus,#shelfConfigModal .form-select:focus{background:#0b1220;color:#fff;border-color:#60a5fa;box-shadow:0 0 0 .2rem rgba(96,165,250,.2)}
  #shelfConfigModal .modal-body{overflow-y:auto;padding-bottom:1rem}
  #shelfConfigModal .modal-footer{background:#1e293b}

  @media (max-width: 1200px){
    .warehouse-map-shell{min-width:100%}
    .warehouse-stage{width:1220px;height:860px}
    #shelfConfigModal .modal-dialog{margin:0;max-width:100vw}
    #shelfConfigModal .modal-content{min-height:100vh;max-height:100vh;border-radius:0}
    #shelfConfigModal .modal-body{padding:.8rem;max-height:calc(100vh - 190px)}
    #shelfConfigModal .modal-footer{position:sticky;bottom:0;z-index:2;padding:.6rem}
    #shelfConfigModal .btn{min-height:44px}
  }

  .place-mode{outline:3px dashed rgba(255,193,7,.45);outline-offset:-8px;cursor:crosshair}
</style>

<div class="warehouse-map-shell">
  <div class="warehouse-toolbar">
    <button type="button" class="btn btn-sm btn-primary" id="btnAddShelf"><i class="fa-solid fa-plus"></i> Agregar Anaquel</button>
    <button type="button" class="btn btn-sm btn-success" id="btnSaveLayout"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
    <button type="button" class="btn btn-sm btn-info text-white" id="btnExportLayout"><i class="fa-solid fa-download"></i> Exportar JSON</button>
    <span class="warehouse-scale">Escala: 1m = 40px</span>
  </div>
  <div id="warehouseStage" class="warehouse-stage"></div>
</div>

<div class="modal fade" id="shelfConfigModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
    <div class="modal-content bg-panel border-subtle shadow-card">
      <div class="modal-header">
        <h5 class="modal-title">Anaquel <span id="cfgShelfName"></span></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row g-2">
          <div class="col-md-6"><label class="form-label">ID / Nombre</label><input type="text" class="form-control" id="cfgId"></div>
          <div class="col-md-6"><label class="form-label">Color</label><input type="color" class="form-control form-control-color" id="cfgColor"></div>
          <div class="col-md-4"><label class="form-label">Ancho</label><input type="number" step="0.1" min="0.1" class="form-control" id="cfgWidth"></div>
          <div class="col-md-4"><label class="form-label">Largo</label><input type="number" step="0.1" min="0.1" class="form-control" id="cfgLength"></div>
          <div class="col-md-4"><label class="form-label">Profundidad</label><input type="number" step="0.1" min="0.1" class="form-control" id="cfgDepth"></div>
          <div class="col-md-4"><label class="form-label">Niveles</label><input type="number" min="1" step="1" class="form-control" id="cfgLevels"></div>
          <div class="col-md-4"><label class="form-label">Capacidad</label><input type="number" min="1" step="1" class="form-control" id="cfgCapacity"></div>
          <div class="col-md-4"><label class="form-label">Unidad</label><select class="form-select" id="cfgUnit"><option value="kg">kg</option><option value="lbs">lbs</option></select></div>
          <div class="col-md-6"><label class="form-label">Rotación (°)</label><input type="number" min="0" max="359" step="1" class="form-control" id="cfgRotation"></div>
        </div>
        <hr>
        <div class="d-grid gap-2">
          <a href="#" id="cfgAddItem" class="btn btn-primary btn-sm"><i class="fa-solid fa-plus me-1"></i> Add Item</a>
          <a href="#" id="cfgMoveItem" class="btn btn-warning text-white btn-sm"><i class="fa-solid fa-dolly me-1"></i> Output / Move</a>
          <a href="#" id="cfgViewItems" class="btn btn-info text-white btn-sm"><i class="fa-solid fa-eye me-1"></i> View Shelf Items</a>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-between">
        <button type="button" class="btn btn-danger" id="btnDeleteShelf">Eliminar</button>
        <div><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button><button type="button" class="btn btn-success" id="btnApplyShelf">Aplicar</button></div>
      </div>
    </div>
  </div>
</div>

<script>
(() => {
  const stage = document.getElementById('warehouseStage');
  const pxPerMeter = 40;
  const apiUrl = 'map_layout_api.php';
  const localKey = 'warehouse_layout_v1';
  const defaultShelves = <?php echo json_encode($defaultShelves, JSON_UNESCAPED_UNICODE); ?>;
  const fixedZones = [
    { label:'Baños', x:8, y:65, w:110, h:150 },
    { label:'Baños', x:1100, y:65, w:110, h:120 },
    { label:'Office', x:620, y:430, w:220, h:330, office:true },
    { label:'Elevador', x:540, y:790, w:70, h:55 },
    { label:'Elevador', x:650, y:790, w:70, h:55 },
    { label:'Pared / Límite', x:0, y:0, w:1220, h:860, borderOnly:true }
  ];

  let shelves = [];
  let selectedId = null;
  let addMode = false;
  let dragState = null;
  let autoSaveTimer = null;

  function msg(type, text){ const d=document.createElement('div'); d.className=`alert alert-${type} py-2 px-3 mt-2`; d.textContent=text; stage.parentElement.appendChild(d); setTimeout(()=>d.remove(),2200); }
  function normalize(raw){ return { id:String(raw.id||'').trim(), x:Number(raw.x)||40, y:Number(raw.y)||40, width:Math.max(0.2,Number(raw.width)||1.8), length:Math.max(0.2,Number(raw.length)||1.8), depth:Math.max(0.1,Number(raw.depth)||1), levels:Math.max(1,parseInt(raw.levels||1,10)), capacity:Math.max(1,parseInt(raw.capacity||100,10)), unit:raw.unit==='lbs'?'lbs':'kg', color:raw.color||'#b0bec5', rotation:((Number(raw.rotation)%360)+360)%360 }; }
  function rect(s){ return {w:s.width*pxPerMeter,h:s.length*pxPerMeter}; }
  function aabb(s){ const r=rect(s); const rad=(s.rotation||0)*Math.PI/180; const cw=Math.abs(Math.cos(rad)), sw=Math.abs(Math.sin(rad)); return {w:(r.w*cw+r.h*sw), h:(r.w*sw+r.h*cw)}; }
  function shelfById(id){ return shelves.find(s=>s.id===id); }
  function persistLocal(){
    try{ localStorage.setItem(localKey, JSON.stringify({shelves,pxPerMeter,updatedAt:new Date().toISOString()})); }catch(e){}
  }
  function loadLocal(){
    try{
      const raw=localStorage.getItem(localKey);
      if(!raw) return null;
      const parsed=JSON.parse(raw);
      if(parsed && Array.isArray(parsed.shelves) && parsed.shelves.length){
        return parsed.shelves.map(normalize);
      }
    }catch(e){}
    return null;
  }

  function updateActionLinks(shelf){
    document.getElementById('cfgAddItem').href='add_product.php?shelf_filter='+encodeURIComponent(shelf.id);
    document.getElementById('cfgMoveItem').href='add_movement.php?shelf_filter='+encodeURIComponent(shelf.id);
    document.getElementById('cfgViewItems').href='product.php?shelf_filter='+encodeURIComponent(shelf.id);
  }

  function syncEl(el, shelf){
    const r=rect(shelf);
    el.style.left=shelf.x+'px'; el.style.top=shelf.y+'px'; el.style.width=r.w+'px'; el.style.height=r.h+'px'; el.style.background=shelf.color;
    el.style.transformOrigin='center center';
    el.style.transform=`rotate(${shelf.rotation||0}deg)`;
    el.title=`${shelf.id} | ${shelf.width}x${shelf.length}x${shelf.depth} ${shelf.unit} | Rot:${Math.round(shelf.rotation||0)}° | Niveles:${shelf.levels} | Cap:${shelf.capacity} ${shelf.unit}`;
    el.querySelector('.label').textContent=shelf.id;
  }

  function clampShelf(shelf){
    const box=aabb(shelf);
    const r=rect(shelf);
    const dx=(box.w-r.w)/2, dy=(box.h-r.h)/2;
    const minX=-dx, minY=-dy;
    const maxX=stage.clientWidth-r.w+dx, maxY=stage.clientHeight-r.h+dy;
    shelf.x=Math.max(minX,Math.min(maxX,shelf.x));
    shelf.y=Math.max(minY,Math.min(maxY,shelf.y));
  }

  function buildShelfEl(shelf){
    const el=document.createElement('div');
    el.className='shelf-item'+(selectedId===shelf.id?' selected':'');
    el.dataset.id=shelf.id;
    el.innerHTML='<span class="label"></span><span class="resize-handle nw" data-handle="nw"></span><span class="resize-handle ne" data-handle="ne"></span><span class="resize-handle sw" data-handle="sw"></span><span class="resize-handle se" data-handle="se"></span><span class="rotate-handle" data-handle="rotate" title="Rotar"></span>';
    syncEl(el,shelf);

    el.addEventListener('pointerdown',(ev)=>{
      const target=ev.target;
      selectedId=shelf.id; highlightSelection();
      const stageRect=stage.getBoundingClientRect();
      const startX=ev.clientX-stageRect.left, startY=ev.clientY-stageRect.top;
      const baseRect=rect(shelf);
      const start={x:shelf.x,y:shelf.y,w:shelf.width,l:shelf.length,rotation:shelf.rotation,centerX:shelf.x+(baseRect.w/2),centerY:shelf.y+(baseRect.h/2)};
      const handle=target.dataset.handle||null;
      const dragType = handle==='rotate' ? 'rotate' : (handle ? 'resize' : 'move');
      dragState={id:shelf.id,type:dragType,handle,startX,startY,start,el,pointerId:ev.pointerId,moved:false,startTs:Date.now()};
      el.setPointerCapture(ev.pointerId);
      if(dragType==='rotate') el.classList.add('rotating');
      else if(dragType==='resize') el.classList.add('resizing');
      else el.classList.add('dragging');
      ev.preventDefault();
    });

    el.addEventListener('pointermove',(ev)=>{
      if(!dragState || dragState.id!==shelf.id || dragState.pointerId!==ev.pointerId) return;
      const stageRect=stage.getBoundingClientRect();
      const cx=ev.clientX-stageRect.left, cy=ev.clientY-stageRect.top;
      const dx=cx-dragState.startX, dy=cy-dragState.startY;
      if(Math.abs(dx)>4 || Math.abs(dy)>4) dragState.moved=true;

      if(dragState.type==='move'){
        shelf.x=Math.round(dragState.start.x+dx);
        shelf.y=Math.round(dragState.start.y+dy);
      }else if(dragState.type==='rotate'){
        const angleRad = Math.atan2(cy - dragState.start.centerY, cx - dragState.start.centerX);
        let angleDeg = (angleRad * 180 / Math.PI) + 90;
        if (ev.shiftKey) { angleDeg = Math.round(angleDeg / 15) * 15; }
        shelf.rotation = ((angleDeg % 360) + 360) % 360;
      }else{
        const mpp=1/pxPerMeter;
        const dir = dragState.handle;
        let w=dragState.start.w, l=dragState.start.l, x=dragState.start.x, y=dragState.start.y;

        const rad=(shelf.rotation||0)*Math.PI/180;
        const ux={x:Math.cos(rad), y:Math.sin(rad)};
        const uy={x:-Math.sin(rad), y:Math.cos(rad)};
        const projW=(dx*ux.x + dy*ux.y)*mpp;
        const projL=(dx*uy.x + dy*uy.y)*mpp;

        const dw = dir.includes('e') ? projW : -projW;
        const dl = dir.includes('s') ? projL : -projL;

        w=Math.max(0.2,dragState.start.w+dw);
        l=Math.max(0.2,dragState.start.l+dl);

        if(dir.includes('w')) { x=Math.round(dragState.start.x+dx); }
        if(dir.includes('n')) { y=Math.round(dragState.start.y+dy); }

        shelf.width=Number(w.toFixed(2));
        shelf.length=Number(l.toFixed(2));
        shelf.x=x; shelf.y=y;
      }
      clampShelf(shelf);
      syncEl(el,shelf);
    });

    el.addEventListener('pointerup',()=>{
      if(dragState && dragState.id===shelf.id){
        const wasTap = dragState.type==='move' && !dragState.moved && (Date.now()-dragState.startTs)<300;
        dragState=null;
        el.classList.remove('dragging','resizing','rotating');
        scheduleAutoSave();
        if(wasTap){ openConfig(shelf.id); }
      }
    });
    el.addEventListener('dblclick',(ev)=>{ ev.stopPropagation(); openConfig(shelf.id); });
    return el;
  }

  function highlightSelection(){
    stage.querySelectorAll('.shelf-item').forEach(n=>n.classList.toggle('selected',n.dataset.id===selectedId));
  }

  function render(){
    stage.innerHTML='';
    fixedZones.forEach(z=>{ const d=document.createElement('div'); d.className='fixed-zone'+(z.office?' fixed-office':''); d.style.left=z.x+'px'; d.style.top=z.y+'px'; d.style.width=z.w+'px'; d.style.height=z.h+'px'; if(z.borderOnly){d.style.background='transparent';d.style.border='3px solid rgba(0,0,0,.2)';} else d.textContent=z.label; stage.appendChild(d); });
    shelves.forEach(s=>stage.appendChild(buildShelfEl(s)));
    stage.classList.toggle('place-mode',addMode);
  }

  function openConfig(id){
    const shelf=shelfById(id); if(!shelf) return;
    selectedId=shelf.id; highlightSelection();
    document.getElementById('cfgShelfName').textContent=shelf.id;
    document.getElementById('cfgId').value=shelf.id;
    document.getElementById('cfgColor').value=shelf.color;
    document.getElementById('cfgWidth').value=shelf.width;
    document.getElementById('cfgLength').value=shelf.length;
    document.getElementById('cfgDepth').value=shelf.depth;
    document.getElementById('cfgLevels').value=shelf.levels;
    document.getElementById('cfgCapacity').value=shelf.capacity;
    document.getElementById('cfgUnit').value=shelf.unit;
    document.getElementById('cfgRotation').value=shelf.rotation;
    updateActionLinks(shelf);
    new bootstrap.Modal(document.getElementById('shelfConfigModal')).show();
  }

  function applyConfig(){
    const shelf=shelfById(selectedId); if(!shelf) return;
    const nextId=String(document.getElementById('cfgId').value||'').trim();
    if(!nextId) return msg('danger','ID obligatorio');
    if(nextId!==shelf.id && shelves.some(s=>s.id===nextId)) return msg('danger','ID existente');

    shelf.id=nextId;
    shelf.color=document.getElementById('cfgColor').value;
    shelf.width=Math.max(0.2,Number(document.getElementById('cfgWidth').value)||1);
    shelf.length=Math.max(0.2,Number(document.getElementById('cfgLength').value)||1);
    shelf.depth=Math.max(0.1,Number(document.getElementById('cfgDepth').value)||1);
    shelf.levels=Math.max(1,parseInt(document.getElementById('cfgLevels').value||1,10));
    shelf.capacity=Math.max(1,parseInt(document.getElementById('cfgCapacity').value||1,10));
    shelf.unit=document.getElementById('cfgUnit').value==='lbs'?'lbs':'kg';
    shelf.rotation=((Number(document.getElementById('cfgRotation').value)||0)%360+360)%360;
    selectedId=shelf.id; clampShelf(shelf); render(); updateActionLinks(shelf);
    scheduleAutoSave();
    msg('success','Anaquel actualizado');
  }

  async function loadLayout(){
    const localLayout = loadLocal();
    try{
      const res=await fetch(apiUrl+'?action=load',{credentials:'same-origin'});
      const json=await res.json();
      if(json && json.success && Array.isArray(json.layout?.shelves) && json.layout.shelves.length){
        shelves=json.layout.shelves.map(normalize);
      }else if(localLayout){
        shelves=localLayout;
      }else{
        shelves=defaultShelves.map(normalize);
      }
    }catch{
      shelves = localLayout || defaultShelves.map(normalize);
    }
    persistLocal();
    render();
  }

  async function saveLayout(silent=false){
    const payload={shelves,pxPerMeter,updatedAt:new Date().toISOString()};
    persistLocal();
    try{
      const res=await fetch(apiUrl+'?action=save',{method:'POST',credentials:'same-origin',headers:{'Content-Type':'application/json'},body:JSON.stringify(payload)});
      const json=await res.json();
      if(!json.success){ if(!silent) msg('warning',json.message||'Guardado local OK, servidor no disponible'); return false; }
      if(!silent) msg('success','Layout guardado');
      return true;
    }catch(e){
      if(!silent) msg('warning','Guardado local OK (sin persistencia en servidor).');
      return false;
    }
  }

  function scheduleAutoSave(){
    if(autoSaveTimer) clearTimeout(autoSaveTimer);
    autoSaveTimer=setTimeout(()=>saveLayout(true), 500);
  }

  function exportLayout(){
    const blob=new Blob([JSON.stringify({shelves,pxPerMeter,exportedAt:new Date().toISOString()},null,2)],{type:'application/json'});
    const url=URL.createObjectURL(blob); const a=document.createElement('a'); a.href=url; a.download='warehouse_layout.json'; document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
  }

  document.getElementById('btnAddShelf').addEventListener('click',()=>{ addMode=!addMode; render(); msg('info',addMode?'Haz clic en el mapa para ubicar el anaquel':'Modo agregar cancelado'); });
  stage.addEventListener('click',(ev)=>{
    if(!addMode) return;
    if(ev.target.closest('.shelf-item')) return;
    const id=prompt('ID del nuevo anaquel (ej. AA1):'); if(!id) return;
    if(shelves.some(s=>s.id.toLowerCase()===id.trim().toLowerCase())) return msg('danger','Ese ID ya existe');
    const r=stage.getBoundingClientRect();
    const shelf=normalize({id:id.trim(),x:Math.round(ev.clientX-r.left),y:Math.round(ev.clientY-r.top),width:2,length:2,depth:1,levels:3,capacity:500,unit:'kg',color:'#90a4ae',rotation:0});
    shelves.push(shelf); selectedId=shelf.id; addMode=false; render(); scheduleAutoSave(); openConfig(shelf.id);
  });

  const shelfModalEl = document.getElementById('shelfConfigModal');
  shelfModalEl.addEventListener('shown.bs.modal',()=>{ stage.style.pointerEvents='none'; });
  shelfModalEl.addEventListener('hidden.bs.modal',()=>{ stage.style.pointerEvents='auto'; });

  document.getElementById('btnApplyShelf').addEventListener('click',applyConfig);
  document.getElementById('btnSaveLayout').addEventListener('click',saveLayout);
  document.getElementById('btnExportLayout').addEventListener('click',exportLayout);
  document.getElementById('btnDeleteShelf').addEventListener('click',()=>{
    if(!selectedId) return;
    if(!confirm('¿Eliminar este anaquel?')) return;
    shelves=shelves.filter(s=>s.id!==selectedId); selectedId=null; render(); scheduleAutoSave(); bootstrap.Modal.getInstance(document.getElementById('shelfConfigModal'))?.hide();
  });

  loadLayout();
})();
</script>
