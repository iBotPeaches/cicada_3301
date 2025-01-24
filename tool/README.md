# PHP Application for Cicada 3301
_Liber Primus decoding and some helper scripts for Cicada 3301 puzzles._

### Commands

* `php cicada app:bruteforce-audio-steganography` - Iterates dictionary words to guess a key with various audio stenography tools.
* `php cicada app:bruteforce-column-key` - Iterates columns to guess a column transposition key.
* `php cicada app:bruteforce-prime-cipher` - Iterates prime numbers (+ shift) to guess a key.
* `php cicada app:bruteforce-rotation-cipher` - Iterates rotation ciphers in both Gematria and ASCII alphabet.
* `php cicada app:bruteforce-vigenere` - Iterates wordlists to guess a Vinegere key.
* `php cicada app:bruteforce-xor` - Iterates files from puzzles to attempt XOR against a ciphertext.
* `php cicada app:build-prompt` - Builds a prompt for OpenAI to ease Rune OCR.
* `php cicada app:generate-gematria-primus-table` - Builds a text based Gematria Primus.
* `php cicada app:midi-solve` - Solves the MIDI puzzle.
* `php cicada app:permutation` - Permutes a string based on Gematria values.
* `php cicada app:rotation-cipher` - Given a runic sentence and preferred rotation, decodes a rotation cipher.
* `php cicada app:to-runic` - Converts a string to runic.
* `php cicada app:translate` - Translation from runic to English using Gematria values.
* `php cicada app:vigenere` - Decodes a Vigenere cipher using a key and skip indexes from Gematria values.
* `php cicada app:visualize-runes` - Visualizes a runic sentence with letters, indexes and Gematria values.
* `php cicada app:wordlists` - Dump word lists to stdout.
* `php cicada app:xor-string` - XORs a string with a key.
