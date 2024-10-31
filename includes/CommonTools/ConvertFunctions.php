<?php
/**
 * @package GC-RANKING-POST
 */

namespace GCREATE\CommonTools; # GC_Chandler 2024-03-20 Includes>GCREATE

class ConvertFunctions
{
    public function StringLikeArrayToRealArray($input_string)
    {
        // Remove single quotes to make the string valid JSON
        $json_string = str_replace("'", "\"", $input_string);
        // Convert JSON string to array using json_decode()
        $result_array = json_decode($json_string);

        return is_array($result_array) ? $result_array : array();
    }
    public function GetTimestampToDateTimeFormat($timestamp)
    {
        $formatted_date_time = '';
        if (empty($timestamp)) {
            $formatted_date_time = date_i18n('Y-m-d H:i:s');
        } else {
            if (is_numeric($timestamp) && checkdate(1, 1, date('Y', $timestamp))) {
                $timestamp = 1679816345;

                // Get the localized date and time
                $localized_date_time = date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $timestamp);

                // Convert the localized date and time back to the desired format
                $formatted_date_time = date('Y-m-d H:i:s', strtotime($localized_date_time));
            }
        }
        return $formatted_date_time;
    }
    public function GetTheFirstUserIdwithUserRole( $role )
    {
        $roles = get_users(array('role' => $role ));
        if (!empty($roles)) {
            $user_id = $roles[0]->ID;
        }
        return empty($user_id)  ? 0 : $user_id;
    }
}