<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Actions\Arrays\GeneratePermutation;
use Tests\TestCase;

class GeneratePermutationTest extends TestCase
{
    public function test_each_permutation_is_generated_once(): void
    {
        $permutations = iterator_to_array(GeneratePermutation::handle([0, 1, 2]), false);

        $this->assertCount(6, $permutations);
        $this->assertSame($permutations, array_values(array_unique($permutations, SORT_REGULAR)));
    }

    public function test_single_item_yields_once(): void
    {
        $this->assertSame([['a']], iterator_to_array(GeneratePermutation::handle(['a']), false));
    }
}
