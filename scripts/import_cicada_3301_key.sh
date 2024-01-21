#!/bin/bash

set -x

key="$(pwd)/messages/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc"

if gpg2 --allow-non-selfsigned-uid --import-options show-only --import "$key"; then

    if [ "$CI" = "true" ]; then
        for fpr in $(gpg2 --list-keys --with-colons  | awk -F: '/fpr:/ {print $10}' | sort -u); do
          echo -e "y\ny\n" |  gpg2 --command-fd 0 --expert --edit-key "$fpr" sign;
        done

        gpg --list-keys
    fi

    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
