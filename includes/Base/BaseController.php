<?php
/**
 * @package GC-RANKING-POST
 * 定義常數
 */

namespace GCREATE\Base; # GC_Chandler 2024-03-20 Includes>GCREATE

use GCREATE\Api\Tools\VerifyFunctions;
use GCREATE\Api\Tools\QueryInfoFunctions;
use GCREATE\CommonTools\ConvertFunctions;

class BaseController
{
    public $plugin_path;
    public $plugin_url;
    public $plugin_name;
    public $verify_functions;
    public $queryinfo_functions;
    public $convert_functions;
    public $prefix = 'validation_';
    public function __construct()
    {
        $this->plugin_path = plugin_dir_path( dirname( __FILE__ , 2 ) );

        $this->plugin_url  = plugin_dir_url( dirname( __FILE__ , 2 ) );

        # $this->plugin_name = plugin_basename( dirname( __FILE__ , 3 ) ); 超難用
        
        $this->verify_functions = new VerifyFunctions();

        $this->queryinfo_functions = new QueryInfoFunctions();

        $this->convert_functions = new ConvertFunctions();
    }
}