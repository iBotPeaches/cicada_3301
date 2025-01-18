## TCP Server (2013 Puzzle)
_A signed Cicada 3301 message decrypted of the encryption, but left with an inline verified signature._

* Given the signed message [tcp-server.asc](../messages/2013/tcp-server.asc)
* Decrypt the message with `gpg -d` (or simply verify with `gpg --verify`)

```text
In the programming language of your choice build a TCP server
that implements the protocol below.  The server code must be 
written by you and you alone, although you are free to use any 
modules or libraries publicly available for the selected 
programming language.

Once you have done this, make it accessible as a Tor hidden 
service.  Then provide us with the onion address and port
via a GPG-encrypted email to this address.

You have until 0:00 UTC on 3 Feb, 2013.  Any emails received
after that time will be ignored.

Good luck.

3301

====================================================================


1. INTRODUCTION

   The TCP server MUST listen on an arbitrary port, and send and 
   receive plain text with lines separated by <CRLF> (representing
   a carriage return followed by a line feed).  The TCP server MUST
   disregard the case of input.

   In the examples below, lines sent by the server will be preceded
   with "S:" and lines sent by the client will be preceded by "C:"

   Each message sent by the server MUST conform to the format:

       [CODE] [RESPONSE NAME] [RESPONSE (optional)]<CRLF>

   Where [CODE] and [RESPONSE NAME] is one of:

       CODE   RESPONSE NAME
        00     Welcome 
        01     Ok 
        02     Error
        03     Data
        99     Goodbye


2. PROCEDURES

   a. Remote Connection

   Upon receiving a remote connection, the server MUST greet the 
   client with a 00 WELCOME message.  The RESPONSE of a welcome
   message MAY contain arbitrary text.  The arbitrary text MUST
   at the very least contain the name of the programming language
   used to implement the server.

   Upon receiving a 00 WELCOME message, the client may begin 
   initiating procedures.

   Example:

       S: 00 WELCOME [ARBITRARY RESPONSE TEXT]<CRLF>


   b. RAND [n]
   
   Upon receiving a "RAND" request by the client, the server will
   first send a 01 OK response, and will then provide the client 
   with [n] cryptographically random numbers within the range of 
   0-255.  Each number MUST be followed by <CRLF>.  After the last 
   number has been sent, the server MUST send a dot (.) on a line 
   by itself.

   Example:

       C: RAND 3<CRLF>
       S: 01 OK<CRLF>
       S: [first random number]<CRLF>
       S: [second random number]<CRLF>
       S: [third random number]<CRLF>
       S: .<CRLF>


   c. QUINE

   Upon receiving a "QUINE" request by the client, the server will
   first send a 01 OK response, and will then provide the client
   with a quine in the programming language used to implement the
   server.  This quine does not have to be original.  After the last 
   line of code has been sent, the server MUST send a dot (.) on a 
   line by itself.

   Example:

       C: QUINE<CRLF>
       S: 01 OK<CRLF>
       S: [quine code]<CRLF>
       S: .<CRLF>
   

   d. BASE29 [n]

   Upon receiving a "BASE29" request by the client, the server will
   send a 01 OK response followed by the number [n] converted into 
   its base 29 representation.

   Example:

       C: BASE29 3301<CRLF>
       S: 01 OK 3QO<CRLF>


   e. CODE

   Upon receiving a "CODE" request by the client, the server will
   send a 01 OK response followed by its own source code.  After the
   last line of code has been sent, the server MUST send a dot(.) on
   a line by itself.   

   Example:

       C: CODE<CRLF>
       S: 01 OK<CRLF>
       S: [Server Source Code]<CRLF>
       s: .<CRLF>


   f. KOAN

   Upon receiving a "KOAN" request by the client, the server will
   send a 01 OK response followed by a koan.  After the last line of
   the koan, the server MUST send a dot (.) on a line by itself.

   Example:

       C: KOAN<CRLF>
       S: 01 OK<CRLF>
       S: A master who lived as a hermit on a mountain was asked by a<CRLF>
       S: monk, "What is the Way?<CRLF>
       S: "What a fine mountain this is," the master said in reply<CRLF>
       S: "I am not asking you about the mountain, but about the Way.<CRLF>
       S: "So long as you cannot go beyond the mountain, my son, you<CRLF>
       S: cannot reach the Way," replied the master<CRLF>
       S: .


   g. DH [p]

   Upon receiving a "DH" request by the client, the server will proceed
   to perform a Diffie-Hellman key exchange using [p] as the prime modulus.
   The server will then select a base [b] to use in the protocol, as well as
   its secret integer.  The server will then compute its exponent result [e] 
   as specified within the Diffie-Hellman key exchange protocol.  

   The server MUST then respond with a 01 OK response followed by the 
   selected base [b] and computed exponent [e] separated by white space.

   The client MUST respond with its exponent result [e2], and the client and 
   server will follow the rest of the Diffie-Hellman key exchange protocol.

   The server MUST then compute the resulting secret key, and provide it
   using 03 DATA [k].

   Example:

       C: DH 23<CRLF>
       S: 01 OK 5 8<CRLF>
       C: 19<CRLF>
       S: 03 DATA 2<CRLF>


   j. NEXT

   Upon receiving a "NEXT" request by the client, the server will respond
   with 01 OK and then listen for text data to be provided by the client.  
   The client will send a dot (.) on a line by itself after the last line 
   of text.  The server MUST record this.  This data will be the next set 
   of instructions.  Once the data is received the server will respond 
   with 01 OK. 

   Example:

       C: NEXT<CRLF>
       S: 01 OK<CRLF>
       C: -----BEGIN PGP SIGNED MESSAGE-----<CRLF>
       C: [MESSAGE CONTENTS]<CRLF>
       C: -----END PGP SIGNATURE-----<CRLF>
       C: .<CRLF>
       S: 01 OK<CRLF>


   i. GOODBYE

   Upon receiving a "DH" request by the client, the server MUST respond with
   99 GOODBYE and then gracefully close the connection.

   Example:

       C: GOODBYE<CRLF>
       S: 99 GOODBYE<CRLF>


====================================================================


gpg: Signature made Sat 26 Jan 2013 04:16:23 AM EST
gpg:                using RSA key 181F01E57A35090F
gpg: Good signature from "Cicada 3301 (845145127)" [unknown]
gpg: WARNING: This key is not certified with a trusted signature!
gpg:          There is no indication that the signature belongs to the owner.
Primary key fingerprint: 6D85 4CD7 9333 22A6 01C3  286D 181F 01E5 7A35 090F
```
