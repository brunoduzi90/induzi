/**
 * InduziShortcuts — Atalhos de Teclado
 */
var InduziShortcuts = (function() {
    document.addEventListener('keydown', function(e) {
        // Don't trigger shortcuts when typing in inputs
        var tag = (e.target.tagName || '').toLowerCase();
        var isInput = tag === 'input' || tag === 'textarea' || tag === 'select' || e.target.isContentEditable;

        // Ctrl+K / Cmd+K — Global search (always works)
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (window.InduziSearch) InduziSearch.toggle();
            return;
        }

        // Escape — Close search
        if (e.key === 'Escape') {
            if (window.InduziSearch && InduziSearch.isOpen()) {
                e.preventDefault();
                InduziSearch.close();
                return;
            }
        }

        // Skip other shortcuts if in input
        if (isInput) return;

        // Ctrl+S — Save (trigger current module's save if available)
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            var saveBtn = document.querySelector('.doc-toolbar .btn-action[onclick*="save"], .doc-toolbar button[onclick*="save"], button[onclick*="saveProjectConfig"]');
            if (saveBtn) saveBtn.click();
            else if (window.Igris) Igris.toast('Nada para salvar nesta pagina', 'info');
            return;
        }

        // Ctrl+E — Export current module
        if ((e.ctrlKey || e.metaKey) && e.key === 'e') {
            e.preventDefault();
            var exportBtn = document.querySelector('.doc-toolbar .btn-action[onclick*="export"], .doc-toolbar button[onclick*="export"]');
            if (exportBtn) exportBtn.click();
            return;
        }
    });

    return {};
})();
