/* ============================================================
   INDUZI Interactive Components
   Namespace: InduziComponents
   6 constructors: tagList, checklist, multiSelect,
                   dropzone, keyValue, guided
   Each returns { setValue, getValue, isFilled, destroy }
   ============================================================ */

var InduziComponents = (function() {
    'use strict';

    // --------------------------------------------------------
    // Helpers
    // --------------------------------------------------------
    function el(tag, cls, attrs) {
        var e = document.createElement(tag);
        if (cls) e.className = cls;
        if (attrs) Object.keys(attrs).forEach(function(k) { e.setAttribute(k, attrs[k]); });
        return e;
    }

    // --------------------------------------------------------
    // 1. Tag List
    // --------------------------------------------------------
    function tagList(container, opts) {
        opts = opts || {};
        var tags = [];
        var listeners = [];

        var wrap = el('div', 'ic-taglist');
        var input = el('input', 'ic-tag-input', {
            type: 'text',
            placeholder: opts.placeholder || 'Adicionar...'
        });

        container.innerHTML = '';
        wrap.appendChild(input);
        container.appendChild(wrap);

        function render() {
            var existingTags = wrap.querySelectorAll('.ic-tag');
            existingTags.forEach(function(t) { t.remove(); });
            tags.forEach(function(tag, i) {
                var span = el('span', 'ic-tag');
                span.textContent = tag;
                var x = el('span', 'ic-tag-x');
                x.textContent = '\u00d7';
                x.addEventListener('click', function() { removeTag(i); });
                span.appendChild(x);
                wrap.insertBefore(span, input);
            });
        }

        function addTag(text) {
            text = text.trim();
            if (!text || tags.indexOf(text) !== -1) return;
            tags.push(text);
            render();
            if (opts.onChange) opts.onChange(tags.slice());
        }

        function removeTag(i) {
            tags.splice(i, 1);
            render();
            if (opts.onChange) opts.onChange(tags.slice());
        }

        function onKeydown(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (input.value.trim()) {
                    addTag(input.value);
                    input.value = '';
                }
            } else if (e.key === 'Backspace' && !input.value && tags.length) {
                removeTag(tags.length - 1);
            }
        }

        function onPaste(e) {
            e.preventDefault();
            var text = (e.clipboardData || window.clipboardData).getData('text');
            var parts = text.split(/[,\n]+/);
            parts.forEach(function(p) { addTag(p); });
            input.value = '';
        }

        function onWrapClick() { input.focus(); }

        input.addEventListener('keydown', onKeydown);
        input.addEventListener('paste', onPaste);
        wrap.addEventListener('click', onWrapClick);
        listeners.push(
            [input, 'keydown', onKeydown],
            [input, 'paste', onPaste],
            [wrap, 'click', onWrapClick]
        );

        return {
            setValue: function(data) {
                if (typeof data === 'string') {
                    tags = data.split(/[,\n]+/).map(function(s) { return s.trim(); }).filter(Boolean);
                } else if (Array.isArray(data)) {
                    tags = data.slice();
                } else {
                    tags = [];
                }
                render();
            },
            getValue: function() { return tags.slice(); },
            isFilled: function() { return tags.length > 0; },
            destroy: function() {
                listeners.forEach(function(l) { l[0].removeEventListener(l[1], l[2]); });
            }
        };
    }

    // --------------------------------------------------------
    // 2. Checklist
    // --------------------------------------------------------
    function checklist(container, opts) {
        opts = opts || {};
        var items = [];
        var listeners = [];
        var dragIdx = -1;

        var wrap = el('div', 'ic-checklist');
        var listEl = el('ul', 'ic-checklist-items');
        var addRow = el('div', 'ic-checklist-add');
        var addInput = el('input', '', {
            type: 'text',
            placeholder: opts.placeholder || 'Adicionar item...'
        });

        addRow.appendChild(addInput);
        wrap.appendChild(listEl);
        wrap.appendChild(addRow);
        container.innerHTML = '';
        container.appendChild(wrap);

        function fireChange() {
            if (opts.onChange) opts.onChange(items.map(function(it) { return { text: it.text, done: it.done }; }));
        }

        function render() {
            listEl.innerHTML = '';
            items.forEach(function(item, i) {
                var li = el('li', 'ic-checklist-item' + (item.done ? ' done' : ''));
                li.setAttribute('draggable', 'true');

                var grip = el('span', 'ic-check-grip');
                grip.textContent = '\u2261';

                var cb = el('input', 'ic-check-cb', { type: 'checkbox' });
                cb.checked = item.done;
                cb.addEventListener('change', function() {
                    items[i].done = cb.checked;
                    li.classList.toggle('done', cb.checked);
                    fireChange();
                });

                var text = el('span', 'ic-check-text');
                text.textContent = item.text;

                var x = el('span', 'ic-check-remove');
                x.textContent = '\u00d7';
                x.addEventListener('click', function() {
                    items.splice(i, 1);
                    render();
                    fireChange();
                });

                // Drag handlers
                li.addEventListener('dragstart', function(e) {
                    dragIdx = i;
                    li.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });
                li.addEventListener('dragend', function() {
                    li.classList.remove('dragging');
                    dragIdx = -1;
                    listEl.querySelectorAll('.drag-over').forEach(function(el) { el.classList.remove('drag-over'); });
                });
                li.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    li.classList.add('drag-over');
                });
                li.addEventListener('dragleave', function() {
                    li.classList.remove('drag-over');
                });
                li.addEventListener('drop', function(e) {
                    e.preventDefault();
                    li.classList.remove('drag-over');
                    if (dragIdx === -1 || dragIdx === i) return;
                    var moved = items.splice(dragIdx, 1)[0];
                    items.splice(i, 0, moved);
                    render();
                    fireChange();
                });

                li.appendChild(grip);
                li.appendChild(cb);
                li.appendChild(text);
                li.appendChild(x);
                listEl.appendChild(li);
            });
        }

        function addItem(text) {
            text = text.trim();
            if (!text) return;
            items.push({ text: text, done: false });
            render();
            fireChange();
        }

        function onKeydown(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                addItem(addInput.value);
                addInput.value = '';
            }
        }

        addInput.addEventListener('keydown', onKeydown);
        listeners.push([addInput, 'keydown', onKeydown]);

        // Add presets
        if (opts.presets && opts.presets.length) {
            opts.presets.forEach(function(p) {
                items.push({ text: p, done: false });
            });
            render();
        }

        return {
            setValue: function(data) {
                if (typeof data === 'string') {
                    items = data.split(/\n+/).map(function(s) { return s.trim(); }).filter(Boolean).map(function(t) { return { text: t, done: false }; });
                } else if (Array.isArray(data)) {
                    items = data.map(function(it) {
                        if (typeof it === 'string') return { text: it, done: false };
                        return { text: it.text || '', done: !!it.done };
                    });
                } else {
                    items = [];
                }
                render();
            },
            getValue: function() { return items.map(function(it) { return { text: it.text, done: it.done }; }); },
            isFilled: function() { return items.length > 0; },
            destroy: function() {
                listeners.forEach(function(l) { l[0].removeEventListener(l[1], l[2]); });
            }
        };
    }

    // --------------------------------------------------------
    // 3. Multi-Select Chips
    // --------------------------------------------------------
    function multiSelect(container, opts) {
        opts = opts || {};
        var selected = [];
        var listeners = [];

        var wrap = el('div', 'ic-multiselect');
        container.innerHTML = '';
        container.appendChild(wrap);

        var chipEls = [];
        (opts.options || []).forEach(function(opt) {
            var chip = el('span', 'ic-chip');
            chip.textContent = opt.label || opt.value;
            chip.setAttribute('data-value', opt.value);

            function onClick() {
                var idx = selected.indexOf(opt.value);
                if (idx === -1) {
                    selected.push(opt.value);
                    chip.classList.add('active');
                } else {
                    selected.splice(idx, 1);
                    chip.classList.remove('active');
                }
                if (opts.onChange) opts.onChange(selected.slice());
            }

            chip.addEventListener('click', onClick);
            listeners.push([chip, 'click', onClick]);
            wrap.appendChild(chip);
            chipEls.push(chip);
        });

        function syncChips() {
            chipEls.forEach(function(c) {
                var v = c.getAttribute('data-value');
                c.classList.toggle('active', selected.indexOf(v) !== -1);
            });
        }

        return {
            setValue: function(data) {
                if (typeof data === 'string') {
                    selected = data.split(/[,\n]+/).map(function(s) { return s.trim(); }).filter(Boolean);
                } else if (Array.isArray(data)) {
                    selected = data.slice();
                } else {
                    selected = [];
                }
                syncChips();
            },
            getValue: function() { return selected.slice(); },
            isFilled: function() { return selected.length > 0; },
            destroy: function() {
                listeners.forEach(function(l) { l[0].removeEventListener(l[1], l[2]); });
            }
        };
    }

    // --------------------------------------------------------
    // 4. Dropzone
    // --------------------------------------------------------
    function dropzone(container, opts) {
        opts = opts || {};
        var files = [];
        var listeners = [];
        var MAX_WIDTH = 800;
        var maxFiles = opts.maxFiles || 10;

        var wrap = el('div', 'ic-dropzone');
        var label = el('div', 'ic-dropzone-label');
        label.innerHTML = 'Arraste imagens aqui, <strong>clique para navegar</strong> ou <strong>Ctrl+V</strong>';
        var input = el('input', 'ic-dropzone-input', {
            type: 'file',
            accept: opts.accept || 'image/*',
            multiple: 'true'
        });
        var thumbs = el('div', 'ic-dropzone-thumbs');

        wrap.appendChild(label);
        wrap.appendChild(input);
        wrap.appendChild(thumbs);
        container.innerHTML = '';
        container.appendChild(wrap);

        function fireChange() {
            if (opts.onChange) opts.onChange(files.map(function(f) { return { name: f.name, data: f.data }; }));
        }

        function renderThumbs() {
            thumbs.innerHTML = '';
            files.forEach(function(f, i) {
                var thumb = el('div', 'ic-dropzone-thumb');
                var img = el('img');
                img.src = f.data;
                img.alt = f.name;
                var x = el('button', 'ic-dropzone-thumb-x');
                x.textContent = '\u00d7';
                x.addEventListener('click', function(e) {
                    e.stopPropagation();
                    files.splice(i, 1);
                    renderThumbs();
                    fireChange();
                });
                var name = el('div', 'ic-dropzone-thumb-name');
                name.textContent = f.name;
                thumb.appendChild(img);
                thumb.appendChild(x);
                thumb.appendChild(name);
                thumbs.appendChild(thumb);
            });
        }

        function resizeAndAdd(file) {
            if (files.length >= maxFiles) return;
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = new Image();
                img.onload = function() {
                    var w = img.width, h = img.height;
                    if (w > MAX_WIDTH) {
                        h = Math.round(h * MAX_WIDTH / w);
                        w = MAX_WIDTH;
                    }
                    var canvas = document.createElement('canvas');
                    canvas.width = w;
                    canvas.height = h;
                    canvas.getContext('2d').drawImage(img, 0, 0, w, h);
                    var dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                    files.push({ name: file.name, data: dataUrl });
                    renderThumbs();
                    fireChange();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function processFiles(fileList) {
            for (var i = 0; i < fileList.length; i++) {
                if (fileList[i].type.indexOf('image') === 0) {
                    resizeAndAdd(fileList[i]);
                }
            }
        }

        function onClick() { input.click(); }
        function onInputChange() { processFiles(input.files); input.value = ''; }
        function onDragOver(e) { e.preventDefault(); wrap.classList.add('dragover'); }
        function onDragLeave() { wrap.classList.remove('dragover'); }
        function onDrop(e) {
            e.preventDefault();
            wrap.classList.remove('dragover');
            processFiles(e.dataTransfer.files);
        }
        function onPaste(e) {
            if (e.clipboardData && e.clipboardData.files && e.clipboardData.files.length) {
                processFiles(e.clipboardData.files);
            }
        }

        wrap.addEventListener('click', onClick);
        input.addEventListener('change', onInputChange);
        wrap.addEventListener('dragover', onDragOver);
        wrap.addEventListener('dragleave', onDragLeave);
        wrap.addEventListener('drop', onDrop);
        document.addEventListener('paste', onPaste);
        listeners.push(
            [wrap, 'click', onClick],
            [input, 'change', onInputChange],
            [wrap, 'dragover', onDragOver],
            [wrap, 'dragleave', onDragLeave],
            [wrap, 'drop', onDrop],
            [document, 'paste', onPaste]
        );

        return {
            setValue: function(data) {
                if (Array.isArray(data)) {
                    files = data.filter(function(f) { return f && f.data; }).map(function(f) { return { name: f.name || 'image', data: f.data }; });
                } else {
                    files = [];
                }
                renderThumbs();
            },
            getValue: function() { return files.map(function(f) { return { name: f.name, data: f.data }; }); },
            isFilled: function() { return files.length > 0; },
            destroy: function() {
                listeners.forEach(function(l) { l[0].removeEventListener(l[1], l[2]); });
            }
        };
    }

    // --------------------------------------------------------
    // 5. Key-Value Pairs
    // --------------------------------------------------------
    function keyValue(container, opts) {
        opts = opts || {};
        var pairs = [];
        var listeners = [];

        var wrap = el('div', 'ic-keyvalue');
        var listEl = el('ul', 'ic-kv-items');
        var addRow = el('div', 'ic-kv-add');
        var addBtn = el('button', '', { type: 'button' });
        addBtn.textContent = '+ Adicionar';

        addRow.appendChild(addBtn);
        wrap.appendChild(listEl);
        wrap.appendChild(addRow);
        container.innerHTML = '';
        container.appendChild(wrap);

        function fireChange() {
            if (opts.onChange) opts.onChange(pairs.map(function(p) { return { key: p.key, value: p.value }; }));
        }

        function render() {
            listEl.innerHTML = '';
            pairs.forEach(function(pair, i) {
                var li = el('li', 'ic-kv-item');

                var keyInput = el('textarea', 'ic-kv-key', {
                    placeholder: opts.keyLabel || 'Chave',
                    rows: '1'
                });
                keyInput.value = pair.key;
                keyInput.addEventListener('input', function() {
                    pairs[i].key = keyInput.value;
                    fireChange();
                });

                var valInput = el('textarea', 'ic-kv-val', {
                    placeholder: opts.valueLabel || 'Valor',
                    rows: '1'
                });
                valInput.value = pair.value;
                valInput.addEventListener('input', function() {
                    pairs[i].value = valInput.value;
                    fireChange();
                });

                var x = el('span', 'ic-kv-remove');
                x.textContent = '\u00d7';
                x.addEventListener('click', function() {
                    pairs.splice(i, 1);
                    render();
                    fireChange();
                });

                li.appendChild(keyInput);
                li.appendChild(valInput);
                li.appendChild(x);
                listEl.appendChild(li);
            });
        }

        function onAdd() {
            pairs.push({ key: '', value: '' });
            render();
            // Focus the new key input
            var items = listEl.querySelectorAll('.ic-kv-key');
            if (items.length) items[items.length - 1].focus();
        }

        addBtn.addEventListener('click', onAdd);
        listeners.push([addBtn, 'click', onAdd]);

        return {
            setValue: function(data) {
                if (typeof data === 'string') {
                    // Parse "Key:\nValue\n\nKey:\nValue" pattern
                    pairs = [];
                    var lines = data.split('\n');
                    var currentKey = null;
                    var currentVal = [];
                    for (var i = 0; i < lines.length; i++) {
                        var line = lines[i];
                        // Detect patterns like "Objecao: 'xxx'" or "P: xxx" or "Resposta: xxx"
                        var match = line.match(/^([^:]+):\s*(.*)$/);
                        if (match && (currentKey !== null || match[2])) {
                            if (currentKey !== null) {
                                pairs.push({ key: currentKey, value: currentVal.join('\n').trim() });
                            }
                            currentKey = match[1].trim();
                            currentVal = match[2] ? [match[2].trim()] : [];
                        } else if (line.trim() === '' && currentKey !== null) {
                            pairs.push({ key: currentKey, value: currentVal.join('\n').trim() });
                            currentKey = null;
                            currentVal = [];
                        } else if (currentKey !== null) {
                            currentVal.push(line);
                        } else if (line.trim()) {
                            currentKey = line.trim();
                            currentVal = [];
                        }
                    }
                    if (currentKey !== null) {
                        pairs.push({ key: currentKey, value: currentVal.join('\n').trim() });
                    }
                } else if (Array.isArray(data)) {
                    pairs = data.map(function(p) {
                        if (typeof p === 'string') return { key: p, value: '' };
                        return { key: p.key || '', value: p.value || '' };
                    });
                } else {
                    pairs = [];
                }
                render();
            },
            getValue: function() { return pairs.map(function(p) { return { key: p.key, value: p.value }; }); },
            isFilled: function() { return pairs.some(function(p) { return (p.key && p.key.trim()) || (p.value && p.value.trim()); }); },
            destroy: function() {
                listeners.forEach(function(l) { l[0].removeEventListener(l[1], l[2]); });
            }
        };
    }

    // --------------------------------------------------------
    // 6. Guided (suggestions + templates + checklist + custom)
    // --------------------------------------------------------
    function guided(container, opts) {
        opts = opts || {};
        var items = [];
        var listeners = [];
        var dragIdx = -1;
        var expanded = false;
        var maxVisible = opts.maxVisible || 8;
        var suggestions = opts.suggestions || [];
        var templates = opts.templates || [];

        var wrap = el('div', 'ic-guided');

        // --- Suggestions row ---
        var sugRow = el('div', 'ic-guided-suggestions');
        var chipEls = [];
        var moreBtn = null;

        function buildSuggestions() {
            sugRow.innerHTML = '';
            chipEls = [];
            if (!suggestions.length) { sugRow.style.display = 'none'; return; }
            sugRow.style.display = '';
            var limit = expanded ? suggestions.length : maxVisible;
            for (var i = 0; i < suggestions.length; i++) {
                var chip = el('span', 'ic-guided-chip');
                chip.textContent = suggestions[i];
                chip.setAttribute('data-idx', i);
                if (i >= limit) chip.style.display = 'none';
                chip.addEventListener('click', onChipClick);
                listeners.push([chip, 'click', onChipClick]);
                sugRow.appendChild(chip);
                chipEls.push(chip);
            }
            if (suggestions.length > maxVisible) {
                moreBtn = el('span', 'ic-guided-chip ic-more');
                updateMoreBtn();
                moreBtn.addEventListener('click', onMoreClick);
                listeners.push([moreBtn, 'click', onMoreClick]);
                sugRow.appendChild(moreBtn);
            }
            syncChips();
        }

        function updateMoreBtn() {
            if (!moreBtn) return;
            if (expanded) {
                moreBtn.textContent = 'Menos';
                moreBtn.style.display = '';
            } else {
                var hidden = suggestions.length - maxVisible;
                if (hidden > 0) {
                    moreBtn.textContent = '+' + hidden + ' mais';
                    moreBtn.style.display = '';
                } else {
                    moreBtn.style.display = 'none';
                }
            }
        }

        function onMoreClick() {
            expanded = !expanded;
            var limit = expanded ? suggestions.length : maxVisible;
            for (var i = 0; i < chipEls.length; i++) {
                chipEls[i].style.display = i < limit ? '' : 'none';
            }
            updateMoreBtn();
        }

        function onChipClick(e) {
            var text = e.currentTarget.textContent;
            var idx = findItem(text);
            if (idx !== -1) {
                items.splice(idx, 1);
            } else {
                items.push({ text: text, done: false });
            }
            syncChips();
            renderItems();
            fireChange();
        }

        function findItem(text) {
            var lower = text.toLowerCase();
            for (var i = 0; i < items.length; i++) {
                if (items[i].text.toLowerCase() === lower) return i;
            }
            return -1;
        }

        function syncChips() {
            for (var i = 0; i < chipEls.length; i++) {
                var text = suggestions[i];
                chipEls[i].classList.toggle('active', findItem(text) !== -1);
            }
        }

        // --- Templates row ---
        var tplRow = el('div', 'ic-guided-templates');

        function buildTemplates() {
            tplRow.innerHTML = '';
            if (!templates.length) { tplRow.style.display = 'none'; return; }
            tplRow.style.display = '';
            templates.forEach(function(tpl) {
                var btn = el('button', 'ic-guided-tpl-btn', { type: 'button' });
                btn.textContent = tpl.label;
                function onClick() { applyTemplate(tpl); }
                btn.addEventListener('click', onClick);
                listeners.push([btn, 'click', onClick]);
                tplRow.appendChild(btn);
            });
        }

        function applyTemplate(tpl) {
            var tplItems = tpl.items || [];
            tplItems.forEach(function(t) {
                if (findItem(t) === -1) {
                    items.push({ text: t, done: false });
                }
            });
            syncChips();
            renderItems();
            fireChange();
        }

        // --- Items list ---
        var listEl = el('ul', 'ic-guided-items');

        function renderItems() {
            listEl.innerHTML = '';
            items.forEach(function(item, i) {
                var li = el('li', 'ic-guided-item' + (item.done ? ' done' : ''));
                li.setAttribute('draggable', 'true');

                var grip = el('span', 'ic-check-grip');
                grip.textContent = '\u2261';

                var cb = el('input', 'ic-check-cb', { type: 'checkbox' });
                cb.checked = item.done;
                cb.addEventListener('change', function() {
                    items[i].done = cb.checked;
                    li.classList.toggle('done', cb.checked);
                    fireChange();
                });

                var text = el('span', 'ic-check-text');
                text.textContent = item.text;

                var x = el('span', 'ic-check-remove');
                x.textContent = '\u00d7';
                x.addEventListener('click', function() {
                    items.splice(i, 1);
                    syncChips();
                    renderItems();
                    fireChange();
                });

                // Drag
                li.addEventListener('dragstart', function(e) {
                    dragIdx = i;
                    li.classList.add('dragging');
                    e.dataTransfer.effectAllowed = 'move';
                });
                li.addEventListener('dragend', function() {
                    li.classList.remove('dragging');
                    dragIdx = -1;
                    listEl.querySelectorAll('.drag-over').forEach(function(el) { el.classList.remove('drag-over'); });
                });
                li.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    e.dataTransfer.dropEffect = 'move';
                    li.classList.add('drag-over');
                });
                li.addEventListener('dragleave', function() { li.classList.remove('drag-over'); });
                li.addEventListener('drop', function(e) {
                    e.preventDefault();
                    li.classList.remove('drag-over');
                    if (dragIdx === -1 || dragIdx === i) return;
                    var moved = items.splice(dragIdx, 1)[0];
                    items.splice(i, 0, moved);
                    syncChips();
                    renderItems();
                    fireChange();
                });

                li.appendChild(grip);
                li.appendChild(cb);
                li.appendChild(text);
                li.appendChild(x);
                listEl.appendChild(li);
            });
        }

        // --- Custom add input ---
        var addRow = el('div', 'ic-guided-add');
        var addInput = el('input', '', {
            type: 'text',
            placeholder: opts.placeholder || 'Adicionar item personalizado...'
        });
        addRow.appendChild(addInput);

        function onKeydown(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                var text = addInput.value.trim();
                if (text && findItem(text) === -1) {
                    items.push({ text: text, done: false });
                    syncChips();
                    renderItems();
                    fireChange();
                }
                addInput.value = '';
            }
        }
        addInput.addEventListener('keydown', onKeydown);
        listeners.push([addInput, 'keydown', onKeydown]);

        function fireChange() {
            if (opts.onChange) opts.onChange(items.map(function(it) { return { text: it.text, done: it.done }; }));
        }

        // --- Assembly ---
        wrap.appendChild(sugRow);
        wrap.appendChild(tplRow);
        wrap.appendChild(listEl);
        wrap.appendChild(addRow);
        container.innerHTML = '';
        container.appendChild(wrap);

        buildSuggestions();
        buildTemplates();

        return {
            setValue: function(data) {
                if (typeof data === 'string') {
                    items = data.split(/\n+/).map(function(s) { return s.trim(); }).filter(Boolean).map(function(t) { return { text: t, done: false }; });
                } else if (Array.isArray(data)) {
                    items = data.map(function(it) {
                        if (typeof it === 'string') return { text: it, done: false };
                        return { text: it.text || '', done: !!it.done };
                    });
                } else {
                    items = [];
                }
                syncChips();
                renderItems();
            },
            getValue: function() { return items.map(function(it) { return { text: it.text, done: it.done }; }); },
            isFilled: function() { return items.length > 0; },
            destroy: function() {
                listeners.forEach(function(l) { l[0].removeEventListener(l[1], l[2]); });
            }
        };
    }

    // --------------------------------------------------------
    // Public API
    // --------------------------------------------------------
    return {
        tagList: tagList,
        checklist: checklist,
        multiSelect: multiSelect,
        dropzone: dropzone,
        keyValue: keyValue,
        guided: guided
    };
})();
