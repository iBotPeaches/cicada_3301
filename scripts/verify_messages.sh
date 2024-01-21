#!/bin/bash

set -e

key="$(pwd)/messages/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc.gpg"
directory="$(pwd)/messages"
for subfolder in "$directory"/*; do
    if [ -d "$subfolder" ]; then
        cd "$subfolder" || exit

        for file in *; do
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
