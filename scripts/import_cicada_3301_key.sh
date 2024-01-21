#!/bin/bash

set -x

key="$(pwd)/messages/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc"

if gpg2 --allow-non-selfsigned-uid --import-options show-only --import "$key"; then

    if [ "$CI" = "true" ]; then
        gpg -k
    fi

    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
