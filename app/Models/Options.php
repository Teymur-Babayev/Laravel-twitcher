<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Options extends Model
{
    // no timestamps
    public $timestamps = false;

    // table name 
    public $table  = 'options_table';

    // fillable
    protected $fillable = ['option_name', 'option_value'];

    // save an option
    public static function update_option($name, $value)
    {
        // update if already exists - create if it doesn't
        $option = self::where('option_name', $name)->first();

        if (!$option) {
            $option = new Options;
        }

        $option->option_name = $name;
        $option->option_value = $value;
        $option->save();

        return $option;
    }

    // get an option
    public static function get_option($name, $default = null)
    {
        $return = self::where('option_name', $name)->pluck('option_value')->first();

        if (!$return)
            return $default;

        return $return;
    }

    // delete an option
    public static function delete_option($name)
    {
        $id = self::where('option_name', $name)->pluck('id')->first();

        if ($id)
            return self::destroy($id);
    }

    // get first from a comma separated list
    public static function first_from_list($comma_separated_list)
    {
        return reset(explode(',', $comma_separated_list));
    }
}
