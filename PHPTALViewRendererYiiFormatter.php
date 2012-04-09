<?php
require_once Yii::getPathOfAlias('application.vendors.PHPTAL').'/PHPTAL/TranslationService.php';

/**
 * regist tales from CFormatter(Yii::app()->format) Format Methods
 */
class PHPTALViewRendererYiiFormatter extends CComponent implements PHPTAL_Tales
{
    public function registTales()
    {
        $registry = PHPTAL_TalesRegistry::getInstance();
                
        foreach(get_class_methods($this) as $name) {
            if (6 < strlen($name) && self::startWith($name, 'format')) {
                $talesname = self::lowerStart(substr($name,6));
                if ( !$registry->isRegistered($talesname) ) {
                    $registry->registerPrefix($talesname, array($this, $name));
                }
            }
        }
    }

    /**
     * @see CFormatter#formatBoolean
     */
    public static function formatBoolean($src, $nothrow)
    {
        return 'Yii::app()->format->boolean('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatDate
     */
    public static function formatDate( $src, $nothrow )
    {
        return 'Yii::app()->format->date('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatDateTime
     */
    public static function formatDateTime( $src, $nothrow )
    {
        return 'Yii::app()->format->dateTime('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatEmail
     */
    public static function formatEmail( $src, $nothrow )
    {
        return 'Yii::app()->format->email('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatHtml
     */
    public static function formatHtml( $src, $nothrow )
    {
        return 'Yii::app()->format->html('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatImage
     */
    public static function formatImage( $src, $nothrow )
    {
        return 'Yii::app()->format->image('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatNtext
     */
    public static function formatNtext( $src, $nothrow )
    {
        return 'Yii::app()->format->ntext('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatNumber
     */
    public static function formatNumber( $src, $nothrow )
    {
        return 'Yii::app()->format->number('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatRaw
     */
    public static function formatRaw( $src, $nothrow )
    {
        return 'Yii::app()->format->raw('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatText
     */
    public static function formatText( $src, $nothrow )
    {
        return 'Yii::app()->format->text('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatTime
     */
    public static function formatTime( $src, $nothrow )
    {
        return 'Yii::app()->format->time('.phptal_tales($src, $nothrow).')';
    }

    /**
     * @see CFormatter#formatUrl
     */
    public static function formatUrl( $src, $nothrow )
    {
        return 'Yii::app()->format->url('.phptal_tales($src, $nothrow).')';
    }

    
    
    /**
     * @see CFormatter#formatUrl
     */
    public static function formatMoney( $src, $nothrow )
    {
        return 'Yii::app()->format->money('.phptal_tales($src, $nothrow).')';
    }
    
    /**
     * @see CFormatter#formatUrl
     */
    public static function formatWareki( $src, $nothrow )
    {
        return 'Yii::app()->format->money('.phptal_tales($src, $nothrow).')';
    }
    

    private static function startWith($haystack, $needle)
    {
        return strpos($haystack, $needle, 0) === 0;
    }

    private static function lowerStart($source)
    {
        return strtolower(substr($source, 0, 1)).substr($source, 1);
    }
        
}