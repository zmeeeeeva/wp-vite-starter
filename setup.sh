#!/bin/bash

SEARCH_STRING='__THEME_NAME__'

# Load values from .env
THEME_NAME=$(grep '^THEME_NAME=' .env | cut -d '=' -f2-)

# Exit if either variable is empty
if [ -z "$THEME_NAME" ]; then
  echo "THEME_NAME not set in .env"
  exit 1
fi

THEME_DIR="web/app/themes/$SEARCH_STRING"
NEW_DIR="web/app/themes/$THEME_NAME"

if [[ ! -d "$THEME_DIR" ]]; then
    echo "Directory '$THEME_DIR' does not exist"
else
   mv "$THEME_DIR" "$NEW_DIR"
    echo "Renamed '$SEARCH_STRING' to '$THEME_NAME'"
fi

# Find & replace inside all files (text) under the new directory
# - skip binary files automatically
echo "Replacing '$SEARCH_STRING' → '$THEME_NAME' in file contents…"
grep -RIl "$SEARCH_STRING" "$NEW_DIR" \
  | xargs -r sed -i '' "s/${SEARCH_STRING}/${THEME_NAME}/g"

echo "All occurrences replaced."
