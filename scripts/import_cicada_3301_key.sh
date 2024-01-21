#!/bin/bash

key="$(pwd)/messages/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc"

if gpg --import-options show-only --import "$key"; then
    for fpr in $(gpg --list-keys --with-colons  | awk -F: '/fpr:/ {print $10}' | sort -u); do
      echo -e "y\ny\n" |  gpg --command-fd 0 --expert --edit-key "$fpr" sign;
    done

    gpg --list-keys

    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
