#!/bin/bash

set -e

script_dir=$(cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd)
directory="$script_dir/../messages"
key="$script_dir/../keys/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc.gpg"

find "$directory" -type d -print0 | while IFS= read -r -d '' subfolder; do
    if [ -d "$subfolder" ]; then
        cd "$subfolder" || exit

        for file in *.asc; do
            if [ -f "$file" ] && [ -f "$key" ]; then
                echo "Verifying GPG integrity of: $(basename "$subfolder"/"$file")"

                if gpgv --keyring "$key" "$file"; then
                    echo "Verification successful!"
                else
                    echo "Verification failed. GPG signature may be invalid."
                    exit 1;
                fi

                echo "----------------------------------------"
            fi
        done

        cd "$directory" || exit
    fi
done
