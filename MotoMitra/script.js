document.addEventListener("DOMContentLoaded", function() {
    
    // --- PART 1: MOBILE MENU LOGIC ---
    // This runs on every page that has the menu button
    const menuBtn = document.getElementById("menuBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    }

    // --- PART 2: INSPECTION FORM LOGIC ---
    // This checks if the form exists before running. 
    // Prevents crashes on the Home Page.
    const form = document.getElementById('inspectionForm');
    
    if (form) {
        (function () {
            const tableBody = document.querySelector('#inspectionsTable tbody');
            const emptyMsg = document.getElementById('emptyMsg');
            const searchInput = document.getElementById('search');
            const exportBtn = document.getElementById('exportBtn');
            const clearBtn = document.getElementById('clearBtn');
            const yearSpan = document.getElementById('year');
            const AUTO_FOCUS_KEY = 'motomitra_auto_focus';

            if(yearSpan) yearSpan.textContent = new Date().getFullYear();

            // storage helper
            const STORAGE_KEY = 'motomitra_inspections_v1';
            function load() {
                try {
                return JSON.parse(localStorage.getItem(STORAGE_KEY) || '[]');
                } catch (e) {
                return [];
                }
            }
            function save(list) { localStorage.setItem(STORAGE_KEY, JSON.stringify(list)); }

            // render
            function render(filter = '') {
                const data = load();
                const rows = data
                .map((r, idx) => ({ r, idx }))
                .filter(({ r }) => {
                    if (!filter) return true;
                    const q = filter.toLowerCase();
                    return (r.inspector + ' ' + r.location + ' ' + r.item + ' ' + r.notes + ' ' + r.status).toLowerCase().includes(q);
                });

                if(tableBody) {
                    tableBody.innerHTML = '';
                    if (rows.length === 0) {
                        if(emptyMsg) emptyMsg.style.display = 'block';
                    } else {
                        if(emptyMsg) emptyMsg.style.display = 'none';
                        rows.forEach(({ r, idx }, i) => {
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
                            <td>${i + 1}</td>
                            <td>${escapeHTML(r.inspector)}</td>
                            <td>${escapeHTML(r.location)}</td>
                            <td>${escapeHTML(r.item)}</td>
                            <td class="status ${statusClass(r.status)}">${escapeHTML(r.status)}</td>
                            <td>${escapeHTML(r.notes || '')}</td>
                            <td>${escapeHTML(r.date)} ${escapeHTML(r.time)}</td>
                            <td><button data-idx="${idx}" class="btn small remove">Delete</button></td>
                            `;
                            tableBody.appendChild(tr);
                        });
                    }
                }
            }

            function statusClass(s) {
                if (!s) return '';
                if (s.toLowerCase().includes('ok')) return 'status-ok';
                if (s.toLowerCase().includes('minor')) return 'status-minor';
                return 'status-major';
            }

            // escape to avoid simple HTML injection
            function escapeHTML(str) {
                if (!str) return '';
                return String(str).replace(/[&<>"']/g, function (m) {
                return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[m];
                });
            }

            // add entry
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const inspector = form.inspector.value.trim();
                const location = form.location.value.trim();
                const item = form.item.value.trim();
                const status = form.status.value;
                const notes = form.notes.value.trim();
                const date = form.date.value;
                const time = form.time.value;

                // minimal validation
                if (!inspector || !location || !item || !status || !date || !time) {
                alert('Please fill all required fields.');
                return;
                }

                const list = load();
                list.unshift({ inspector, location, item, status, notes, date, time, createdAt: Date.now() });
                save(list);
                form.reset();
                // set default date/time to now for convenience
                const now = new Date();
                form.date.value = now.toISOString().slice(0, 10);
                form.time.value = now.toTimeString().slice(0, 5);

                render(searchInput ? searchInput.value : '');

                // auto scroll if enabled
                const autoScroll = document.getElementById('autoScroll');
                if (autoScroll && autoScroll.checked) {
                    const firstRow = tableBody.querySelector('tr');
                    if (firstRow) firstRow.scrollIntoView({ behavior: 'smooth' });
                }
            });

            // delete using event delegation
            if(tableBody) {
                tableBody.addEventListener('click', function (e) {
                    if (e.target.matches('button.remove')) {
                        const idx = Number(e.target.dataset.idx);
                        const data = load();
                        data.splice(idx, 1);
                        save(data);
                        render(searchInput ? searchInput.value : '');
                    }
                });
            }

            // search
            if(searchInput) {
                searchInput.addEventListener('input', function () {
                    render(this.value);
                });
            }

            // export CSV
            if(exportBtn) {
                exportBtn.addEventListener('click', function () {
                    const data = load();
                    if (!data.length) { alert('No records to export.'); return; }

                    const headers = ['Inspector', 'Location', 'Item', 'Status', 'Notes', 'Date', 'Time', 'CreatedAt'];
                    const rows = data.map(r => [
                    quoteCSV(r.inspector), quoteCSV(r.location), quoteCSV(r.item),
                    quoteCSV(r.status), quoteCSV(r.notes || ''), quoteCSV(r.date), quoteCSV(r.time),
                    quoteCSV(new Date(r.createdAt).toISOString())
                    ].join(','));

                    const csv = [headers.join(','), ...rows].join('\n');
                    const blob = new Blob([csv], { type: 'text/csv' });
                    const url = URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url; a.download = `inspections_${new Date().toISOString().slice(0, 10)}.csv`;
                    document.body.appendChild(a); a.click(); a.remove(); URL.revokeObjectURL(url);
                });
            }

            // clear all
            if(clearBtn) {
                clearBtn.addEventListener('click', function () {
                    if (!confirm('Clear all inspection records? This cannot be undone.')) return;
                    localStorage.removeItem(STORAGE_KEY);
                    render('');
                });
            }

            function quoteCSV(v) {
                if (v == null) return '';
                return `"${String(v).replace(/"/g, '""')}"`;
            }

            // small helpers: set date/time to now on load
            function setNowToForm() {
                const now = new Date();
                const d = now.toISOString().slice(0, 10);
                const t = now.toTimeString().slice(0, 5);
                if (form.date && !form.date.value) form.date.value = d;
                if (form.time && !form.time.value) form.time.value = t;
            }

            // on load restore autoFocus toggle from localStorage
            const autoCheckbox = document.getElementById('autoScroll');
            if(autoCheckbox) {
                try {
                    const v = localStorage.getItem(AUTO_FOCUS_KEY);
                    autoCheckbox.checked = v === '1';
                } catch (e) { }
                autoCheckbox.addEventListener('change', function () {
                    localStorage.setItem(AUTO_FOCUS_KEY, this.checked ? '1' : '0');
                });
            }

            // simple init
            setNowToForm();
            render('');
            // expose small debug
            window.motomitra = { load, save, render };

        })();
    }
});