<?php
session_start();
require_once __DIR__ . '/includes/api.php';

$pageTitle = 'Peta Resiko DBD';
$currentMenu = 'titik';

// Ambil level dari URL (jika ada)
$level = $_GET['level'] ?? '';
$endpoint = $level ? "/titik-risiko/level/" . strtolower($level) : "/titik-risiko";

// Ambil data titik risiko berdasarkan endpoint
$apiResponse = api_get($endpoint);
$dataTitik = $apiResponse['success'] ? $apiResponse['data'] : [];

$extraHead = '
<style>
.map-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2rem;
}
.map-page-title h1 {
    font-size: 2.2rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}
.map-page-title p {
    font-size: 1.1rem;
    color: var(--text-main);
}
.map-header-img {
    height: 100px;
    width: auto;
}

.map-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 2rem;
    align-items: start;
}

@media (max-width: 1024px) {
    .map-layout {
        grid-template-columns: 1fr;
    }
    .map-header-img {
        display: none;
    }
}

.map-wrapper {
    background: white;
    padding: 1rem;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
    border: 1px solid rgba(0,0,0,0.05);
}

#mainMap {
    height: 600px;
    width: 100%;
    border-radius: var(--radius-lg);
    z-index: 1;
}

.legend-card {
    margin-bottom: 1.5rem;
    padding: 2rem;
    border-radius: var(--radius-xl);
}

.legend-title {
    text-align: center;
    font-size: 1.25rem;
    color: var(--text-main);
    margin-bottom: 1.5rem;
}

.legend-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.legend-dot {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    flex-shrink: 0;
}

.legend-text {
    line-height: 1.2;
}
.legend-text strong {
    font-size: 1.1rem;
    color: var(--text-main);
    font-family: \'Outfit\', sans-serif;
}
.legend-text small {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.instruction-banner {
    background: var(--primary-light);
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: var(--radius-lg);
    border: 1px solid #d1e7dd;
}

/* Kustomisasi Popup Leaflet */
.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.leaflet-popup-content {
    margin: 15px;
    text-align: center;
}

/* Regional Filter Layout */
.filter-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.2rem;
    align-items: flex-end;
}
.filter-form > .form-group {
    min-width: 0;
}
.filter-form select.form-control {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}
.filter-actions {
    display: flex;
    gap: 0.5rem;
    align-items: flex-end;
}
@media (max-width: 640px) {
    .filter-form {
        grid-template-columns: 1fr;
    }
}
.search-result-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}
</style>
';

include 'includes/header.php';
?>

<div class="map-page-header animate-fade-in" style="margin-bottom: 1rem;">
    <div class="map-page-title">
        <h1>Peta Resiko DBD <?= $level ? '('.ucfirst($level).')' : '' ?></h1>
        <p>Lihat sebaran resiko DBD di wilayah Anda.</p>
    </div>
    <img src="assets/img/hero_house.png" alt="Ilustrasi" class="map-header-img" onerror="this.style.display='none'">
</div>

<div style="margin-bottom: 1.5rem;" class="animate-fade-in">
    <a href="index.php" class="btn" style="background: white; border: 1px solid #e2e8f0; color: var(--text-muted);"><i class="ph-bold ph-arrow-left"></i> Kembali ke Beranda</a>
</div>

<!-- Filter Wilayah Card -->
<div class="glass-card animate-fade-in" style="margin-bottom: 1.5rem; padding: 1.5rem; border-radius: var(--radius);">
    <h3 style="font-size: 1.1rem; margin-bottom: 1rem; color: var(--green-dark); display: flex; align-items: center; gap: 0.5rem;">
        <i class="ph-bold ph-funnel" style="font-size: 1.2rem;"></i> Filter Pencarian Wilayah
    </h3>
    <form id="filterForm" class="filter-form">
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="filterProvinsi">Provinsi</label>
            <select id="filterProvinsi" name="provinsi" class="form-control">
                <option value="">Semua Provinsi</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="filterKabupaten">Kabupaten/Kota</label>
            <select id="filterKabupaten" name="kabupaten_kota" class="form-control" disabled>
                <option value="">Semua Kabupaten/Kota</option>
            </select>
        </div>
        <div class="form-group" style="margin-bottom: 0;">
            <label class="form-label" for="filterKecamatan">Kecamatan</label>
            <select id="filterKecamatan" name="kecamatan" class="form-control" disabled>
                <option value="">Semua Kecamatan</option>
            </select>
        </div>
        <div class="filter-actions">
            <button type="submit" class="btn btn-primary" style="flex: 1; height: 38px;">
                <i class="ph-bold ph-magnifying-glass"></i> Cari
            </button>
            <button type="button" id="resetBtn" class="btn" style="background: #e2e8f0; color: var(--text-dark); flex: 1; height: 38px;">
                Reset
            </button>
        </div>
    </form>
</div>

<div class="map-layout animate-fade-in delay-1">
    <div class="map-wrapper">
        <div id="mainMap"></div>
    </div>

    <div class="map-sidebar">
        
        <div class="glass-card legend-card">
            <h3 class="legend-title">Keterangan Resiko</h3>
            <ul class="legend-list">
                <li class="legend-item">
                    <span class="legend-dot" style="background: #22c55e;"></span>
                    <div class="legend-text">
                        <strong style="color: #166534;">Resiko Rendah</strong><br>
                        <small>Aman</small>
                    </div>
                </li>
                <li class="legend-item">
                    <span class="legend-dot" style="background: #eab308;"></span>
                    <div class="legend-text">
                        <strong style="color: #ca8a04;">Resiko Sedang</strong><br>
                        <small>Waspada</small>
                    </div>
                </li>
                <li class="legend-item">
                    <span class="legend-dot" style="background: #ef4444;"></span>
                    <div class="legend-text">
                        <strong style="color: #dc2626;">Resiko Tinggi</strong><br>
                        <small>Bahaya</small>
                    </div>
                </li>
            </ul>
        </div>

        <div class="instruction-banner">
            <i class="ph-bold ph-info" style="font-size: 2.5rem; color: var(--green-dark);"></i>
            <p style="font-size: 0.95rem; font-weight: 600; color: var(--green-dark); margin: 0; line-height: 1.4;">
                Klik pada titik peta untuk melihat detail informasi wilayah.
            </p>
        </div>

    </div>
</div>

<!-- Hasil Pencarian -->
<div id="searchResultsSection" class="glass-card animate-fade-in" style="margin-top: 1.5rem; display: none;">
    <h3 style="font-size: 1.25rem; margin-bottom: 1.25rem; color: var(--green-dark); border-bottom: 2px solid #e2e8f0; padding-bottom: 0.5rem; display: flex; justify-content: space-between; align-items: center;">
        <span><i class="ph-bold ph-map-trifold" style="color: var(--green-mid);"></i> Hasil Pencarian Wilayah (<span id="resultsCount">0</span> Lokasi)</span>
        <button type="button" id="closeResultsBtn" style="background:none; border:none; cursor:pointer; color:var(--text-muted); font-size:1.2rem; display: flex; align-items: center; justify-content: center;"><i class="ph-bold ph-x"></i></button>
    </h3>
    <div id="resultsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1rem;">
        <!-- Card items will be inserted here dynamically -->
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Inisialisasi Peta
    const map = L.map("mainMap").setView([-6.914744, 107.609810], 12); 
    L.tileLayer("https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png", {
        attribution: "&copy; OpenStreetMap &copy; CARTO"
    }).addTo(map);

    const colors = { "rendah": "#22c55e", "sedang": "#eab308", "tinggi": "#ef4444" };
    let activeMarkers = [];
    let markersMap = {};

    function renderMarkersAndList(data, isSearching = false) {
        // Clear existing markers
        activeMarkers.forEach(m => map.removeLayer(m));
        activeMarkers = [];
        markersMap = {};

        const validMarkers = [];

        data.forEach(t => {
            if(t.latitude && t.longitude) {
                let lvl = (t.level_risiko_awal || 'rendah').toLowerCase();
                let color = colors[lvl] || "#64748b";
                
                let markerHtml = `<div style="background-color: ${color}; width: 28px; height: 28px; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 8px rgba(0,0,0,0.3);"></div>`;
                
                let customIcon = L.divIcon({
                    className: "custom-div-icon",
                    html: markerHtml,
                    iconSize: [28, 28],
                    iconAnchor: [14, 14]
                });
                
                let badgeBg = lvl === 'tinggi' ? '#fee2e2' : (lvl === 'sedang' ? '#fef9c3' : '#dcfce7');
                let badgeColor = lvl === 'tinggi' ? '#dc2626' : (lvl === 'sedang' ? '#ca8a04' : '#166534');
                let txtResiko = lvl.charAt(0).toUpperCase() + lvl.slice(1);

                let popupContent = `
                    <div style="min-width: 180px; padding: 5px;">
                        ${lvl === 'tinggi' ? '<div style="text-align:center; margin-bottom:5px;"><i class="ph-fill ph-warning" style="color:#ef4444; font-size:2rem;"></i></div>' : ''}
                        <h4 style="margin: 0 0 5px 0; font-family: 'Outfit', sans-serif; font-size:1.1rem; color:#0f172a;">${t.nama_titik}</h4>
                        <div style="display:inline-block; padding: 3px 8px; background:${badgeBg}; color:${badgeColor}; border-radius:20px; font-size:0.75rem; font-weight:700; margin-bottom: 12px;">
                            Resiko ${txtResiko}
                        </div>
                        <div style="text-align:center;">
                            <a href="detail.php?id=${t.id}" style="display: inline-block; width: 100%; padding: 8px 0; background: transparent; color: #0f172a; border: 1px solid #cbd5e1; border-radius: 20px; text-decoration: none; font-size: 0.85rem; font-weight: 600; transition: background 0.2s;">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                `;
                
                let marker = L.marker([t.latitude, t.longitude], {icon: customIcon})
                    .addTo(map)
                    .bindPopup(popupContent);
                
                activeMarkers.push(marker);
                markersMap[t.id] = marker;
                validMarkers.push([t.latitude, t.longitude]);
            }
        });

        // Fit bounds if there are markers
        if (validMarkers.length > 0) {
            let bounds = L.latLngBounds(validMarkers);
            map.fitBounds(bounds, {padding: [50, 50]});
        }

        // Render search results
        const searchResultsSection = document.getElementById("searchResultsSection");
        const resultsGrid = document.getElementById("resultsGrid");
        const resultsCount = document.getElementById("resultsCount");

        if (isSearching) {
            searchResultsSection.style.display = "block";
            resultsCount.textContent = data.length;
            resultsGrid.innerHTML = "";

            if (data.length === 0) {
                resultsGrid.innerHTML = `
                    <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: var(--radius); border: 1px dashed #cbd5e1;">
                        <i class="ph-thin ph-map-pin" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 0.5rem; display: block; margin-left: auto; margin-right: auto;"></i>
                        <p style="color: var(--text-muted); margin: 0;">Tidak ada lokasi risiko yang ditemukan untuk filter wilayah ini.</p>
                    </div>
                `;
            } else {
                data.forEach(t => {
                    let lvl = (t.level_risiko_awal || 'rendah').toLowerCase();
                    const badgeClass = lvl === 'tinggi' ? 'badge-tinggi' : (lvl === 'sedang' ? 'badge-sedang' : 'badge-rendah');
                    const txtResiko = lvl.charAt(0).toUpperCase() + lvl.slice(1);
                    
                    let card = document.createElement("div");
                    card.className = "glass-card search-result-card";
                    card.style.padding = "1rem";
                    card.style.display = "flex";
                    card.style.flexDirection = "column";
                    card.style.justifyContent = "space-between";
                    card.style.borderRadius = "var(--radius)";
                    card.style.border = "1px solid rgba(0,0,0,0.06)";
                    card.style.background = "white";
                    card.style.transition = "box-shadow 0.2s, transform 0.2s";
                    
                    card.innerHTML = `
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                                <h4 style="font-size: 1rem; font-family: 'Outfit', sans-serif; color: var(--green-dark); font-weight: 700; margin: 0;">${t.nama_titik}</h4>
                                <span class="badge ${badgeClass}">Resiko ${txtResiko}</span>
                            </div>
                            <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 0.5rem; display: flex; align-items: flex-start; gap: 0.25rem;">
                                <i class="ph-bold ph-map-pin" style="margin-top: 2px; color: var(--green-dark); font-size: 1rem;"></i>
                                <span>${t.alamat || ''}, RT/RW ${t.rt_rw || ''}, Kec. ${t.kecamatan || ''}, ${t.kabupaten_kota || ''}</span>
                            </p>
                        </div>
                        <div style="display: flex; gap: 0.5rem; margin-top: 0.75rem;">
                            <button class="btn btn-focus-map" data-id="${t.id}" data-lat="${t.latitude}" data-lng="${t.longitude}" style="flex: 1; padding: 0.4rem; font-size: 0.75rem; background: #e0f2fe; color: #0369a1; border-radius: var(--radius-sm); border: none; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 0.25rem; cursor: pointer;">
                                <i class="ph-bold ph-compass"></i> Fokus Peta
                            </button>
                            <a href="detail.php?id=${t.id}" class="btn" style="flex: 1; padding: 0.4rem; font-size: 0.75rem; background: var(--green-light); color: var(--green-dark); border-radius: var(--radius-sm); font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 0.25rem;">
                                <i class="ph-bold ph-eye"></i> Detail
                            </a>
                        </div>
                    `;
                    resultsGrid.appendChild(card);
                });

                // Attach event listener for Focus Map buttons
                resultsGrid.querySelectorAll(".btn-focus-map").forEach(btn => {
                    btn.addEventListener("click", function() {
                        const id = this.getAttribute("data-id");
                        const lat = parseFloat(this.getAttribute("data-lat"));
                        const lng = parseFloat(this.getAttribute("data-lng"));
                        if (lat && lng) {
                            map.flyTo([lat, lng], 15, { duration: 1.5 });
                            const marker = markersMap[id];
                            if (marker) {
                                marker.openPopup();
                            }
                        }
                    });
                });
            }
        } else {
            searchResultsSection.style.display = "none";
        }
    }

    // Initial render
    const initialData = <?= json_encode($dataTitik) ?>;
    renderMarkersAndList(initialData, false);

    // API Integration
    const apiBaseUrl = '<?= API_BASE_URL ?>';
    const provSelect = document.getElementById("filterProvinsi");
    const kabSelect = document.getElementById("filterKabupaten");
    const kecSelect = document.getElementById("filterKecamatan");
    const filterForm = document.getElementById("filterForm");
    const resetBtn = document.getElementById("resetBtn");

    // Load Provinces
    fetch(`${apiBaseUrl}/provinsi`)
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success' && Array.isArray(res.data)) {
                res.data.forEach(prov => {
                    let opt = document.createElement("option");
                    opt.value = prov.id;
                    opt.setAttribute("data-name", prov.name);
                    opt.textContent = prov.name;
                    provSelect.appendChild(opt);
                });
            }
        })
        .catch(err => console.error("Error loading provinces:", err));

    // Province Selection Change
    provSelect.addEventListener("change", function() {
        kabSelect.innerHTML = '<option value="">Semua Kabupaten/Kota</option>';
        kabSelect.disabled = true;
        kecSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
        kecSelect.disabled = true;

        const provId = this.value;
        if (!provId) return;

        fetch(`${apiBaseUrl}/kabupaten/${provId}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success' && Array.isArray(res.data)) {
                    res.data.forEach(kab => {
                        let opt = document.createElement("option");
                        opt.value = kab.id;
                        opt.setAttribute("data-name", kab.name);
                        opt.textContent = kab.name;
                        kabSelect.appendChild(opt);
                    });
                    kabSelect.disabled = false;
                }
            })
            .catch(err => console.error("Error loading kabupaten:", err));
    });

    // Kabupaten Selection Change
    kabSelect.addEventListener("change", function() {
        kecSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
        kecSelect.disabled = true;

        const kabId = this.value;
        if (!kabId) return;

        fetch(`${apiBaseUrl}/kecamatan/${kabId}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success' && Array.isArray(res.data)) {
                    res.data.forEach(kec => {
                        let opt = document.createElement("option");
                        opt.value = kec.id;
                        opt.setAttribute("data-name", kec.name);
                        opt.textContent = kec.name;
                        kecSelect.appendChild(opt);
                    });
                    kecSelect.disabled = false;
                }
            })
            .catch(err => console.error("Error loading kecamatan:", err));
    });

    // Form Submit (Filter)
    filterForm.addEventListener("submit", function(e) {
        e.preventDefault();

        // Get names from selected option data attributes
        const selectedProvOpt = provSelect.options[provSelect.selectedIndex];
        const selectedKabOpt = kabSelect.options[kabSelect.selectedIndex];
        const selectedKecOpt = kecSelect.options[kecSelect.selectedIndex];

        const provName = selectedProvOpt ? selectedProvOpt.getAttribute("data-name") || '' : '';
        const kabName = selectedKabOpt ? selectedKabOpt.getAttribute("data-name") || '' : '';
        const kecName = selectedKecOpt ? selectedKecOpt.getAttribute("data-name") || '' : '';

        // Build query string
        const params = new URLSearchParams();
        if (provName) params.append("provinsi", provName);
        if (kabName) params.append("kabupaten_kota", kabName);
        if (kecName) params.append("kecamatan", kecName);

        fetch(`${apiBaseUrl}/titik-risiko?${params.toString()}`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success' && Array.isArray(res.data)) {
                    renderMarkersAndList(res.data, true);
                }
            })
            .catch(err => console.error("Error filtering locations:", err));
    });

    // Reset Button
    resetBtn.addEventListener("click", function() {
        provSelect.value = "";
        kabSelect.innerHTML = '<option value="">Semua Kabupaten/Kota</option>';
        kabSelect.disabled = true;
        kecSelect.innerHTML = '<option value="">Semua Kecamatan</option>';
        kecSelect.disabled = true;

        renderMarkersAndList(initialData, false);
    });

    // Close Results Button
    document.getElementById("closeResultsBtn").addEventListener("click", function() {
        document.getElementById("searchResultsSection").style.display = "none";
    });
});
</script>

<?php include 'includes/footer.php'; ?>