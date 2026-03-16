# Induzi — Documento de Referencia para IA

> Este documento descreve o sistema Induzi por completo. Se voce e uma IA lendo isto, aqui esta tudo que voce precisa para entender, navegar e modificar o projeto sem precisar de explicacao adicional do usuario.

---

## O que e o Induzi

Induzi e uma plataforma de **planejamento de sites** para profissionais de marketing digital. O usuario cria projetos (ex: "Loja da Maria") e preenche guias interativos cobrindo todas as areas necessarias para planejar um site — desde branding ate SEO, passando por seguranca, performance, copywriting, e-commerce, trafego pago, etc.

Cada guia e composto por secoes com campos interativos (listas, chave-valor, multi-select, upload de imagem). O progresso e salvo automaticamente no banco de dados e exibido por modulo no dashboard.

**Idioma**: Portugues brasileiro (pt-BR)
**Versao**: 1.0.0
**Stack**: PHP 7.4+ / MySQL / JavaScript vanilla (zero frameworks, zero build)
**Ambiente**: XAMPP local — `http://localhost/Projetos/painel/`

---

## Arquitetura Geral

```
Browser
  |
  app.php (SPA shell — carrega sidebar + 11 arquivos JS)
  |
  SpaRouter (History API)
  |--- fetch pages/modulo.php?fragment=1
  |       |
  |       fragment.php extrai <style>, <html>, <script> → retorna JSON
  |
  |--- InduziDB.save/load → api/data/save.php / load.php
  |       |
  |       MySQL: tabela project_data (JSON blobs por projeto)
  |
  |--- InduziAuth → api/auth/* + api/projects/*
          |
          MySQL: tabelas users, projects, project_users, sessions
```

**Tipo**: SPA com renderizacao server-side fragmentada. Cada pagina PHP serve HTML completo quando acessada diretamente, mas retorna JSON quando chamada com `?fragment=1` pelo SPA router.

---

## Estrutura de Arquivos

```
painel/
├── index.php                  # Redireciona para app.php ou install.php
├── app.php                    # Shell SPA (ponto de entrada principal)
├── login.php                  # Pagina de login (com forgot password)
├── reset-password.php         # Reset de senha com token
├── install.php                # Wizard de instalacao (cria 8 tabelas + admin)
├── config.php                 # Gerado pelo installer (credenciais MySQL)
├── version.php                # Constante INDUZI_VERSION ('1.0.0')
│
├── includes/
│   ├── db.php                 # getDB() — singleton PDO
│   ├── auth.php               # Guards: requireAuth(), requireProject(), isReadOnly()
│   ├── helpers.php            # jsonResponse(), getAllowedDataKeys(), logActivity(), etc
│   ├── fragment.php           # spaFragmentStart/End() + mapa de rotas
│   └── sidebar.php            # HTML: icon strip + sidebar + top bar
│
├── js/
│   ├── theme.js               # InduziTheme — claro/escuro/auto
│   ├── db.js                  # InduziDB — load/save com base64url encoding
│   ├── auth.js                # InduziAuth — sessao, projetos, favoritos, share
│   ├── modal-system.js        # Igris — alert/confirm/prompt/toast com focus trap
│   ├── components.js          # InduziComponents — 6 componentes interativos
│   ├── guide-presets.js       # InduziGuidePresets — sugestoes para campos guided
│   ├── search.js              # InduziSearch — overlay Ctrl+K com busca fuzzy
│   ├── shortcuts.js           # InduziShortcuts — Ctrl+K, Ctrl+S, Ctrl+E
│   ├── notifications.js       # InduziNotifications — sino + polling 60s
│   ├── onboarding.js          # InduziOnboarding — tour de 5 passos
│   └── spa.js                 # SpaRouter — navegacao SPA com cache de fragmentos
│
├── css/
│   ├── style.css              # Design system (variaveis CSS, layout, tipografia)
│   └── components.css         # Estilos dos componentes interativos
│
├── pages/                     # 24 paginas (18 guias + 6 utilitarias)
│   ├── index.php              # Dashboard (cards de modulos + grafico de progresso)
│   ├── projetos.php           # CRUD de projetos + compartilhamento
│   ├── configuracoes.php      # Perfil do usuario + preferencias
│   ├── atividades.php         # Timeline de atividades
│   ├── icones.php             # Biblioteca de icones SVG
│   ├── site-audit.php         # Auditoria de site (40 checks, 5 categorias)
│   ├── branding.php           # Guia: identidade visual (10 secoes)
│   ├── copywriter.php         # Guia: copywriting (16 secoes)
│   ├── estrutura.php          # Guia: arquitetura do site (14 secoes)
│   ├── seguranca.php          # Guia: seguranca web (22 secoes)
│   ├── seo.php                # Guia: SEO (12 secoes)
│   ├── conteudo.php           # Guia: estrategia de conteudo
│   ├── ux-design.php          # Guia: UX design
│   ├── performance.php        # Guia: performance e otimizacao
│   ├── acessibilidade.php     # Guia: acessibilidade WCAG
│   ├── infraestrutura.php     # Guia: hospedagem, DNS, deploy
│   ├── analytics.php          # Guia: GA4, GTM, metricas
│   ├── cro.php                # Guia: otimizacao de conversao
│   ├── google-ads.php         # Guia: Google Ads
│   ├── meta-ads.php           # Guia: Facebook/Instagram Ads
│   ├── email-marketing.php    # Guia: email marketing
│   ├── redes-sociais.php      # Guia: redes sociais
│   ├── shopee.php             # Guia: marketplace Shopee
│   └── mercado-livre.php      # Guia: marketplace Mercado Livre
│
├── api/
│   ├── auth/                  # login, logout, session, register, forgot/reset-password, change-password, update-prefs, update-profile
│   ├── data/                  # load, save, export-all, activity
│   ├── projects/              # list, create, update, delete, select, share, shared-users, duplicate
│   ├── notifications/         # list, mark-read
│   └── audit/                 # run (auditoria de site)
│
└── INDUZI.md                  # Este documento
```

---

## Banco de Dados (MySQL)

**Database**: `induzi` — 8 tabelas criadas pelo `install.php`

| Tabela | Funcao |
|--------|--------|
| `users` | Contas (id, nome, email, senha_hash, role, preferencias JSON) |
| `projects` | Projetos (id, nome, descricao, user_id) |
| `project_users` | Compartilhamento (project_id, user_id, permissao: editar/visualizar) |
| `project_data` | Dados dos modulos (project_id, data_key, data_value JSON) |
| `login_attempts` | Rate limiting (ip, email, attempted_at) |
| `password_resets` | Tokens de reset (email, token, 1h de expiracao) |
| `activity_log` | Auditoria (project_id, user_id, action, details JSON) |
| `notifications` | Notificacoes in-app (user_id, tipo, conteudo, lida) |

### Chaves de dados permitidas (project_data.data_key)

Guias: `induziCopywriter`, `induziEstrutura`, `induziSeguranca`, `induziSeo`, `induziShopee`, `induziBranding`, `induziGoogleAds`, `induziMercadoLivre`, `induziPerformance`, `induziAnalytics`, `induziUxDesign`, `induziAcessibilidade`, `induziConteudo`, `induziCro`, `induziEmailMarketing`, `induziRedesSociais`, `induziMetaAds`, `induziInfraestrutura`

Utilitarios: `induziConfig`, `induziProgressHistory`, `induziSiteAudit`

Reservados: `induziTarefas`, `induziLinks`, `induziConcorrentes`, `induziNotas`

---

## Fluxo do Usuario

```
1. index.php → config.php existe? → NAO → install.php (wizard 3 etapas)
                                   → SIM → app.php

2. app.php → sessao ativa? → NAO → login.php
                            → SIM → carrega shell SPA

3. Shell SPA carrega JS na ordem:
   theme → db → auth → modal-system → components → guide-presets →
   search → shortcuts → notifications → onboarding → spa

4. Script de init:
   InduziAuth.init() → InduziTheme.init() → populateSidebar() →
   InduziNotifications.init() → InduziOnboarding.autoTrigger() →
   SpaRouter.init()

5. SpaRouter resolve rota inicial:
   - Hash na URL (#copywriter) → navega para copywriter
   - Projeto selecionado → navega para #painel
   - Sem projeto → navega para #projetos
```

---

## SPA Router — Como Funciona

O `SpaRouter` (js/spa.js) intercepta cliques em links `href="#rota"` e carrega as paginas via fetch sem reload.

**24 rotas registradas** — cada uma com:
- `url`: caminho do arquivo PHP (`pages/modulo.php`)
- `title`: titulo da aba
- `requireProject`: precisa de projeto selecionado? (redireciona para #projetos se nao)
- `isModule`: e um modulo de guia? (controla visibilidade da sidebar de modulos)

**Fluxo de navegacao:**
1. Usuario clica em `<a href="#copywriter">`
2. SpaRouter chama `go('copywriter')` → `pushState` + `navigateTo()`
3. Injeta skeleton loader no `#spaContent`
4. Fetch `pages/copywriter.php?fragment=1`
5. Servidor (`fragment.php`) retorna JSON: `{ ok, styles, html, scripts }`
6. Router injeta CSS scoped no `<head>`, HTML no `#spaContent`, executa scripts
7. Atualiza sidebar, titulo, dispara evento `spa:routechange`
8. Resultado fica em cache (exceto `projetos` e `site-audit`)

**Cleanup**: Cada pagina define `window._spaCleanup = function() { ... }` para limpar timers e componentes ao sair.

---

## Sistema de Fragmentos

Toda pagina em `pages/` segue este padrao:

```php
<?php require_once __DIR__ . '/../includes/fragment.php'; spaFragmentStart(); ?>
<!-- ... HTML da pagina ... -->
<?php spaFragmentEnd(); ?>
```

- **Modo fragmento** (`?fragment=1`): `spaFragmentStart()` inicia buffer de saida. `spaFragmentEnd()` extrai `<style>`, conteudo dentro de `<div class="main-content">`, e `<script>` inline. Retorna JSON.
- **Modo standalone** (acesso direto): Redireciona usuarios logados para `app.php#rota`. Usuarios nao logados veem a pagina completa com sidebar.

---

## Objetos JavaScript Globais

### InduziTheme (js/theme.js)
Gerencia tema claro/escuro/auto. Salva em `localStorage.induzi_tema` e sincroniza com `users.preferencias.tema` no backend.

### InduziDB (js/db.js)
Camada de dados. Faz load/save de JSON via API.
- `load(key, defaultData)` → GET `api/data/load.php?key=...`
- `save(key, data)` → POST `api/data/save.php` com payload base64url-encoded
- Cache em memoria `_cache[key]` para evitar refetch

**Por que base64?** Evita problemas com payloads JSON grandes sendo corrompidos pelo PHP input stream.

### InduziAuth (js/auth.js)
Autenticacao + CRUD de projetos + favoritos + compartilhamento.
- `init()` → busca sessao via `api/auth/session.php`
- `selectProject(id)` → define projeto ativo na sessao
- `switchProject()` → limpa projeto → navega para #projetos
- `toggleFavorito(route)` → adiciona/remove de `preferencias.favoritos`
- `populateSidebar()` → renderiza nome do projeto, avatar, favoritos

### Igris (js/modal-system.js)
Sistema de modais. Funcoes: `alert()`, `confirm()`, `prompt()`, `toast()`. Todas retornam Promises. Tem focus trap e ARIA.

### InduziComponents (js/components.js)
6 componentes interativos reutilizaveis. Cada um retorna `{ setValue, getValue, isFilled, destroy }`.

| Componente | Funcao | Uso tipico |
|------------|--------|------------|
| `guided` | Lista com sugestoes/templates | Maioria dos campos dos guias |
| `keyValue` | Editor chave-valor | Formula de preco, prazos, respostas |
| `multiSelect` | Multi-selecao com chips | Modalidades de envio, tipos de promo |
| `dropzone` | Upload de imagem com preview | Logo, banner |
| `tagList` | Tags com enter/backspace | Keywords, categorias |
| `checklist` | Checklist arrastavel | Tarefas, itens |

### SpaRouter (js/spa.js)
Navegacao SPA. Ver secao "SPA Router" acima.

### InduziSearch (js/search.js)
Overlay de busca global (Ctrl+K). Indice estatico de 200+ itens. Busca fuzzy com navegacao por teclado.

### InduziShortcuts (js/shortcuts.js)
Atalhos: Ctrl+K (busca), Ctrl+S (salvar modulo), Ctrl+E (exportar modulo).

### InduziNotifications (js/notifications.js)
Sino no top bar. Polling de 60s em `api/notifications/list.php`. Mark-read via `api/notifications/mark-read.php`.

### InduziOnboarding (js/onboarding.js)
Tour de 5 passos com spotlight para novos usuarios. Controlado por `preferencias.onboardingCompleto`.

### InduziGuidePresets (js/guide-presets.js)
Sugestoes e templates para o componente `guided`. Estrutura: `{ 'copywriter': { 'puv.produto': { suggestions: [], templates: [] } } }`.

---

## Padrao de um Modulo Guia

Todos os 18 guias seguem **exatamente** o mesmo padrao. Referencia: `pages/google-ads.php`, `pages/branding.php`.

### HTML
```html
<!-- Secao colapsavel -->
<div class="doc-section" id="section-nomeSecao">
    <div class="doc-section-header" onclick="toggleSection('nomeSecao')">
        <span class="doc-section-badge" id="badge-nomeSecao">0/4</span>
        <h3>Titulo da Secao</h3>
        <svg class="chevron">...</svg>
    </div>
    <div class="doc-section-body">
        <p class="doc-section-desc">Descricao explicativa da secao.</p>
        <div class="doc-field"><label>Nome do campo</label><div id="comp-nomeSecao-nomeCampo"></div></div>
        <div class="doc-field">
            <label>Campo com dica</label>
            <div id="comp-nomeSecao-nomeCampo2"></div>
            <div class="field-hint">Dica contextual sobre o campo</div>
        </div>
    </div>
</div>
```

### CSS (inline no `<style>`)
Cada modulo repete o mesmo bloco de CSS scoped (classes `.doc-section`, `.doc-field`, `.doc-toolbar`, etc). Inclui `.field-hint` para dicas.

### JavaScript
```javascript
(function() {
    var DATA_KEY = 'induziNomeModulo';
    var _saveTimer = null;
    var _data = {};
    var _components = {};
    var presets = (window.InduziGuidePresets && InduziGuidePresets['nome-modulo']) || {};

    function onChange() { /* coleta valores → updateProgress → debounce save */ }
    function updateProgress() { /* conta campos preenchidos → atualiza badges e barra */ }
    function populateAll() { /* popula componentes com dados salvos */ }

    // Helpers para registro de componentes (reduz repeticao)
    function g(id, key, ph) { /* InduziComponents.guided() */ }
    function kv(id, key, kl, vl) { /* InduziComponents.keyValue() */ }
    function ms(id, key, opts) { /* InduziComponents.multiSelect() */ }
    function dz(id, key, accept, max) { /* InduziComponents.dropzone() */ }

    window.exportarModulo = async function() { /* exporta JSON */ };
    window.importarModulo = async function(input) { /* importa JSON */ };

    async function init() {
        // Registra todos os componentes usando helpers g(), kv(), ms(), dz()
        g('comp-secao-campo', 'secao.campo', 'Placeholder...');
        kv('comp-secao-campo2', 'secao.campo2', 'Chave', 'Valor');

        var saved = await InduziDB.load(DATA_KEY);
        if (saved) { _data = saved; populateAll(); }
        updateProgress();
    }

    init();
    window._spaCleanup = function() {
        if (_saveTimer) clearTimeout(_saveTimer);
        for (var key in _components) _components[key].destroy();
    };
})();
```

### Convencoes dos IDs
- Container do componente: `comp-{secao}-{campo}` (ex: `comp-preco-formula`)
- Secao: `section-{secao}` (ex: `section-preco`)
- Badge: `badge-{secao}` (ex: `badge-preco`)
- Chave do componente: `{secao}.{campo}` (ex: `preco.formula`)

---

## API — Endpoints

Todos retornam JSON: `{ ok: true/false, ... }`. POST requer CSRF (header `X-Requested-With: XMLHttpRequest`).

### Autenticacao
| Metodo | Endpoint | Funcao |
|--------|----------|--------|
| POST | `api/auth/login.php` | Login (rate limited: 20/IP, 5/email por 15min) |
| POST | `api/auth/logout.php` | Logout |
| GET | `api/auth/session.php` | Dados da sessao + CSRF token |
| POST | `api/auth/register.php` | Registro (admin only) |
| POST | `api/auth/forgot-password.php` | Gera token de reset |
| POST | `api/auth/reset-password.php` | Reseta senha com token |
| POST | `api/auth/change-password.php` | Troca senha |
| POST | `api/auth/update-prefs.php` | Atualiza preferencias do usuario |
| POST | `api/auth/update-profile.php` | Atualiza perfil |

### Dados
| Metodo | Endpoint | Funcao |
|--------|----------|--------|
| GET | `api/data/load.php?key=...` | Carrega dados do projeto por chave |
| POST | `api/data/save.php` | Salva dados (body: base64url do JSON) |
| GET | `api/data/export-all.php` | Exporta todos os dados do projeto |
| GET | `api/data/activity.php?page=&limit=` | Log de atividades paginado |

### Projetos
| Metodo | Endpoint | Funcao |
|--------|----------|--------|
| GET | `api/projects/list.php` | Lista projetos (proprios + compartilhados) |
| POST | `api/projects/create.php` | Cria projeto |
| POST | `api/projects/update.php` | Atualiza projeto |
| POST | `api/projects/delete.php` | Deleta projeto (cascade) |
| POST | `api/projects/select.php` | Seleciona projeto ativo na sessao |
| POST | `api/projects/share.php` | Adiciona/remove usuario compartilhado |
| GET | `api/projects/shared-users.php` | Lista usuarios com acesso |
| POST | `api/projects/duplicate.php` | Duplica projeto + todos os dados |

### Outros
| Metodo | Endpoint | Funcao |
|--------|----------|--------|
| GET | `api/notifications/list.php` | Notificacoes do usuario |
| POST | `api/notifications/mark-read.php` | Marca notificacao como lida |
| POST | `api/audit/run.php` | Auditoria de site (40 checks, 5 categorias) |

---

## Fluxo de Dados (Exemplo: Salvar Copywriter)

```
1. Usuario preenche campo no guia
2. onChange() → coleta valores dos componentes → atualiza _data
3. Debounce 1s → InduziDB.save('induziCopywriter', _data)
4. InduziDB codifica payload como base64url
5. POST api/data/save.php com body text/plain
6. Servidor decodifica base64 → valida key no whitelist → INSERT/UPDATE project_data
7. logActivity() registra 'data.save' na activity_log
```

---

## Autenticacao e Seguranca

- **Sessao**: Cookie 8h, idle timeout 2h, `session_regenerate_id()` no login
- **CSRF**: Token de 64 chars na sessao. Validado em todo POST via header `X-Requested-With` ou `X-CSRF-Token`
- **Rate limiting**: 20 tentativas/IP e 5/email por 15min na tabela `login_attempts`
- **Senhas**: bcrypt via `password_hash()` / `password_verify()`
- **SQL Injection**: Prepared statements PDO em todo lugar
- **SSRF**: Validacao de URL no site-audit (bloqueia IPs privados)
- **Read-only**: Usuarios com permissao `visualizar` recebem 403 ao tentar salvar

---

## Sistema de Temas (CSS)

- Light: `:root { --color-bg: #f8f9fa; --color-white: #fff; ... }`
- Dark: `[data-theme="escuro"] { --color-bg: #1a1a2e; --color-white: #16213e; ... }`
- Aplicado via `document.documentElement.setAttribute('data-theme', 'escuro')`
- Ciclo: claro → escuro → auto (segue `prefers-color-scheme` do OS)
- Salvo em `localStorage.induzi_tema` + `users.preferencias.tema`
- Script inline no `<head>` aplica tema antes do render (evita flash)

---

## Layout

```
┌─────────────────────────────────────────────────────┐
│ Top Bar (60px) — avatar, nome, trocar projeto, sair │
├──────┬──────────┬───────────────────────────────────┤
│ Icon │ Sidebar  │                                   │
│ Strip│ (240px)  │        Main Content               │
│(56px)│ modulos  │        #spaContent                │
│      │ favoritos│                                   │
│      │ secoes   │                                   │
│      │          │                                   │
│ gear │ version  │                                   │
└──────┴──────────┴───────────────────────────────────┘
```

- Mobile (<768px): Sidebar colapsa, toggle hamburger
- `sidebar-collapsed`: Esconde sidebar, so mostra icon strip
- Print: Esconde sidebar/toolbar, abre todas as secoes

---

## Como Adicionar um Novo Modulo Guia

1. **Criar `pages/novo-modulo.php`** seguindo o padrao de `google-ads.php`/`branding.php`
2. **`includes/helpers.php`**: Adicionar `'induziNovoModulo'` no array `getAllowedDataKeys()`
3. **`includes/fragment.php`**: Adicionar `'novo-modulo.php' => 'novo-modulo'` no `$_spaRouteMap`
4. **`js/spa.js`**: Adicionar rota `'novo-modulo'` no objeto `ROUTES`
5. **`includes/sidebar.php`**: Adicionar no `$_sbHashMap` + `<li>` na nav
6. **`pages/index.php`**: Adicionar card no dashboard + adicionar key/route/label nos 3 arrays de progresso (loadProgress + saveProgressSnapshot)

### Checklist de consistencia do modulo
- [ ] CSS inclui `.field-hint`
- [ ] Section headers em multi-linha (badge, h3, chevron separados)
- [ ] Toolbar em multi-linha
- [ ] Sem `<script src="components.js">` (carregado globalmente pelo app.php)
- [ ] JS usa helpers `g()`, `kv()`, `ms()`, `dz()` em vez de inline repetitivo
- [ ] JS formatado multi-linha (nao comprimido)
- [ ] Placeholders sem "(Enter)" — formato limpo
- [ ] Field hints nas dicas mais relevantes
- [ ] `window._spaCleanup` definido
- [ ] Export/import com nome do modulo correto

---

## Rotas do SPA (24 total)

### Guias (requireProject: true, isModule: true) — 19 rotas
| Rota | Arquivo | Data Key |
|------|---------|----------|
| `painel` | pages/index.php | — (dashboard) |
| `branding` | pages/branding.php | `induziBranding` |
| `copywriter` | pages/copywriter.php | `induziCopywriter` |
| `estrutura` | pages/estrutura.php | `induziEstrutura` |
| `seguranca` | pages/seguranca.php | `induziSeguranca` |
| `seo` | pages/seo.php | `induziSeo` |
| `conteudo` | pages/conteudo.php | `induziConteudo` |
| `ux-design` | pages/ux-design.php | `induziUxDesign` |
| `performance` | pages/performance.php | `induziPerformance` |
| `acessibilidade` | pages/acessibilidade.php | `induziAcessibilidade` |
| `infraestrutura` | pages/infraestrutura.php | `induziInfraestrutura` |
| `analytics` | pages/analytics.php | `induziAnalytics` |
| `cro` | pages/cro.php | `induziCro` |
| `google-ads` | pages/google-ads.php | `induziGoogleAds` |
| `meta-ads` | pages/meta-ads.php | `induziMetaAds` |
| `email-marketing` | pages/email-marketing.php | `induziEmailMarketing` |
| `redes-sociais` | pages/redes-sociais.php | `induziRedesSociais` |
| `shopee` | pages/shopee.php | `induziShopee` |
| `mercado-livre` | pages/mercado-livre.php | `induziMercadoLivre` |

### Utilitarias (requireProject: false, isModule: false) — 3 rotas
| Rota | Arquivo |
|------|---------|
| `projetos` | pages/projetos.php |
| `icones` | pages/icones.php |
| `configuracoes` | pages/configuracoes.php |

### Ferramentas (requireProject: true, isModule: false) — 2 rotas
| Rota | Arquivo |
|------|---------|
| `atividades` | pages/atividades.php |
| `site-audit` | pages/site-audit.php |

---

## Sidebar — Organizacao dos Modulos

```
Favoritos (dinamico, baseado em preferencias do usuario)

Modulos
├── Painel
├── Branding
├── Copywriter
├── Estrutura
├── Seguranca
├── SEO
├── Conteudo
├── UX Design
├── Performance
├── Acessibilidade
├── Infraestrutura
├── Analytics
└── CRO

Trafego e Marketing
├── Google Ads
├── Meta Ads
├── Email Marketing
└── Redes Sociais

Marketplaces
├── Shopee
└── Mercado Livre
```

---

## Convencoes de Nomenclatura

| Contexto | Padrao | Exemplo |
|----------|--------|---------|
| Objetos JS globais | PascalCase | `InduziAuth`, `SpaRouter`, `Igris` |
| Funcoes JS | camelCase | `toggleSection`, `exportarModulo` |
| Tabelas MySQL | snake_case | `project_data`, `login_attempts` |
| Colunas MySQL | snake_case | `user_id`, `data_key`, `senha_hash` |
| Classes CSS | kebab-case | `doc-section-header`, `dash-card` |
| Data keys | camelCase com prefixo | `induziCopywriter`, `induziConfig` |
| IDs de componentes | `comp-{secao}-{campo}` | `comp-preco-formula` |
| Rotas SPA | kebab-case | `mercado-livre`, `email-marketing` |
| Arquivos PHP | kebab-case | `mercado-livre.php`, `site-audit.php` |

---

## Features Implementadas

- Login/logout com rate limiting e sessao segura
- Reset de senha por token (1h de expiracao)
- CRUD de projetos com compartilhamento (editar/visualizar)
- Duplicacao de projeto (clona todos os dados)
- 18 modulos guia com campos interativos e auto-save
- Dashboard com cards de progresso por modulo (%)
- Grafico SVG de progresso ao longo do tempo (max 365 dias)
- Exportar/importar modulo individual (JSON)
- Exportar/importar projeto completo (JSON)
- Busca global Ctrl+K com indice de 200+ itens
- Atalhos de teclado (Ctrl+S salvar, Ctrl+E exportar)
- Tema claro/escuro/auto com sync entre dispositivos
- Favoritos/pins na sidebar
- Timeline de atividades com log de auditoria
- Notificacoes in-app com polling de 60s
- Tour de onboarding (5 passos) para novos usuarios
- Tooltips contextuais (atributo `data-tooltip`)
- Skeletons de carregamento durante transicoes SPA
- Auditoria de site (40 checks, 5 categorias, score ring SVG)
- Suporte a impressao (CSS print otimizado)
- Acessibilidade (ARIA, focus trap, focus-visible)
- Responsivo (sidebar colapsa em mobile)
