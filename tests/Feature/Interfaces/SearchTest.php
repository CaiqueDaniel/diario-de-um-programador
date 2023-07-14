<?php

namespace Tests\Feature\Interfaces;

interface SearchTest
{
    public function test_search_with_results(): void;

    public function test_search_without_results(): void;
}
