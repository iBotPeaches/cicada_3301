#!/bin/bash

directory="$(pwd)/messages"
for subfolder in "$directory"/*; do
    if [ -d "$subfolder" ]; then
        cd "$subfolder" || exit

        for file in *; do
            if [ -f "$file" ]; then
                echo "Verifying GPG integrity of: $(basename "$subfolder"/"$file")"

                if gpg --verify "$file" 2>/dev/null; then
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
