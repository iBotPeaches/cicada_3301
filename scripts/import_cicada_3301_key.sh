#!/bin/bash

key="$(pwd)/messages/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc"

if gpg --import-options show-only --import "$key"; then
    gpg --list-keys --fingerprint |grep pub -A 1|grep -Ev "pub|--"|tr -d ' ' \
    | awk 'BEGIN { FS = "\n" } ; { print $1":6:" } ' | gpg --import-ownertrust

    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
