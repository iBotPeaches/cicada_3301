#!/bin/bash

set -e

script_dir=$(cd -- "$( dirname -- "${BASH_SOURCE[0]}" )" &> /dev/null && pwd)
directory="$script_dir/../iso"
decoded_directory="$directory/unpacked"
iso_hash="74062dee4093c6ca0340cda23f0e994b"
iso_url="https://connortumbleson.com/uploads/2024/01/3301.iso"
iso_file="$directory/3301.iso"

if [ -f "$iso_file" ]; then
  md5=$(md5sum "$iso_file" | awk '{print $1}')

  if [ "$md5" != "$iso_hash" ]; then
    echo "MD5 hash of $iso_file does not match expected hash. Please remove the file and try again."
    exit 1
  fi

  if [ ! -d "$decoded_directory" ]; then
    mkdir -p "$decoded_directory"

    7z x -o"$decoded_directory" "$iso_file"

    # Remove files unrelated to puzzle.
    rm -rf "$decoded_directory/[BOOT]"
    rm -rf "$decoded_directory/BOOT"
  fi

  exit 0;
fi

wget -O "$iso_file" "$iso_url"
