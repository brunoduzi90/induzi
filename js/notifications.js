/**
 * InduziNotifications — Sistema de Notificacoes In-App
 */
var InduziNotifications = (function() {
    var bellEl = null;
    var badgeEl = null;
    var dropdownEl = null;
    var pollInterval = null;
    var notifications = [];
    var isOpen = false;

    function getApiBase() { return InduziDB._getApiBase(); }

    function init() {
        // Create bell in top-bar
        var topBar = document.querySelector('.top-bar');
        if (!topBar) return;

        var wrapper = document.createElement('div');
        wrapper.className = 'notification-bell-wrapper';
        wrapper.style.cssText = 'position:relative;display:inline-flex;margin-right:12px;';
        wrapper.innerHTML = '<button class="notification-bell" id="notifBell" title="Notificacoes">' +
            '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>' +
            '<span class="notification-badge" id="notifBadge"></span></button>' +
            '<div class="notification-dropdown" id="notifDropdown"></div>';

        var topBarMenu = topBar.querySelector('.top-bar-menu');
        if (topBarMenu) topBar.insertBefore(wrapper, topBarMenu);
        else topBar.appendChild(wrapper);

        bellEl = document.getElementById('notifBell');
        badgeEl = document.getElementById('notifBadge');
        dropdownEl = document.getElementById('notifDropdown');

        bellEl.addEventListener('click', function(e) {
            e.stopPropagation();
            toggle();
        });

        document.addEventListener('click', function(e) {
            if (isOpen && !wrapper.contains(e.target)) close();
        });

        fetchNotifications();
        pollInterval = setInterval(fetchNotifications, 60000);
    }

    async function fetchNotifications() {
        try {
            var base = getApiBase();
            var resp = await fetch(base + 'notifications/list.php?_t=' + Date.now(), { cache: 'no-store', credentials: 'same-origin' });
            if (!resp.ok) return;
            var data = await resp.json();
            if (data.ok) {
                notifications = data.notifications || [];
                updateBadge();
                if (isOpen) renderDropdown();
            }
        } catch (e) {}
    }

    function updateBadge() {
        var unread = notifications.filter(function(n) { return !n.lida; }).length;
        if (badgeEl) badgeEl.classList.toggle('visible', unread > 0);
    }

    function renderDropdown() {
        if (!dropdownEl) return;
        var html = '<div class="notification-dropdown-header"><span>Notificacoes</span>';
        var unread = notifications.filter(function(n) { return !n.lida; }).length;
        if (unread > 0) html += '<a onclick="InduziNotifications.markAllRead()">Marcar como lidas</a>';
        html += '</div>';

        if (!notifications.length) {
            html += '<div class="notification-empty">Nenhuma notificacao.</div>';
        } else {
            for (var i = 0; i < Math.min(notifications.length, 20); i++) {
                var n = notifications[i];
                var cls = n.lida ? '' : ' unread';
                html += '<div class="notification-item' + cls + '" data-id="' + n.id + '" onclick="InduziNotifications.clickNotif(' + n.id + ',\'' + (n.link || '') + '\')">';
                html += '<div class="notification-item-title">' + escapeHtml(n.titulo) + '</div>';
                if (n.mensagem) html += '<div class="notification-item-msg">' + escapeHtml(n.mensagem) + '</div>';
                html += '<div class="notification-item-time">' + timeAgo(n.created_at) + '</div>';
                html += '</div>';
            }
        }
        dropdownEl.innerHTML = html;
    }

    function escapeHtml(s) { var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }

    function timeAgo(dateStr) {
        if (!dateStr) return '';
        var d = new Date(dateStr);
        var now = new Date();
        var diff = Math.floor((now - d) / 1000);
        if (diff < 60) return 'Agora';
        if (diff < 3600) return Math.floor(diff / 60) + 'min atras';
        if (diff < 86400) return Math.floor(diff / 3600) + 'h atras';
        return Math.floor(diff / 86400) + 'd atras';
    }

    function toggle() {
        if (isOpen) close();
        else open();
    }

    function open() {
        isOpen = true;
        renderDropdown();
        if (dropdownEl) dropdownEl.classList.add('open');
    }

    function close() {
        isOpen = false;
        if (dropdownEl) dropdownEl.classList.remove('open');
    }

    async function markRead(id) {
        try {
            var base = getApiBase();
            await fetch(base + 'notifications/mark-read.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ id: id })
            });
        } catch (e) {}
    }

    return {
        init: init,
        stop: function() { if (pollInterval) clearInterval(pollInterval); },
        markAllRead: async function() {
            try {
                var base = getApiBase();
                await fetch(base + 'notifications/mark-read.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    body: JSON.stringify({ all: true })
                });
                notifications.forEach(function(n) { n.lida = 1; });
                updateBadge();
                renderDropdown();
            } catch (e) {}
        },
        clickNotif: async function(id, link) {
            await markRead(id);
            for (var i = 0; i < notifications.length; i++) {
                if (notifications[i].id == id) { notifications[i].lida = 1; break; }
            }
            updateBadge();
            close();
            if (link && window.SpaRouter) {
                var route = link.replace('#', '');
                if (SpaRouter.ROUTES[route]) SpaRouter.go(route);
            }
        }
    };
})();
