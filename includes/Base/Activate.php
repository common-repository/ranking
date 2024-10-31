<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\Base; # GC_Chandler 2024-03-20 Includes>GCREATE

class Activate
{
    public static function activate()
    {
        flush_rewrite_rules();
    }
}