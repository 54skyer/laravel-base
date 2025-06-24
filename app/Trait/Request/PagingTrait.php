<?php

namespace App\Trait\Request;

trait PagingTrait
{
    public int $page = 1;
    public int $page_size = 10;
}
