# Data Recover Free

A searchable, filterable directory of **free and open-source data-recovery
software** — the S2 in-browser repair suite plus battle-tested classics like
TestDisk, PhotoRec, GNU ddrescue, Scalpel, and Foremost. It also bundles the
**S2 File Identifier**: drop a corrupt file on the page and it reads the magic
numbers, separates concatenated/embedded pieces, and points you at the right
recovery tool — filtering the directory to match.

🌐 **Live:** https://socrtwo.github.io/datarecoverfree-SF/
📦 **Downloads:** [Releases](https://github.com/socrtwo/datarecoverfree-SF/releases)
📂 **Source:** [socrtwo/datarecoverfree-SF](https://github.com/socrtwo/datarecoverfree-SF)

Everything is **100% client-side** — plain HTML/CSS/JS, no frameworks, no
server, no upload. The app is an installable PWA and works offline after the
first visit.

## Using the app

- **Search** by name, description, or tag.
- **Filter** by what a tool repairs (Word, Excel, PowerPoint, OpenDocument,
  ZIP, XML, disks, file carving, anything) and by operating system.
- **Identify a corrupt file:** choose a file in the feature box at the top.
  The identifier analyzes it locally, offers any embedded/concatenated pieces
  for download, and highlights the recommended repair tools in the directory.

## Adding or editing directory entries

The whole directory lives in one versioned JSON file:
[`web/data/software.json`](web/data/software.json). To add software, append an
object to the `entries` array (and bump `version`):

```json
{
  "id": "my-tool",
  "name": "My Recovery Tool",
  "description": "One or two sentences on what it recovers and how.",
  "categories": ["word"],
  "os": ["web", "windows"],
  "license": "GPL-3.0",
  "homepage": "https://example.org/my-tool/",
  "source": "https://example.org/my-tool/source",
  "tags": ["docx", "repair"]
}
```

- `categories` and `os` must use ids declared in the `categories` / `oses`
  arrays at the top of the same file (add new ones there if needed).
- `id` must be unique. For S2-suite tools, use the program key from
  `web/s2-file-id.js` so the identifier widget can highlight the entry.
- `source` and `tags` are optional.

CI validates the JSON on every push. If you change any cached asset, bump the
cache version in `web/sw.js` so returning users don't see stale code.

## Running locally

```bash
cd web
python3 -m http.server 8080
# open http://localhost:8080
```

(Serving over HTTP is needed for `fetch()` of the JSON and the service
worker; release bundles additionally include a generated
`data/software.data.js` fallback so they work from `file://` too.)

## Releasing

Platform bundles (Windows, macOS, Linux, ChromeOS, Android, iOS, Web) are
built by [`scripts/build-releases.sh`](scripts/build-releases.sh) and
published by the
[Release workflow](.github/workflows/release.yml):

- **Actions → "Build & publish multi-platform releases" → Run workflow** with
  a version like `v1.0.0`, **or**
- push a tag: `git tag v1.0.0 && git push origin v1.0.0`.

Each bundle is the same static app plus a small per-platform launcher;
`SHA256SUMS` is attached for verification. To build locally:
`bash scripts/build-releases.sh vTEST` (output in `dist/`).

GitHub Pages deploys `web/` automatically on every push to `main`
([`pages.yml`](.github/workflows/pages.yml)).

## Repo map

- `web/` — the app: `index.html`, `app.js`, `data/software.json`,
  `s2-file-id.js` (shared S2 File Identifier), PWA bits
  (`manifest.webmanifest`, `sw.js`, icons).
- `scripts/` — release packaging (`build-releases.sh`, `gen-icons.py`,
  per-platform `launchers/`).
- `legacy/` — the original 2013 SourceForge PHP + MySQL directory site,
  preserved for history (see [`legacy/README.md`](legacy/README.md)).
- `.github/workflows/` — CI (`build.yml`), Pages deploy (`pages.yml`),
  releases (`release.yml`).

## Heritage

Data Recover Free began life on SourceForge as
[Datarecoverfree](https://sourceforge.net/projects/datarecoverfree/), an
open-source PHP/MySQL freeware-directory script with configurable categories
and user + webmaster ratings. Server-side PHP can't ship as cross-platform
downloads, so the project was remade (with the owner's blessing) as this
static, client-side app; the JSON data model mirrors the old `softwares` /
`categories` / `os` database tables. The original source is kept in
[`legacy/`](legacy/).

**License:** MIT — see [LICENSE](LICENSE).
