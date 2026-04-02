# INDUZI — Instrucoes para Claude Code

## Projeto
- **INDUZI** — Design Autoral & Arquitetura de Interiores
- **Stack:** PHP 8.2 (XAMPP), MariaDB 10.4, Igris Framework
- **Repo:** https://github.com/brunoduzi90/induzi (branch: master)
- **Producao:** https://induzi.studio (Hostinger)

## Arquitetura
```
config.php           — DB credentials (gitignored, NAO commitar)
version.php          — INDUZI_VERSION + INDUZI_VERSION_DATE
update-manifest.json — manifest de atualizacao (versao, SHA256, changelog)
includes/            — db.php, auth.php, helpers.php, fragment.php, sidebar.php
admin/               — SPA shell (app.php, login.php, pages/, api/, js/, css/)
public/              — Front controller (index.php, assets/)
```

## Como fazer Release (comando: /release)

Quando o usuario pedir para fazer release, commitar, publicar, ou deploy, siga TODOS estes passos em ordem:

### 1. Bump de versao
- Editar `version.php`: incrementar `INDUZI_VERSION` (semver) e atualizar `INDUZI_VERSION_DATE` com data atual
- Formato: `define('INDUZI_VERSION', 'X.Y.Z');`

### 2. Gerar ZIP
```bash
"C:/xampp/php/php.exe" "C:/xampp/htdocs/Site/gerar-pacote-cli.php"
```
- Gera `sys_temp/induzi-update-X.Y.Z.zip`

### 3. Calcular SHA256 e tamanho
```bash
"C:/xampp/php/php.exe" -r "echo hash_file('sha256', 'C:/xampp/htdocs/Site/sys_temp/induzi-update-X.Y.Z.zip') . '|' . filesize('C:/xampp/htdocs/Site/sys_temp/induzi-update-X.Y.Z.zip');"
```

### 4. Atualizar update-manifest.json
- Atualizar `version`, `date`, `download_url`, `file_size`, `sha256`
- `download_url`: `https://github.com/brunoduzi90/induzi/releases/download/vX.Y.Z/induzi-update-X.Y.Z.zip`
- Adicionar entrada no `changelog` array (no INICIO, versao mais recente primeiro)
- Manter changelog das versoes anteriores

### 5. Git commit + push
```bash
git add <arquivos-modificados> version.php update-manifest.json
git commit -m "release: vX.Y.Z — <descricao curta>"
git push origin master
```
- Incluir `Co-Authored-By: Claude Opus 4.6 <noreply@anthropic.com>` no commit
- NAO usar `git add .` (pode incluir arquivos sensíveis)

### 6. Criar GitHub Release
```bash
gh release create vX.Y.Z "sys_temp/induzi-update-X.Y.Z.zip" --title "INDUZI vX.Y.Z" --notes "<release notes>"
```
- Se ja existir release com o mesmo tag: `gh release delete vX.Y.Z --yes` antes de criar

### 7. Confirmar ao usuario
- Informar a URL do release
- Informar que pode atualizar pelo painel admin (Atualizacao → Verificar Novamente)

## Regras importantes
- **PHP CLI:** sempre usar `"C:/xampp/php/php.exe"` (nao `php`)
- **Session key:** `induzi_user` (nao igris_user)
- **app.php:** DEVE ter `session_write_close()` apos auth check (previne session lock nos fragments)
- **Fragment pages:** DEVEM chamar `session_write_close()` apos `requireAuth()`
- **config.php:** NUNCA commitar (tem credenciais DB)
- **BASE_URL:** dinamico via `dirname(SCRIPT_NAME)`, NAO hardcodar `/Site`
- **CSS/JS cache busting:** via `?v=<?= INDUZI_VERSION ?>`
