/**
 * Igris — Sistema de modais e toasts — INDUZI
 */
var Igris = (function() {
    var _stack = [];

    function _createOverlay() {
        var overlay = document.createElement('div');
        overlay.className = 'igris-modal-overlay';
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) _closeTop();
        });
        return overlay;
    }

    function _closeTop() {
        if (_stack.length === 0) return;
        var modal = _stack.pop();
        if (modal.overlay && modal.overlay.parentNode) {
            modal.overlay.classList.add('closing');
            setTimeout(function() {
                if (modal.overlay.parentNode) modal.overlay.parentNode.removeChild(modal.overlay);
            }, 200);
        }
        if (modal.reject) modal.reject('closed');
    }

    function _buildModal(opts) {
        var overlay = _createOverlay();
        var box = document.createElement('div');
        box.className = 'igris-modal';

        var html = '';
        if (opts.title) html += '<div class="igris-modal-title">' + opts.title + '</div>';
        if (opts.message) html += '<div class="igris-modal-message">' + opts.message + '</div>';
        if (opts.input) html += '<input class="igris-modal-input" type="' + (opts.inputType || 'text') + '" placeholder="' + (opts.placeholder || '') + '" value="' + (opts.defaultValue || '') + '">';
        if (opts.textarea) html += '<textarea class="igris-modal-input" rows="' + (opts.rows || 4) + '" placeholder="' + (opts.placeholder || '') + '">' + (opts.defaultValue || '') + '</textarea>';
        html += '<div class="igris-modal-actions">';
        if (opts.showCancel !== false && opts.type !== 'alert') {
            html += '<button class="igris-btn igris-btn-secondary" data-action="cancel">Cancelar</button>';
        }
        html += '<button class="igris-btn igris-btn-primary" data-action="ok">' + (opts.okText || 'OK') + '</button>';
        html += '</div>';
        box.innerHTML = html;

        overlay.appendChild(box);
        return { overlay: overlay, box: box };
    }

    return {
        alert: function(title, message) {
            return new Promise(function(resolve) {
                var m = _buildModal({ title: title, message: message, type: 'alert' });
                m.box.querySelector('[data-action="ok"]').addEventListener('click', function() {
                    _stack.pop();
                    m.overlay.parentNode.removeChild(m.overlay);
                    resolve();
                });
                _stack.push({ overlay: m.overlay });
                document.body.appendChild(m.overlay);
                m.box.querySelector('[data-action="ok"]').focus();
            });
        },

        confirm: function(title, message, okText) {
            return new Promise(function(resolve) {
                var m = _buildModal({ title: title, message: message, okText: okText || 'Confirmar' });
                m.box.querySelector('[data-action="ok"]').addEventListener('click', function() {
                    _stack.pop();
                    m.overlay.parentNode.removeChild(m.overlay);
                    resolve(true);
                });
                m.box.querySelector('[data-action="cancel"]').addEventListener('click', function() {
                    _stack.pop();
                    m.overlay.parentNode.removeChild(m.overlay);
                    resolve(false);
                });
                _stack.push({ overlay: m.overlay });
                document.body.appendChild(m.overlay);
            });
        },

        prompt: function(title, placeholder, defaultValue) {
            return new Promise(function(resolve) {
                var m = _buildModal({
                    title: title, input: true,
                    placeholder: placeholder, defaultValue: defaultValue
                });
                var input = m.box.querySelector('.igris-modal-input');
                m.box.querySelector('[data-action="ok"]').addEventListener('click', function() {
                    _stack.pop();
                    m.overlay.parentNode.removeChild(m.overlay);
                    resolve(input.value);
                });
                m.box.querySelector('[data-action="cancel"]').addEventListener('click', function() {
                    _stack.pop();
                    m.overlay.parentNode.removeChild(m.overlay);
                    resolve(null);
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') m.box.querySelector('[data-action="ok"]').click();
                });
                _stack.push({ overlay: m.overlay });
                document.body.appendChild(m.overlay);
                input.focus();
                input.select();
            });
        },

        toast: function(message, type, duration) {
            type = type || 'info';
            duration = duration || 3000;

            var container = document.getElementById('igris-toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'igris-toast-container';
                container.className = 'igris-toast-container';
                document.body.appendChild(container);
            }

            var toast = document.createElement('div');
            toast.className = 'igris-toast igris-toast-' + type;
            toast.textContent = message;
            container.appendChild(toast);

            requestAnimationFrame(function() { toast.classList.add('show'); });

            setTimeout(function() {
                toast.classList.remove('show');
                toast.classList.add('hide');
                setTimeout(function() {
                    if (toast.parentNode) toast.parentNode.removeChild(toast);
                }, 300);
            }, duration);
        },

        close: _closeTop
    };
})();
