#!/usr/bin/env bash
# Build platform-specific release bundles from the contents of web/.
#
# Usage:  scripts/build-releases.sh [VERSION]
#         scripts/build-releases.sh v1.0.0
#
# Output goes to dist/ and is overwritten each run.

set -euo pipefail

VERSION="${1:-${GITHUB_REF_NAME:-v0.0.0-dev}}"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"
WEB="$ROOT/web"
LAUNCHERS="$ROOT/scripts/launchers"
DIST="$ROOT/dist"
STAGE="$DIST/_stage"

if [[ ! -d "$WEB" ]]; then
  echo "ERROR: web/ folder not found at $WEB" >&2
  exit 1
fi

# Ensure PWA icons exist (regenerate if missing).
if [[ ! -f "$WEB/icon-192.png" || ! -f "$WEB/icon-512.png" || ! -f "$WEB/icon-maskable.png" ]]; then
  python3 "$ROOT/scripts/gen-icons.py"
fi

# Generate the file:// fallback data file (window.SOFTWARE_DATA) from the
# canonical JSON so offline bundles work when opened straight from disk.
python3 - "$WEB/data/software.json" "$WEB/data/software.data.js" <<'PY'
import json, sys
src, dst = sys.argv[1], sys.argv[2]
with open(src, encoding='utf-8') as f:
    data = json.load(f)
with open(dst, 'w', encoding='utf-8') as f:
    f.write('// Generated from software.json by build-releases.sh - do not edit.\n')
    f.write('window.SOFTWARE_DATA = ')
    json.dump(data, f, ensure_ascii=False, indent=2)
    f.write(';\n')
print(f"Wrote {dst}")
PY

rm -rf "$DIST"
mkdir -p "$DIST" "$STAGE"

stage() {
  local name="$1"
  local platform="$2"
  local target="$STAGE/$name"
  rm -rf "$target"
  mkdir -p "$target/web"
  cp -r "$WEB/." "$target/web/"
  if [[ -d "$LAUNCHERS/$platform" ]]; then
    cp -r "$LAUNCHERS/$platform/." "$target/"
  fi
  # Stamp version
  printf '%s\n' "$VERSION" > "$target/VERSION"
  echo "$target"
}

write_zip() {
  local src="$1" out="$2"
  ( cd "$src" && zip -qr "$out" . )
  echo "  -> $(basename "$out")"
}

write_tar() {
  local src="$1" out="$2"
  ( cd "$src" && tar -czf "$out" . )
  echo "  -> $(basename "$out")"
}

echo "Building releases for $VERSION"
echo "Source: $WEB"
echo

# Windows
echo "[windows]"
WIN_DIR="$(stage datarecoverfree-windows windows)"
write_zip "$WIN_DIR" "$DIST/datarecoverfree-${VERSION}-windows.zip"

# macOS
echo "[macos]"
MAC_DIR="$(stage datarecoverfree-macos macos)"
chmod +x "$MAC_DIR/DataRecoverFree.command" 2>/dev/null || true
write_zip "$MAC_DIR" "$DIST/datarecoverfree-${VERSION}-macos.zip"

# Linux
echo "[linux]"
LIN_DIR="$(stage datarecoverfree-linux linux)"
chmod +x "$LIN_DIR/datarecoverfree.sh" 2>/dev/null || true
write_tar "$LIN_DIR" "$DIST/datarecoverfree-${VERSION}-linux.tar.gz"

# ChromeOS
echo "[chromeos]"
CROS_DIR="$(stage datarecoverfree-chromeos chromeos)"
write_zip "$CROS_DIR" "$DIST/datarecoverfree-${VERSION}-chromeos.zip"

# Android
echo "[android]"
ANDROID_DIR="$(stage datarecoverfree-android android)"
write_zip "$ANDROID_DIR" "$DIST/datarecoverfree-${VERSION}-android.zip"

# iOS
echo "[ios]"
IOS_DIR="$(stage datarecoverfree-ios ios)"
write_zip "$IOS_DIR" "$DIST/datarecoverfree-${VERSION}-ios.zip"

# Web (just the static site, no launcher)
echo "[web]"
WEB_DIR_STAGE="$(stage datarecoverfree-web web)"
write_zip "$WEB_DIR_STAGE" "$DIST/datarecoverfree-${VERSION}-web.zip"

# Generate SHA-256 sums
echo
echo "Generating SHA256SUMS"
( cd "$DIST" && sha256sum *.zip *.tar.gz 2>/dev/null > SHA256SUMS )
cat "$DIST/SHA256SUMS"

# Cleanup staging
rm -rf "$STAGE"

echo
echo "Done. Artifacts in $DIST"
ls -la "$DIST"
