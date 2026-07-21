/* Data Recover Free — directory app.
 *
 * Loads web/data/software.json (the app's own versioned data file — no user
 * data ever leaves the browser), renders a searchable, filterable directory,
 * and wires the S2 File Identifier so a detected file type filters and
 * highlights the matching recovery tools.
 */
(function () {
  'use strict';

  /* Detected file extension -> directory category ids. */
  var EXT_TO_CATS = {
    doc: ['word'], docx: ['word'], rtf: ['word'],
    xls: ['excel'], xlsx: ['excel'],
    ppt: ['powerpoint'], pptx: ['powerpoint'],
    odt: ['openoffice'], ods: ['openoffice'], odp: ['openoffice'], odg: ['openoffice'],
    zip: ['zip'], jar: ['zip'], apk: ['zip'], epub: ['zip'],
    xml: ['xml']
  };

  var DATA = null;
  var state = {
    q: '',
    cats: {},        // category id -> true
    oses: {},        // os id -> true
    highlight: {}    // entry id -> true (identifier recommendations)
  };

  var $ = function (id) { return document.getElementById(id); };

  function esc(s) {
    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function labelOf(list, id) {
    for (var i = 0; i < list.length; i++) if (list[i].id === id) return list[i].label;
    return id;
  }

  function anyOn(obj) { for (var k in obj) if (obj[k]) return true; return false; }

  /* ------------------------------ filtering ------------------------------ */

  function matchesFilters(e) {
    if (anyOn(state.cats)) {
      var hit = false;
      for (var i = 0; i < e.categories.length; i++) if (state.cats[e.categories[i]]) hit = true;
      if (!hit) return false;
    }
    if (anyOn(state.oses)) {
      var ohit = false;
      for (var j = 0; j < e.os.length; j++) if (state.oses[e.os[j]]) ohit = true;
      if (!ohit) return false;
    }
    if (state.q) {
      var hay = (e.name + ' ' + e.description + ' ' + (e.tags || []).join(' ') + ' ' +
        (e.license || '')).toLowerCase();
      var terms = state.q.toLowerCase().split(/\s+/);
      for (var t = 0; t < terms.length; t++) {
        if (terms[t] && hay.indexOf(terms[t]) === -1) return false;
      }
    }
    return true;
  }

  /* ------------------------------ rendering ------------------------------ */

  function entryCard(e) {
    var el = document.createElement('article');
    el.className = 'entry card' + (state.highlight[e.id] ? ' recommended' : '');
    var badges = '';
    for (var i = 0; i < e.categories.length; i++) {
      badges += '<span class="badge">' + esc(labelOf(DATA.categories, e.categories[i])) + '</span>';
    }
    for (var j = 0; j < e.os.length; j++) {
      badges += '<span class="badge os">' + esc(labelOf(DATA.oses, e.os[j])) + '</span>';
    }
    el.innerHTML =
      (state.highlight[e.id] ? '<span class="rec-badge">&#9733; Recommended for your file</span>' : '') +
      '<h3><a href="' + esc(e.homepage) + '" target="_blank" rel="noopener">' + esc(e.name) + '</a></h3>' +
      '<div class="badges">' + badges + '</div>' +
      '<p class="desc">' + esc(e.description) + '</p>' +
      '<p class="meta">License: ' + esc(e.license || 'Unknown') + '</p>' +
      '<div class="actions">' +
        '<a href="' + esc(e.homepage) + '" target="_blank" rel="noopener">Open &#8599;</a>' +
        (e.source ? '<a href="' + esc(e.source) + '" target="_blank" rel="noopener">Source code</a>' : '') +
      '</div>';
    return el;
  }

  function render() {
    var grid = $('grid');
    grid.innerHTML = '';
    var shown = DATA.entries.filter(matchesFilters);
    // Recommended entries first, otherwise keep JSON order.
    shown.sort(function (a, b) {
      var ra = state.highlight[a.id] ? 0 : 1;
      var rb = state.highlight[b.id] ? 0 : 1;
      return ra - rb;
    });
    for (var i = 0; i < shown.length; i++) grid.appendChild(entryCard(shown[i]));
    $('count').textContent = shown.length + ' of ' + DATA.entries.length + ' tools shown';
    $('empty').className = shown.length ? '' : 'show';
    var filtered = anyOn(state.cats) || anyOn(state.oses) || !!state.q || anyOn(state.highlight);
    $('clear').className = filtered ? 'show' : '';
    syncChips();
  }

  function syncChips() {
    var chips = document.querySelectorAll('.chip[data-kind]');
    for (var i = 0; i < chips.length; i++) {
      var c = chips[i];
      var on = c.getAttribute('data-kind') === 'cat'
        ? !!state.cats[c.getAttribute('data-id')]
        : !!state.oses[c.getAttribute('data-id')];
      c.setAttribute('aria-pressed', on ? 'true' : 'false');
    }
  }

  function buildChips() {
    var mk = function (row, kind, item) {
      var b = document.createElement('button');
      b.type = 'button';
      b.className = 'chip';
      b.textContent = item.label;
      b.setAttribute('data-kind', kind);
      b.setAttribute('data-id', item.id);
      b.setAttribute('aria-pressed', 'false');
      b.addEventListener('click', function () {
        var set = kind === 'cat' ? state.cats : state.oses;
        set[item.id] = !set[item.id];
        render();
      });
      row.appendChild(b);
    };
    for (var i = 0; i < DATA.categories.length; i++) mk($('cat-chips'), 'cat', DATA.categories[i]);
    for (var j = 0; j < DATA.oses.length; j++) mk($('os-chips'), 'os', DATA.oses[j]);
  }

  function clearFilters() {
    state.q = '';
    state.cats = {};
    state.oses = {};
    state.highlight = {};
    $('search').value = '';
    $('identify-note').className = 'id-note';
    render();
  }

  /* --------------------------- identifier wiring --------------------------- */

  function applyIdentification(report) {
    // Collect every detected extension: the primary file plus any separated
    // foreign segments.
    var exts = [report.primary.ext];
    for (var i = 0; i < report.foreign.length; i++) exts.push(report.foreign[i].ext);

    state.cats = {};
    state.highlight = {};
    var catCount = 0;
    for (var e = 0; e < exts.length; e++) {
      var ext = exts[e];
      var cats = EXT_TO_CATS[ext] || [];
      for (var c = 0; c < cats.length; c++) {
        if (!state.cats[cats[c]]) { state.cats[cats[c]] = true; catCount++; }
      }
      // Highlight the S2 programs the identifier recommends for this type.
      var recs = window.S2FileID ? S2FileID.recommend(ext, 'datarecoverfree') : [];
      for (var r = 0; r < recs.length; r++) state.highlight[recs[r].key] = true;
    }
    // Unknown type: show universal tools instead of an empty filter.
    if (!catCount) {
      state.cats.universal = true;
      state.highlight.universal = true;
      state.highlight.filefixerbot = true;
    }

    var note = $('identify-note');
    note.innerHTML = 'Detected <strong>' + esc(report.primary.description) + '</strong>' +
      (report.foreign.length ? ' plus ' + report.foreign.length + ' embedded file(s) of other types' : '') +
      '. The directory below is now filtered to matching tools — recommended ones are starred. ' +
      '<a href="#" id="identify-reset">Show everything again</a>.';
    note.className = 'id-note show';
    document.getElementById('identify-reset').addEventListener('click', function (ev) {
      ev.preventDefault();
      clearFilters();
    });
    render();
    $('grid').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
  }

  function wireIdentifier() {
    var input = $('identify-input');
    var result = $('identify-result');
    if (!input) return;
    input.addEventListener('change', async function () {
      var file = input.files && input.files[0];
      if (!file) return;
      result.textContent = 'Analyzing ' + file.name + '…';
      try {
        var buf = await file.arrayBuffer();
        var report = S2FileID.analyze(buf, { programKey: 'datarecoverfree', fileName: file.name });
        S2FileID.renderPanel(result, report);
        applyIdentification(report);
      } catch (err) {
        result.textContent = 'Could not analyze this file: ' + (err && err.message ? err.message : err);
      }
    });
  }

  /* -------------------------------- boot -------------------------------- */

  function boot(data) {
    DATA = data;
    buildChips();
    $('search').addEventListener('input', function () {
      state.q = this.value.trim();
      render();
    });
    $('clear').addEventListener('click', clearFilters);
    $('empty-clear').addEventListener('click', clearFilters);
    wireIdentifier();
    render();
  }

  function loadFallback(err) {
    // Release bundles are opened from file://, where fetch() of local JSON is
    // blocked. build-releases.sh generates data/software.data.js from
    // data/software.json; try it before giving up.
    var s = document.createElement('script');
    s.src = 'data/software.data.js';
    s.onload = function () {
      if (window.SOFTWARE_DATA) boot(window.SOFTWARE_DATA);
      else fail(err);
    };
    s.onerror = function () { fail(err); };
    document.head.appendChild(s);
  }

  function fail(err) {
    $('grid').innerHTML = '<p class="card">Could not load the software directory (' +
      esc(err && err.message ? err.message : err) + '). If you opened index.html from disk, ' +
      'serve the folder instead, e.g. <code>python3 -m http.server</code>.</p>';
  }

  fetch('data/software.json')
    .then(function (r) {
      if (!r.ok) throw new Error('HTTP ' + r.status);
      return r.json();
    })
    .then(boot)
    .catch(loadFallback);

  if ('serviceWorker' in navigator && location.protocol !== 'file:') {
    window.addEventListener('load', function () {
      navigator.serviceWorker.register('sw.js').catch(function () { /* offline install is optional */ });
    });
  }
})();
