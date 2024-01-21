#!/bin/bash

if ! command -v outguess &> /dev/null; then
    echo "outguess could not be found"
    exit 1
fi

images=$(pwd)/liber_primus
messages=$(pwd)/messages/2014/liber_primus

for image in "$images"/*; do
    if [ -f "$image" ]; then
        echo "Extracting message from: $(basename "$image")"

        if outguess -r "$image" "$messages/$(basename "$image").asc"; then
            echo "Message extracted successfully"
        else
            rm "$messages/$(basename "$image").asc";
        fi

        echo "----------------------------------------"
    fi
done
