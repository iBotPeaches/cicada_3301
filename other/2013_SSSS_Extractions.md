## 2013 SSSS (Shamir's Secret Sharing Scheme) Extractions
_The variety of phone calls from the 2013 puzzle with offset & data with extraction._

* Oddly the hash/data for Annapolis is 2 characters less than the others, but have the same length onion.

```text
+---------+----------+------------------------------------------------+------------------------------------------------+------------------------+
| DataSet | Offset   | Data                                           | Extracted                                      | XORed                  |
+---------+----------+------------------------------------------------+------------------------------------------------+------------------------+
| 560.17  | 0x82b5   | f6a2d0a48e1b1ae40cbd454f77baa7d2557683d0cd4998 | 8f90a7ddfb6d68957edc2a3816ddc4e77b19edb9a22792 | y2wyuvrqraowagc5.onion |
| 560.13  | 0x93e5   | f286b8438cb85eb191ec7bf10a28a54ec06f9a27eb91c5 | 85fccf2eefcf33c2fad918933d4fcf20ee00f44e84ffcf | wzwmcwmsk5cb7gjn.onion |
| 560.13  | 0x10f447 | c657b2707c4266fda4af4a83acf19cc46e69540c0bc5da | b720851d14210e87d2da3bb5cac3f1a240063a6564abd0 | qw7mhchzvuq6f2mf.onion |
| 560.13  | 0x3607   | 5edb5e8029dd2182560da925ec6cd3e1257efc0b8328b4 | 6ab768f540ad4ff1226fce429b06aa970b119262ec46be | 4l6uipnstbggwjyv.onion |
| 560.17  | 0x13099  | d5a6cb76e55a2166bd6a4d078857ec1f68ea6afa9738   | b0d4bc1086294510c55c3d6aba259f7446850493f856   | erwfcsdvx6pm2rsk.onion |
| 560.13  | 0x3215   | 28c07e1b102d4d5c4c1a376e064477e1416fcc94928765 | 4fa20773275723317a79000b7c371a936f00a2fdfde96f | gbyh7znm6c7ezsmr.onion |
| 560.17  | 0x269    | d4b10626d65995e8fb010f4388787d56433f90c6df8d8d | b8dd3347b020e68399377975ef4f1a376d50feafb0e387 | ll5afyskb6v6g7ga.onion |
+---------+----------+------------------------------------------------+------------------------------------------------+------------------------+
```

* This was generated via `php cicada app:shamir-solve` in the tool folder.
