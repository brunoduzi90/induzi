/**
 * Igris Modal System — reusado no Induzi
 */
var Igris = (function() {
    var overlay = null;
    var toastContainer = null;

    function ensureDOM() {
        if (overlay) return;
        overlay = document.createElement('div');
        overlay.id = 'igrisModalOverlay';
        overlay.className = 'igris-modal-overlay';
        overlay.innerHTML = '<div class="igris-modal" id="igrisModal"><div class="igris-modal-body" id="igrisModalBody"></div><div class="igris-modal-footer" id="igrisModalFooter"></div></div>';
        document.body.appendChild(overlay);
        toastContainer = document.createElement('div');
        toastContainer.id = 'igrisToastContainer';
        toastContainer.className = 'igris-toast-container';
        document.body.appendChild(toastContainer);
    }

    function showModal(bodyHTML, footerHTML, onKey) {
        ensureDOM();
        var modal = document.getElementById('igrisModal');
        document.getElementById('igrisModalBody').innerHTML = bodyHTML;
        document.getElementById('igrisModalFooter').innerHTML = footerHTML;
        overlay.classList.add('active');
        modal.setAttribute('role', 'dialog');
        modal.setAttribute('aria-modal', 'true');
        overlay._onKeyBound = function(e) {
            if (overlay.classList.contains('active')) {
                // Focus trap
                if (e.key === 'Tab') {
                    var focusable = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                    if (focusable.length) {
                        var first = focusable[0], last = focusable[focusable.length - 1];
                        if (e.shiftKey) { if (document.activeElement === first) { e.preventDefault(); last.focus(); } }
                        else { if (document.activeElement === last) { e.preventDefault(); first.focus(); } }
                    }
                }
                onKey(e);
            }
        };
        document.addEventListener('keydown', overlay._onKeyBound);
    }

    function hideModal() {
        if (!overlay) return;
        overlay.classList.remove('active');
        if (overlay._onKeyBound) { document.removeEventListener('keydown', overlay._onKeyBound); overlay._onKeyBound = null; }
    }

    function escapeHTML(str) { var div = document.createElement('div'); div.textContent = str; return div.innerHTML; }

    return {
        alert: function(msg) {
            return new Promise(function(resolve) {
                var body = '<p class="igris-modal-msg">' + escapeHTML(msg) + '</p>';
                var footer = '<button class="btn btn-primary igris-modal-btn" id="igrisOk">OK</button>';
                showModal(body, footer, function(e) { if (e.key === 'Escape' || e.key === 'Enter') { hideModal(); resolve(); } });
                document.getElementById('igrisOk').onclick = function() { hideModal(); resolve(); };
                document.getElementById('igrisOk').focus();
            });
        },
        confirm: function(msg) {
            return new Promise(function(resolve) {
                var body = '<p class="igris-modal-msg">' + escapeHTML(msg) + '</p>';
                var footer = '<button class="btn btn-secondary igris-modal-btn" id="igrisCancel">Cancelar</button><button class="btn btn-primary igris-modal-btn" id="igrisOk">Confirmar</button>';
                showModal(body, footer, function(e) { if (e.key === 'Escape') { hideModal(); resolve(false); } else if (e.key === 'Enter') { hideModal(); resolve(true); } });
                overlay.onclick = function(e) { if (e.target === overlay) { hideModal(); resolve(false); } };
                document.getElementById('igrisCancel').onclick = function() { hideModal(); resolve(false); };
                document.getElementById('igrisOk').onclick = function() { hideModal(); resolve(true); };
                document.getElementById('igrisOk').focus();
            });
        },
        prompt: function(msg, defaultVal) {
            return new Promise(function(resolve) {
                var body = '<p class="igris-modal-msg">' + escapeHTML(msg) + '</p><input type="text" class="igris-modal-input" id="igrisInput" value="' + escapeHTML(defaultVal || '') + '">';
                var footer = '<button class="btn btn-secondary igris-modal-btn" id="igrisCancel">Cancelar</button><button class="btn btn-primary igris-modal-btn" id="igrisOk">OK</button>';
                showModal(body, footer, function(e) { if (e.key === 'Escape') { hideModal(); resolve(null); } else if (e.key === 'Enter') { hideModal(); resolve(document.getElementById('igrisInput').value); } });
                overlay.onclick = function(e) { if (e.target === overlay) { hideModal(); resolve(null); } };
                document.getElementById('igrisCancel').onclick = function() { hideModal(); resolve(null); };
                document.getElementById('igrisOk').onclick = function() { hideModal(); resolve(document.getElementById('igrisInput').value); };
                var inp = document.getElementById('igrisInput'); inp.focus(); inp.select();
            });
        },
        onOverlayClick: function(id, fn) {
            var el = typeof id === 'string' ? document.getElementById(id) : id;
            if (!el) return;
            var downTarget = null;
            el.addEventListener('mousedown', function(e) { downTarget = e.target; });
            el.addEventListener('click', function(e) { if (e.target === el && downTarget === el) fn(); downTarget = null; });
        },
        toast: function(msg, tipo, duracao) {
            ensureDOM();
            tipo = tipo || 'info'; duracao = duracao || 3000;
            var t = document.createElement('div');
            t.className = 'igris-toast igris-toast-' + tipo;
            t.textContent = msg;
            toastContainer.appendChild(t);
            t.offsetHeight;
            t.classList.add('show');
            setTimeout(function() {
                t.classList.remove('show');
                t.addEventListener('transitionend', function() { if (t.parentNode) t.parentNode.removeChild(t); });
                setTimeout(function() { if (t.parentNode) t.parentNode.removeChild(t); }, 400);
            }, duracao);
        }
    };
})();
