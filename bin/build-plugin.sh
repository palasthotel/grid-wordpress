#!/bin/sh

PLUGIN_SLUG="grid"
PROJECT_PATH=$(pwd)
BUILD_PATH="${PROJECT_PATH}/build"
DEST_PATH="$BUILD_PATH/$PLUGIN_SLUG"

echo "Generating build directory..."
rm -rf "$BUILD_PATH"
mkdir -p "$DEST_PATH"

echo "Syncing files..."
rsync -rL  "$PROJECT_PATH/public/" "$DEST_PATH/"

echo "Cleanup files..."
cd "$DEST_PATH"
composer install --no-cache
composer update --no-cache
composer dump-autoload
rm composer.json
rm composer.lock
rm lib/grid/.gitignore
rm lib/grid/Butlerfile
rm lib/grid/composer.json
rm lib/grid/package.json
rm lib/grid/package-lock.json
if [ -d lib/grid/node_modules ]; then
  rm -rf lib/grid/node_modules
fi
rm lib/grid/webpack*
rm -r lib/grid/src
rm -r lib/grid/scss

echo "Generating zip file..."
cd "$BUILD_PATH" || exit
zip -q -r "${PLUGIN_SLUG}.zip" "$PLUGIN_SLUG/"

cd "$PROJECT_PATH" || exit
mv "$BUILD_PATH/${PLUGIN_SLUG}.zip" "$PROJECT_PATH"
echo "${PLUGIN_SLUG}.zip file generated!"

echo "Cleanup build path..."
rm -rf "$BUILD_PATH"

echo "Build done!"