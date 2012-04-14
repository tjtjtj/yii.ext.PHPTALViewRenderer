<?php
//require_once Yii::getPathOfAlias('application.vendors.PHPTAL').'/PHPTAL/PHPTAL_Tales.php';
/**
 * regist tales from CFormatter(Yii::app()->format) Format Methods
 */
class YiiFormatter extends CComponent implements PHPTAL_Tales
{
    public function registTales()
    {
        $registry = PHPTAL_TalesRegistry::getInstance();
                
        foreach(get_class_methods($this) as $name) {
            if (6 < strlen($name) && self::startWith($name, 'tales_')) {
                $talesname = lcfirst(substr($name,6));
                if ( !$registry->isRegistered($talesname) ) {
                    $registry->registerPrefix($talesname, array($this, $name));
                }
            }
        }
    }

    /**
     * @see CFormatter#formatBoolean
     */
    public static function tales_boolean($src, $nothrow)
    {
        return 'Yii::app()->format->boolean('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatDate
     */
    public static function tales_date( $src, $nothrow )
    {
        return 'Yii::app()->format->date('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatDateTime
     */
    public static function tales_dateTime( $src, $nothrow )
    {
        return 'Yii::app()->format->dateTime('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatEmail
     */
    public static function tales_email( $src, $nothrow )
    {
        return 'Yii::app()->format->email('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatImage
     */
    public static function tales_image( $src, $nothrow )
    {
        return 'Yii::app()->format->image('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatNumber
     */
    public static function tales_number( $src, $nothrow )
    {
        $src = trim($src);
        return 'Yii::app()->format->number('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatTime
     */
    public static function tales_time( $src, $nothrow )
    {
        $src = trim($src);
        return 'Yii::app()->format->time('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatUrl
     */
    public static function tales_url( $src, $nothrow )
    {
        $src = trim($src);
        return 'Yii::app()->format->url('.phptal_tales($src, $nothrow).')';
    }

    private static function startWith($haystack, $needle)
    {
        return strpos($haystack, $needle, 0) === 0;
    }
        
}

function phptal_tales_if( $src, $nothrow )
{
    $src = trim($src);
    list($if_part, $right) = explode('?', $src, 3);
    if (strpos($right,'|')) {
        list($then_part, $else_part) = explode('|', $right, 2);
    } else {
        $then_part = $right;
        $else_part = 'null';
    }
    return '('.phptal_tales($if_part, $nothrow).') ? '.phptal_tales($then_part, $nothrow).' : '.phptal_tales($else_part, $nothrow).'';
}

function phptal_tales_eq( $src, $nothrow )
{
    $src = trim($src);
    list($left, $right) = explode(' ', $src, 2);
    return '('.phptal_tales($left, $nothrow).' == '.phptal_tales($right, $nothrow).' )';
}

function phptal_tales_connect( $src, $nothrow )
{
    $src = trim($src);
    $words = explode(" ", $src, 2);
    return ''.phptal_tales($words[0], $nothrow).".".phptal_tales($words[1], $nothrow);
}
