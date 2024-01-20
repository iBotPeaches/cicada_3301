#!/bin/bash

key="$(pwd)/messages/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc"

if gpg -v --import "$key"; then
    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
