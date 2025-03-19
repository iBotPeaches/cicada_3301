<?php

namespace App\Commands;

use LaravelZero\Framework\Commands\Command;

class GenerateKeyPair extends Command
{
    protected $signature = 'app:generate-key-pair {p?} {q?} {e?}';

    protected $description = 'Generates a key pair using the given prime numbers.';

    public function handle(): int
    {
        $p = $this->argument('p') ?? $this->ask('Enter a prime number p (prime 1)', '98007492061325958997349177934627388613835953553459586261');
        $q = $this->argument('q') ?? $this->ask('Enter a prime number q (prime 2)', '80411114232571782218163489375797613948878398942588985417');
        $e = $this->argument('e') ?? $this->ask('Enter a prime number e (public exponent)', 65537);

        $p = gmp_init($p);
        $q = gmp_init($q);
        $e = gmp_init($e);
        $n = gmp_mul($p, $q);
        $phi = gmp_mul(gmp_sub($p, 1), gmp_sub($q, 1));
        $d = gmp_invert($e, $phi);
        $dmp1 = gmp_sub($p, 1);
        $dmq1 = gmp_sub($q, 1);
        $iqmp = gmp_invert($q, $p);

        $privateKey = openssl_pkey_new([
            'rsa' => [
                'n' => gmp_export($n),
                'e' => gmp_export($e),
                'd' => gmp_export($d),
                'p' => gmp_export($p),
                'q' => gmp_export($q),
                'dmp1' => gmp_export($dmp1),
                'dmq1' => gmp_export($dmq1),
                'iqmp' => gmp_export($iqmp),
            ],
        ]);

        if ($privateKey === false) {
            $this->error('Failed to generate key pair.');

            return self::FAILURE;
        }

        $details = openssl_pkey_get_details($privateKey);
        $publicKeyPem = $details['key'];
        openssl_pkey_export($privateKey, $privateKeyPem);

        $this->info('Public Key:');
        echo $publicKeyPem, PHP_EOL;

        $this->info('Private Key:');
        echo $privateKeyPem, PHP_EOL;

        return self::SUCCESS;
    }
}
