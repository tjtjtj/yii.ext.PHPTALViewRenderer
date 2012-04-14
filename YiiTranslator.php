<?php
//require_once Yii::getPathOfAlias('application.vendors.PHPTAL').'/PHPTAL/TranslationService.php';
/**
 * TranslationService by Yii::t
 * 
 * example: 
 * <span i18n:translate="string:{attribute} is invalid.">
 *     <span i18n:name="yiiTCategoryKey" tal:replace="string:yii"/>
 *     <span i18n:name="attribute" tal:replace="model/name"/>
 *     {attribute} is invalid.
 * </span>
 */
class YiiTranslator extends CComponent implements PHPTAL_TranslationService
{
    private $_categoryKey;
    private $_category;
    private $_context = array();
     
	public function __construct($categoryKey='yiiTCategoryKey', $category='yii')
	{
		$this->_categoryKey = $categoryKey;
		$this->_category = $category;
	}

    public function setEncoding($encoding) {}
    public function setLanguage() {}
    public function useDomain($domain) {}
    
    public function setVar($key, $value_escaped) 
    {
        if ($key === $this->_categoryKey) 
            $this->_category = $value_escaped;
        else
            $this->_context[$key] = $value_escaped;        
    }
    public function translate($key, $htmlescape = true) 
    {
        return Yii::t($this->_category, $key, $this->_context);
    }
}
