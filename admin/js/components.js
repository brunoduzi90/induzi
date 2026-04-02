/**
 * IgrisComponents — 6 componentes interativos reutilizaveis — INDUZI
 */
var IgrisComponents = (function() {

    function tagList(container, opts) {
        opts = opts || {};
        var tags = [];
        var el = document.createElement('div');
        el.className = 'ic-taglist';
        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'ic-taglist-input';
        input.placeholder = opts.placeholder || 'Adicionar tag...';
        var list = document.createElement('div');
        list.className = 'ic-taglist-tags';

        function render() {
            list.innerHTML = '';
            tags.forEach(function(tag, i) {
                var span = document.createElement('span');
                span.className = 'ic-tag';
                span.innerHTML = '<span class="ic-tag-text">' + _esc(tag) + '</span><button class="ic-tag-remove" data-i="' + i + '">&times;</button>';
                list.appendChild(span);
            });
        }

        list.addEventListener('click', function(e) {
            var btn = e.target.closest('.ic-tag-remove');
            if (btn) { tags.splice(parseInt(btn.dataset.i), 1); render(); if (opts.onChange) opts.onChange(); }
        });

        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && input.value.trim()) {
                e.preventDefault(); tags.push(input.value.trim()); input.value = ''; render(); if (opts.onChange) opts.onChange();
            }
        });

        el.appendChild(list);
        el.appendChild(input);
        container.appendChild(el);

        return {
            setValue: function(v) { tags = Array.isArray(v) ? v.slice() : []; render(); },
            getValue: function() { return tags.slice(); },
            isFilled: function() { return tags.length > 0; },
            destroy: function() { container.removeChild(el); }
        };
    }

    function checklist(container, opts) {
        opts = opts || {};
        var items = [];
        var el = document.createElement('div');
        el.className = 'ic-checklist';
        var list = document.createElement('div');
        list.className = 'ic-checklist-items';
        var input = document.createElement('input');
        input.type = 'text';
        input.className = 'ic-checklist-input';
        input.placeholder = opts.placeholder || 'Adicionar item...';

        function render() {
            list.innerHTML = '';
            items.forEach(function(item, i) {
                var row = document.createElement('div');
                row.className = 'ic-checklist-item' + (item.done ? ' done' : '');
                row.innerHTML = '<label><input type="checkbox" ' + (item.done ? 'checked' : '') + ' data-i="' + i + '"><span>' + _esc(item.text) + '</span></label><button class="ic-checklist-remove" data-i="' + i + '">&times;</button>';
                list.appendChild(row);
            });
        }

        list.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') { items[parseInt(e.target.dataset.i)].done = e.target.checked; render(); if (opts.onChange) opts.onChange(); }
        });
        list.addEventListener('click', function(e) {
            var btn = e.target.closest('.ic-checklist-remove');
            if (btn) { items.splice(parseInt(btn.dataset.i), 1); render(); if (opts.onChange) opts.onChange(); }
        });
        input.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' && input.value.trim()) { e.preventDefault(); items.push({ text: input.value.trim(), done: false }); input.value = ''; render(); if (opts.onChange) opts.onChange(); }
        });

        el.appendChild(list); el.appendChild(input); container.appendChild(el);

        return {
            setValue: function(v) { items = Array.isArray(v) ? v.map(function(x) { return { text: x.text || x, done: !!x.done }; }) : []; render(); },
            getValue: function() { return items.map(function(x) { return { text: x.text, done: x.done }; }); },
            isFilled: function() { return items.length > 0; },
            destroy: function() { container.removeChild(el); }
        };
    }

    function keyValue(container, opts) {
        opts = opts || {};
        var pairs = [];
        var el = document.createElement('div');
        el.className = 'ic-keyvalue';
        var list = document.createElement('div');
        list.className = 'ic-keyvalue-items';
        var addBtn = document.createElement('button');
        addBtn.className = 'ic-keyvalue-add';
        addBtn.textContent = '+ Adicionar';

        function render() {
            list.innerHTML = '';
            pairs.forEach(function(pair, i) {
                var row = document.createElement('div');
                row.className = 'ic-keyvalue-row';
                row.innerHTML = '<input class="ic-kv-key" value="' + _esc(pair.key) + '" placeholder="' + (opts.keyPlaceholder || 'Chave') + '" data-i="' + i + '"><input class="ic-kv-val" value="' + _esc(pair.value) + '" placeholder="' + (opts.valuePlaceholder || 'Valor') + '" data-i="' + i + '"><button class="ic-keyvalue-remove" data-i="' + i + '">&times;</button>';
                list.appendChild(row);
            });
        }

        list.addEventListener('input', function(e) {
            var i = parseInt(e.target.dataset.i);
            if (e.target.classList.contains('ic-kv-key')) pairs[i].key = e.target.value;
            if (e.target.classList.contains('ic-kv-val')) pairs[i].value = e.target.value;
            if (opts.onChange) opts.onChange();
        });
        list.addEventListener('click', function(e) {
            var btn = e.target.closest('.ic-keyvalue-remove');
            if (btn) { pairs.splice(parseInt(btn.dataset.i), 1); render(); if (opts.onChange) opts.onChange(); }
        });
        addBtn.addEventListener('click', function() { pairs.push({ key: '', value: '' }); render(); });

        el.appendChild(list); el.appendChild(addBtn); container.appendChild(el);

        return {
            setValue: function(v) { pairs = Array.isArray(v) ? v.map(function(x) { return { key: x.key || '', value: x.value || '' }; }) : []; render(); },
            getValue: function() { return pairs.filter(function(p) { return p.key || p.value; }); },
            isFilled: function() { return pairs.some(function(p) { return p.key || p.value; }); },
            destroy: function() { container.removeChild(el); }
        };
    }

    function multiSelect(container, opts) {
        opts = opts || {};
        var selected = [];
        var options = opts.options || [];
        var el = document.createElement('div');
        el.className = 'ic-multiselect';

        function render() {
            el.innerHTML = '';
            options.forEach(function(opt) {
                var chip = document.createElement('button');
                chip.className = 'ic-chip' + (selected.indexOf(opt) >= 0 ? ' active' : '');
                chip.textContent = opt;
                chip.addEventListener('click', function() {
                    var idx = selected.indexOf(opt);
                    if (idx >= 0) selected.splice(idx, 1); else selected.push(opt);
                    render(); if (opts.onChange) opts.onChange();
                });
                el.appendChild(chip);
            });
        }

        render(); container.appendChild(el);

        return {
            setValue: function(v) { selected = Array.isArray(v) ? v.slice() : []; render(); },
            getValue: function() { return selected.slice(); },
            isFilled: function() { return selected.length > 0; },
            destroy: function() { container.removeChild(el); }
        };
    }

    function dropzone(container, opts) {
        opts = opts || {};
        var files = [];
        var el = document.createElement('div');
        el.className = 'ic-dropzone';
        el.innerHTML = '<div class="ic-dropzone-area"><span class="ic-dropzone-text">' + (opts.placeholder || 'Arraste arquivos aqui ou clique') + '</span><input type="file" class="ic-dropzone-input" ' + (opts.multiple ? 'multiple' : '') + ' ' + (opts.accept ? 'accept="' + opts.accept + '"' : '') + '></div><div class="ic-dropzone-preview"></div>';

        var area = el.querySelector('.ic-dropzone-area');
        var fileInput = el.querySelector('.ic-dropzone-input');
        var preview = el.querySelector('.ic-dropzone-preview');

        function render() {
            preview.innerHTML = '';
            files.forEach(function(f, i) {
                var item = document.createElement('div');
                item.className = 'ic-dropzone-item';
                item.innerHTML = '<span>' + _esc(f.name) + '</span><button data-i="' + i + '">&times;</button>';
                preview.appendChild(item);
            });
        }

        preview.addEventListener('click', function(e) {
            var btn = e.target.closest('button');
            if (btn) { files.splice(parseInt(btn.dataset.i), 1); render(); if (opts.onChange) opts.onChange(); }
        });

        area.addEventListener('click', function() { fileInput.click(); });
        area.addEventListener('dragover', function(e) { e.preventDefault(); area.classList.add('dragover'); });
        area.addEventListener('dragleave', function() { area.classList.remove('dragover'); });
        area.addEventListener('drop', function(e) { e.preventDefault(); area.classList.remove('dragover'); _processFiles(e.dataTransfer.files); });
        fileInput.addEventListener('change', function() { _processFiles(fileInput.files); fileInput.value = ''; });

        function _processFiles(fileList) {
            Array.from(fileList).forEach(function(file) {
                var reader = new FileReader();
                reader.onload = function(e) { files.push({ name: file.name, data: e.target.result, file: file }); render(); if (opts.onChange) opts.onChange(); };
                reader.readAsDataURL(file);
            });
        }

        container.appendChild(el);

        return {
            setValue: function(v) { files = Array.isArray(v) ? v.slice() : []; render(); },
            getValue: function() { return files.slice(); },
            getFiles: function() { return files.map(function(f) { return f.file; }).filter(Boolean); },
            isFilled: function() { return files.length > 0; },
            destroy: function() { container.removeChild(el); }
        };
    }

    function _esc(str) {
        var div = document.createElement('div');
        div.textContent = str || '';
        return div.innerHTML;
    }

    window._esc = _esc;

    return {
        tagList: tagList,
        checklist: checklist,
        keyValue: keyValue,
        multiSelect: multiSelect,
        dropzone: dropzone
    };
})();
