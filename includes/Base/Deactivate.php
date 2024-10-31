<?php
/**
 * @package GcRankingPost
 */

namespace GCREATE\Base; # GC_Chandler 2024-03-20 Includes>GCREATE

class Deactivate
{
    public static function deactivate()
    {
        flush_rewrite_rules();
    }
}