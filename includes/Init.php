<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE; # GC_Chandler 2024-03-20 Includes>GCREATE

final class Init
{
    /**
     * Store all the classes inside an array 
     * 獲取路徑底下的classes清單
     * @return array Full list of classes
     */
    public static function get_services()
    {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\SettingsLinks::class,
            Base\RestAPIs::class,
        ];
    }

    /**
     * Loop through the classes, initialize them and call the register() method if it exists
     * 過濾迴圈物件包含 method register() 進行實體化
     */
    public static function register_services()
    {
        foreach (self::get_services() as $class) {

            $service = self::instantiate($class);
            
            if ( method_exists($service, 'register') ) {
              
                $service->register();
            
            }
        }
    }
    /**
     * 將放置的物件實體化 the class 
     * @param "class" from the services array
     * @return "class" instance new instance of the class
     */
    private static function instantiate( $class )
    {
        $service = new $class();

        return $service;
    }
}
