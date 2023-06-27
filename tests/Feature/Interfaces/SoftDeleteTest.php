<?php

namespace Tests\Feature\Interfaces;

interface SoftDeleteTest
{
    public function test_enabling_item(): void;

    public function test_disabling_item(): void;
}
