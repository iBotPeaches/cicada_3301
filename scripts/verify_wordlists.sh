#!/bin/bash

set -e

script_dir=$(cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd)
directory="$script_dir/../wordlists"

if [ ! -d "$directory" ]; then
    echo "Directory $directory does not exist."
    exit 1
fi

for file in "$directory"/*.txt; do
    if [ -f "$file" ]; then
        if ! sort -c "$file" > /dev/null 2>&1; then
            echo "File $file is NOT sorted."
            exit 1;
        fi
    fi
done

exit 0;
