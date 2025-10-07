
<?php require_once 'includes/config.php'; ?>  

<?php


?>
<!DOCTYPE html>
    <html lang="en">

        <?php require_once 'includes/head.php'; ?>  
    
 <head>
    <style>
:root {
    --base-font-size: 16px;
    --heading-font-size: 18px;
}

body.custom-font-size {
    font-size: var(--base-font-size);
}

body.custom-font-size h1, 
body.custom-font-size h2, 
body.custom-font-size h3, 
body.custom-font-size h4, 
body.custom-font-size h5, 
body.custom-font-size h6 {
    font-size: var(--heading-font-size);
}

.topbar, 
.navbar-custom {
    z-index: 200001 !important;
    position: relative; /* ensure stacking context */
}
/* drag handle bar */
#info-panel .drag-handle {
  width: 60px;
  height: 6px;
  background: #fff;
  border-radius: 3px;
  margin: 8px auto;
  cursor: grab;
}


.profile-dropdown,
.profile-dropdown .dropdown-menu {
    z-index: 200000 !important; /* way higher than Leaflet */
    position: absolute !important;
}

/* Font size settings panel */
#font-size-settings {
    position: fixed;
    right: 20px;
    bottom: 140px;
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    z-index: 1000;
    width: 260px;
    display: none;
}

#font-size-settings h4 {
    font-size: 16px;
    margin-bottom: 10px;
    color: #333;
}

#font-size-settings .font-control {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

#font-size-settings label {
    flex: 1;
    margin-right: 10px;
    color: #555;
}

#font-size-settings input[type="range"] {
    flex: 1.5;
}

#info-panel {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100vw;
  background: #DE28A6;
  color: #fff;
  z-index: 2000;
  padding: 16px;
  box-shadow: 0 -3px 10px rgba(0,0,0,0.3);
  border-radius: 16px 16px 0 0;
  font-family: "Segoe UI", sans-serif;
  transform: translateY(90%); /* default hidden */
  transition: transform 0.2s ease-out;
  max-height: 60vh;
  overflow-y: auto;
  touch-action: none; /* importante para sa mobile drag */
}
#info-panel.open {
  transform: translateY(0); /* Show panel */
}

#info-panel .toggle-btn {
  width: 50px;
  height: 6px;
  background: #fff;
  border-radius: 3px;
  margin: 8px auto;
  cursor: pointer;
}
#info-panel .info-header {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 12px;
}

#info-panel .info-logo {
  width: 32px;
  height: 32px;
}

#info-panel h5 {
  font-size: var(--heading-font-size);
  font-weight: 600;
}

#info-panel .info-fields {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 8px;
  margin-bottom: 12px;
}

#info-panel .info-card {
  background: #9C2377;
  padding: 8px 12px;
  border-radius: 8px;
  text-align: center;
  font-size: calc(var(--base-font-size) - 2px);
}

#info-panel .info-card strong {
  display: block;
  font-size: calc(var(--base-font-size) - 4px);
  color: #f8dfff;
}

#info-panel .info-card span {
  font-size: calc(var(--base-font-size) - 1px);
  font-weight: bold;
  color: #fff;
}

#info-panel .btn-clear {
  display: block;
  width: 100%;
  background: white;
  color: #DE28A6;
  font-weight: bold;
  border: none;
  padding: 10px;
  border-radius: 10px;
  transition: 0.2s ease;
  cursor: pointer;
}

#info-panel .btn-clear:hover {
  background: #f7f7f7;
}
</style>

    <!-- Other meta & css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

    <body class="loading" data-layout-color="light" data-leftbar-theme="light" data-layout-mode="fluid" data-rightbar-onstart="true">
        <!-- Begin page -->
        <div class="wrapper">
            <?php require_once 'includes/sidebar.php'; ?>  
            <?php require_once 'includes/topbar.php'; ?>  
        <button id="nearby-btn" style="position:fixed; top:90px; left:50px; z-index:3; background:#DE28A6; color:#fff; border:none; border-radius:8px; padding:10px 18px; font-weight:bold; box-shadow:0 2px 8px rgba(0,0,0,0.15); cursor:pointer;">
                <i class="fa fa-location-arrow"></i> Nearby Terminals
            </button>
            <button id="center-location-btn" style="position:fixed; bottom:80px; right:20px; z-index:3; background:#DE28A6; color:#fff; border:none; border-radius:50%; width:50px; height:50px; font-size:20px; box-shadow:0 2px 8px rgba(0,0,0,0.15); cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <i id="center-icon" class="fa fa-location-crosshairs"></i>
            </button>
            <button id="settings-btn" style="position:fixed; bottom:140px; right:20px; z-index:3; background:#DE28A6; color:#fff; border:none; border-radius:50%; width:50px; height:50px; font-size:20px; box-shadow:0 2px 8px rgba(0,0,0,0.15); cursor:pointer; display:flex; align-items:center; justify-content:center;">
                <i class="fa fa-gear"></i>
            </button>
            
            <!-- Font size settings panel -->
            <div id="font-size-settings">
                <h4><i class="fa fa-text-height"></i> Font Size Settings</h4>
                <div class="font-control">
                    <label for="base-font-size">Base Font Size:</label>
                    <input type="range" id="base-font-size" min="12" max="24" step="1" value="16">
                    <span id="base-font-value">16px</span>
                </div>
                <div class="font-control">
                    <label for="heading-font-size">Heading Size:</label>
                    <input type="range" id="heading-font-size" min="14" max="28" step="1" value="18">
                    <span id="heading-font-value">18px</span>
                </div>
                <button id="save-font-settings" style="background:#DE28A6; color:#fff; border:none; border-radius:5px; padding:6px 12px; width:100%; font-weight:bold; cursor:pointer;">Save Settings</button>
            </div>
            <div class="content-page" style="margin:0; padding:0;">
                <div class="content" style="margin:0; padding:0;">
                <div class="container-fluid" style="margin:0; padding:0;">
                <div class="row" style="margin:0; padding:0;"> 
                <div class="col-12" style="margin:0; padding:0;"> 
                    <div id="map" class="mt-5" style="height:100vh; width:100vw; position:fixed; top:0; left:0; z-index:1;"></div>
                    <!-- Bottom panel for terminal/destination info -->
        <!-- Bottom panel for terminal/destination info -->
<div id="info-panel">
  <div class="drag-handle"></div>
  <div class="info-header">
    <img src="assets/images/LakBayan Logo Transparent .png" alt="Terminal Icon" class="info-logo">
    <h5 class="m-0">Trip Information</h5>
  </div>
    <script>
const panel = document.getElementById("info-panel");
const handle = panel.querySelector(".drag-handle");

let startY = 0;
let currentY = 0;
let startTranslateY = 0; // store panel position before drag
let isDragging = false;

function getCurrentTranslateY() {
  let matrix = new WebKitCSSMatrix(window.getComputedStyle(panel).transform);
  return matrix.m42; // Y translation value
}

handle.addEventListener("mousedown", startDrag);
handle.addEventListener("touchstart", startDrag, { passive: true });

function startDrag(e) {
  isDragging = true;
  startY = e.touches ? e.touches[0].clientY : e.clientY;
  startTranslateY = getCurrentTranslateY(); // baseline
  panel.style.transition = "none";

  document.addEventListener("mousemove", drag);
  document.addEventListener("mouseup", endDrag);
  document.addEventListener("touchmove", drag, { passive: false });
  document.addEventListener("touchend", endDrag);
}

function drag(e) {
  if (!isDragging) return;
  currentY = e.touches ? e.touches[0].clientY : e.clientY;
  let diffY = currentY - startY;

  // combine start position + diff
  let newTranslateY = startTranslateY + diffY;

  // clamp (0 = open, 90% = closed)
  const maxTranslate = window.innerHeight * 0.9;
  if (newTranslateY < 0) newTranslateY = 0;
  if (newTranslateY > maxTranslate) newTranslateY = maxTranslate;

  panel.style.transform = `translateY(${newTranslateY}px)`;
  e.preventDefault(); // stop scroll habang drag
}

function endDrag() {
  isDragging = false;
  panel.style.transition = "transform 0.25s ease-out";

  let currentTranslateY = getCurrentTranslateY();
  const midpoint = window.innerHeight * 0.45; // decide open/close threshold

  if (currentTranslateY < midpoint) {
    // open
    panel.style.transform = "translateY(0)";
  } else {
    // close
    panel.style.transform = "translateY(90%)";
  }

  document.removeEventListener("mousemove", drag);
  document.removeEventListener("mouseup", endDrag);
  document.removeEventListener("touchmove", drag);
  document.removeEventListener("touchend", endDrag);
}

    </script>
    
    <div class="info-fields">
    <div class="info-card">
        <strong>Terminal</strong>
        <img id="terminal-image" src="assets/images/LakBayan Logo Transparent .png" alt="Terminal" style="max-width:60px; display:block; margin:5px auto;">
        <span id="selected-terminal">None</span>
    </div>
    <div class="info-card">
        <strong>Destination</strong>
        <span id="selected-destination">None</span>
    </div>
    <div class="info-card">
        <strong>Distance</strong>
        <span id="distance">-</span> km
    </div>
    <div class="info-card">
    <strong>Fare (₱11 base + ₱1/km, rounded up)</strong><br>
    ₱<span id="fare">-</span>
    </div>
    <div class="info-card">
        <strong>ETA</strong>
        <span id="eta">-</span> mins
    </div>

    </div>


    <button id="clear-btn" class="btn-clear">Clear</button>
    </div>


                </div>
                </div>
                </div>
                <!-- Leaflet CSS & JS -->
                <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
                <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
                <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                <script src="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
var userMarker = null;
var firstUpdate = true;
var userCircle = null;
var map;
var selectedTerminal = null;
var selectedDestination = null;
var destinationMarker = null;
var routingControl = null;
var isLocationLoading = true; // Track if location is being fetched
var hasLocation = false; // Track if location has been successfully obtained
var isFontSettingsOpen = false; // Track if font settings panel is open

// Initialize map when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    map = L.map('map').setView([13, 122], 6); // Default center (Philippines)

    // Base layers
    var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var satellite = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
        maxZoom: 19,
        attribution: '© Esri'
    });

    L.control.layers({ "OpenStreetMap": osm, "Satellite": satellite }).addTo(map);

    // Center location button
    document.getElementById('center-location-btn').addEventListener('click', function() {
        if (!hasLocation) {
            // If we don't have location yet, try to get it
            Swal.fire({
                title: 'Getting your location...',
                text: 'Please wait while we locate you.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            if (navigator.geolocation) {
                isLocationLoading = true;
                document.getElementById('center-icon').className = 'fa fa-spinner fa-spin';
                
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    
                    updateLocation(lat, lng);
                    map.setView([lat, lng], 16);
                    
                    Swal.close();
                    isLocationLoading = false;
                    hasLocation = true;
                    document.getElementById('center-icon').className = 'fa fa-check';
                }, 
                function(error) {
                    isLocationLoading = false;
                    Swal.fire('Error', 'Unable to get your location. Please check your location settings.', 'error');
                    document.getElementById('center-icon').className = 'fa fa-location-crosshairs';
                });
            } else {
                Swal.fire('Error', 'Geolocation is not supported by your browser.', 'error');
            }
        } else {
            // We already have location, just center the map
            if (userMarker) {
                map.setView(userMarker.getLatLng(), 16);
            }
        }
    });

    // Nearby button
    document.getElementById('nearby-btn').addEventListener('click', function () {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 15);

                if (userCircle) map.removeLayer(userCircle);

                userCircle = L.circle([lat, lng], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.2,
                    radius: 1000
                }).addTo(map);
            }, () => Swal.fire('Error', 'Unable to get your location.', 'error'));
        } else {
            Swal.fire('Error', 'Geolocation not supported.', 'error');
        }
    });

    // Tricycle icon
    var tricycleIcon = L.icon({
        iconUrl: 'assets/images/TRICYCLE ICON .png',
        iconSize: [32, 32],
        iconAnchor: [16, 32],
        popupAnchor: [0, -32]
    });

    // Fetch terminals
    fetch("get-terminals.php")
        .then(r => r.json())
        .then(result => {
            const terminals = Array.isArray(result.data)
                ? result.data
                : (result.data && Array.isArray(result.data.data) ? result.data.data : []);

            if (result.status === "success" && Array.isArray(terminals)) {
                terminals.forEach(terminal => {
                    const lat = parseFloat(terminal.latitude);
                    const lng = parseFloat(terminal.longitude);
                    const marker = L.marker([lat, lng], { icon: tricycleIcon })
                        .addTo(map)
                        .on('click', () => selectTerminal(terminal));
                });
            } else {
                console.error("Failed to load terminals:", result);
            }
        })
        .catch(err => console.error("Error fetching terminals:", err));

    // Start geolocation fallback (browser)
    if (navigator.geolocation) {
        console.log("🌍 Browser geolocation active");
        navigator.geolocation.watchPosition(function (position) {
            updateLocation(position.coords.latitude, position.coords.longitude);
        }, err => console.warn("Browser geolocation error:", err));
    } else {
        console.warn("No geolocation support detected.");
    }
    
    // Font size settings handlers
    initFontSizeSettings();
});

// Initialize font size settings
function initFontSizeSettings() {
    // Load saved font settings if available
    loadFontSettings();
    
    // Toggle font settings panel
    document.getElementById('settings-btn').addEventListener('click', function() {
        const panel = document.getElementById('font-size-settings');
        if (panel.style.display === 'block') {
            panel.style.display = 'none';
            isFontSettingsOpen = false;
        } else {
            panel.style.display = 'block';
            isFontSettingsOpen = true;
        }
    });
    
    // Update base font size display
    document.getElementById('base-font-size').addEventListener('input', function(e) {
        document.getElementById('base-font-value').textContent = e.target.value + 'px';
        updateFontSizePreview();
    });
    
    // Update heading font size display
    document.getElementById('heading-font-size').addEventListener('input', function(e) {
        document.getElementById('heading-font-value').textContent = e.target.value + 'px';
        updateFontSizePreview();
    });
    
    // Save font settings
    document.getElementById('save-font-settings').addEventListener('click', function() {
        saveFontSettings();
        applyFontSettings();
        document.getElementById('font-size-settings').style.display = 'none';
        isFontSettingsOpen = false;
        
        Swal.fire({
            title: 'Success!',
            text: 'Font size settings saved',
            icon: 'success',
            timer: 1500,
            showConfirmButton: false
        });
    });
}

// Update font size preview in real-time
function updateFontSizePreview() {
    const baseSize = document.getElementById('base-font-size').value + 'px';
    const headingSize = document.getElementById('heading-font-size').value + 'px';
    
    document.documentElement.style.setProperty('--base-font-size', baseSize);
    document.documentElement.style.setProperty('--heading-font-size', headingSize);
}

// Save font settings to localStorage
function saveFontSettings() {
    const settings = {
        baseSize: document.getElementById('base-font-size').value,
        headingSize: document.getElementById('heading-font-size').value
    };
    
    localStorage.setItem('fontSizeSettings', JSON.stringify(settings));
}

// Load font settings from localStorage
function loadFontSettings() {
    const savedSettings = localStorage.getItem('fontSizeSettings');
    
    if (savedSettings) {
        const settings = JSON.parse(savedSettings);
        
        document.getElementById('base-font-size').value = settings.baseSize;
        document.getElementById('heading-font-size').value = settings.headingSize;
        
        document.getElementById('base-font-value').textContent = settings.baseSize + 'px';
        document.getElementById('heading-font-value').textContent = settings.headingSize + 'px';
        
        // Apply saved settings
        applyFontSettings();
    } else {
        // Add CSS variables with default values
        document.documentElement.style.setProperty('--base-font-size', '16px');
        document.documentElement.style.setProperty('--heading-font-size', '18px');
    }
}

// Apply font settings to the page
function applyFontSettings() {
    const baseSize = document.getElementById('base-font-size').value + 'px';
    const headingSize = document.getElementById('heading-font-size').value + 'px';
    
    document.documentElement.style.setProperty('--base-font-size', baseSize);
    document.documentElement.style.setProperty('--heading-font-size', headingSize);
    
    // Add a class to the body to indicate custom fonts are applied
    document.body.classList.add('custom-font-size');
}

// Close settings panel when clicking elsewhere
document.addEventListener('click', function(event) {
    const settingsPanel = document.getElementById('font-size-settings');
    const settingsButton = document.getElementById('settings-btn');
    
    if (isFontSettingsOpen && 
        !settingsPanel.contains(event.target) && 
        event.target !== settingsButton && 
        !settingsButton.contains(event.target)) {
        settingsPanel.style.display = 'none';
        isFontSettingsOpen = false;
    }
});

// ✅ Function called by the MIT App (EvaluateJavaScript)
function updateLocation(lat, lng) {
    console.log("📍 Received location:", lat, lng);

    if (!map) return;

    if (!userMarker) {
        userMarker = L.marker([lat, lng], {
            icon: L.icon({
                iconUrl: "https://cdn-icons-png.flaticon.com/512/64/64113.png",
                iconSize: [20, 20],
                iconAnchor: [10, 10]
            })
        })
            .addTo(map)
            .bindTooltip("You are here", {
                permanent: true,
                direction: "top",
                offset: [0, -10]
            })
            .openTooltip();
    } else {
        userMarker.setLatLng([lat, lng]);
    }

    // Update the center button icon when we get location
    if (isLocationLoading) {
        isLocationLoading = false;
        hasLocation = true;
        document.getElementById('center-icon').className = 'fa fa-check';
        
        // After 2 seconds, change to the normal icon
        setTimeout(() => {
            document.getElementById('center-icon').className = 'fa fa-location-crosshairs';
        }, 2000);
    }

    if (firstUpdate) {
        map.setView([lat, lng], 15);
        firstUpdate = false;
    }
}

// ✅ Select Terminal logic
function selectTerminal(terminal) {
    Swal.fire({
        title: terminal.name,
        html: `
            <img src="${terminal.image}" alt="Terminal Image" style="max-width:300px;display:block;margin:10px auto;">
            <button id="view-360-btn" style="background:#4285F4;color:#fff;border:none;border-radius:6px;padding:8px 16px;margin:10px auto;display:block;cursor:pointer;">
                <i class="fa fa-street-view"></i> View 360
            </button>
        `,
        showCancelButton: true,
        confirmButtonText: 'Select',
        cancelButtonText: 'Cancel',
        icon: 'info',
        didOpen: () => {
            document.getElementById('view-360-btn').onclick = () => {
                const lat = terminal.latitude;
                const lng = terminal.longitude;
                const url = `https://www.google.com/maps/@?api=1&map_action=pano&viewpoint=${lat},${lng}`;
                window.open(url, '_blank');
            };
        }
    }).then(result => {
        if (result.isConfirmed) {
            selectedTerminal = terminal;
            document.getElementById('selected-terminal').textContent = terminal.name;
            document.getElementById('terminal-image').src = terminal.image;
            Swal.fire('Select Destination', 'Click anywhere on the map to set your destination.', 'info');
            enableDestinationSelection();
        }
    });
}

// ✅ Destination selection
function enableDestinationSelection() {
    map.once('click', async function (e) {
        if (destinationMarker) map.removeLayer(destinationMarker);
        selectedDestination = { lat: e.latlng.lat, lng: e.latlng.lng };
        destinationMarker = L.marker([selectedDestination.lat, selectedDestination.lng])
            .addTo(map)
            .bindPopup("Destination")
            .openPopup();

        try {
            const url = `reverse-geocode.php?lat=${selectedDestination.lat}&lon=${selectedDestination.lng}`;
            const res = await fetch(url);
            const data = await res.json();
            let address = '';
            if (data && data.address) {
                address = [
                    data.address.suburb || data.address.village || '',
                    data.address.road || '',
                    data.address.city || data.address.town || '',
                    data.address.state || '',
                    data.address.country || ''
                ].filter(Boolean).join(', ');
            }
            if (!address) address = data.display_name || '';
            document.getElementById('selected-destination').textContent = address || `${selectedDestination.lat.toFixed(5)}, ${selectedDestination.lng.toFixed(5)}`;
        } catch {
            document.getElementById('selected-destination').textContent =
                `${selectedDestination.lat.toFixed(5)}, ${selectedDestination.lng.toFixed(5)}`;
        }

        routeAndCalculate();
    });
}

// ✅ Routing & Calculation
function routeAndCalculate() {
    if (!selectedTerminal || !selectedDestination) return;
    if (routingControl) map.removeControl(routingControl);

    routingControl = L.Routing.control({
        waypoints: [
            L.latLng(selectedTerminal.latitude, selectedTerminal.longitude),
            L.latLng(selectedDestination.lat, selectedDestination.lng)
        ],
        routeWhileDragging: false,
        addWaypoints: false,
        draggableWaypoints: false,
        fitSelectedRoutes: true,
        lineOptions: { styles: [{ color: 'blue', weight: 5 }] },
        router: new L.Routing.OSRMv1({
            serviceUrl: 'https://router.project-osrm.org/route/v1',
            profile: 'driving',
            alternatives: true
        })
    }).addTo(map);

    routingControl.on('routesfound', e => {
        if (window.altPolylines) window.altPolylines.forEach(pl => map.removeLayer(pl));
        window.altPolylines = [];
        e.routes.forEach((route, idx) => {
            const color = idx === 0 ? 'blue' : '#888';
            const poly = L.polyline(route.coordinates, {
                color, weight: 5, opacity: idx === 0 ? 1 : 0.7
            }).addTo(map);
            window.altPolylines.push(poly);
            if (idx === 0) updateInfo(route);
            poly.on('click', () => {
                window.altPolylines.forEach(pl => pl.setStyle({ color: '#888', opacity: 0.7 }));
                poly.setStyle({ color: 'blue', opacity: 1 });
                updateInfo(route);
            });
        });
    });
}

// ✅ Update info (distance, fare, ETA)
function updateInfo(route) {
    const distanceKm = Math.ceil(route.summary.totalDistance / 1000);
    const base = parseFloat(selectedTerminal.base_rate || 11);
    const perKm = parseFloat(selectedTerminal.per_km_rate || 1);
    const fare = base + (distanceKm * perKm);
    const eta = Math.ceil(route.summary.totalTime / 60);

    document.getElementById('distance').textContent = distanceKm;
    document.getElementById('fare').textContent = fare.toFixed(2);
    document.getElementById('eta').textContent = eta;
}

// ✅ Clear button
document.getElementById('clear-btn').addEventListener('click', function () {
    selectedTerminal = null;
    selectedDestination = null;
    document.getElementById('selected-terminal').textContent = 'None';
    document.getElementById('terminal-image').src = '';
    document.getElementById('selected-destination').textContent = 'None';
    document.getElementById('distance').textContent = '-';
    document.getElementById('fare').textContent = '-';
    document.getElementById('eta').textContent = '-';
    if (routingControl) map.removeControl(routingControl);
    if (window.altPolylines) window.altPolylines.forEach(pl => map.removeLayer(pl));
    if (destinationMarker) map.removeLayer(destinationMarker);
});
</script>


                </div>
            </div>
            <!-- End Page content -->
        </div>

        <!-- bundle -->
        <script src="assets/js/vendor.min.js"></script>
        <script src="assets/js/app.min.js"></script>

        <!-- third party js -->
        <script src="assets/js/vendor/apexcharts.min.js"></script>
        <script src="assets/js/vendor/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="assets/js/vendor/jquery-jvectormap-world-mill-en.js"></script>
        <!-- third party js ends -->

        <!-- end demo js-->
    </body>


<!-- /hyper/saas/index.html [XR&CO'2014], Fri, 29 Jul 2022 10:20:07 GMT -->
</html>