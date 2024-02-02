#!/bin/bash

set -e

directory="wordlists"

if [ ! -d "$directory" ]; then
    echo "Directory $directory does not exist."
    exit 1
fi

for file in "$directory"/*.txt; do
    if [ -f "$file" ]; then
      sort -f -u -o "$file" "$file"
    fi
done

exit 0;
