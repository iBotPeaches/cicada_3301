#!/bin/bash

set -x

script_dir=$(cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd)
key="$script_dir/../keys/67F363C61BA8FB6FDBA9C47D0670B0E57A35090F.asc.gpg"

if gpg2 --import "$key"; then
    echo "GPG key import successful!"
else
    echo "GPG key import failed."
    exit 1;
fi
