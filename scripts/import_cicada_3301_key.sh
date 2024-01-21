#!/bin/bash

set -x

if gpg2 --recv-keys 67F363C61BA8FB6FDBA9C47D0670B0E57A35090F; then

    if [ "$CI" = "true" ]; then
        gpg -k
    fi

    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
