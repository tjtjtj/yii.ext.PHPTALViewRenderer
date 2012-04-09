<?php
class PHPTALViewRenderer extends CApplicationComponent implements IViewRenderer
{
    /**
     * @var string Path alias to PHPTAL.php
     */
    public $PHPTALPathAlias = 'application.vendors.PHPTAL';
    
    /**
     * @var string Template files extension
     */
    public $fileExtension = '.html';

    /**
     * @var array PHPTAL configration options
     * @see http://phptal.org/manual/en/split/configuration.html
     * 
     * example: 
     * array(
     *    'templateRepository' => array(),
     *    'phpCodeDestination' => 'app/runtime/PHPTAL_temp/',
     *    'forceReparse => false,
     *  ),
     */
    public $options = array();  

    /**
     * @var array
     * 
     * example: 
     * array(
     *    'class' => 'PHPTALViewRendererYiiFormatter',
     *  ),
     */
    public $tales = null;

    /**
     * @var array
     * 
     * example: 
     * array(
     *    'class' => 'PHPTALViewRendererYiiTranslator',
     *  ),
     */
    public $translator = null;
    
    /**
     * @var string Context Controller name
     */
    public $contextPath = 'this';
    /**
     * @var string Yii::app()->user name
     */
    public $userPath = 'webuser';

    private $_basePath;
    private $_basePathLength;
    private $_tales = null;
    private $_translator = null;
    
    function init()
    {
        require_once Yii::getPathOfAlias($this->PHPTALPathAlias).'/PHPTAL.php';
        Yii::registerAutoloader(array('PHPTAL', 'autoloadRegister'), true); 

        // setup tales 
        if (isset($this->tales)) {
            $this->_tales = Yii::createComponent($this->tales);
            $this->_tales->registTales();
        }

        // setup translator 
        if (isset($this->translator)) {
            $this->_translator = Yii::createComponent($this->translator);
        }

        $app = Yii::app();

        // setup option 
        $defaultOptions = array(
            'phpCodeDestination' => $app->getRuntimePath() . '/PHPTAL_temp/',
        );
        $this->options = array_merge($defaultOptions, $this->options);
        
        // make temp dir 
        $tmpdir = $this->options['phpCodeDestination'];
        if ($tmpdir && !is_dir($tmpdir)) {
            mkdir($tmpdir, 0777, true);
        }

        /** @var $theme CTheme */
        $theme = $app->getTheme();

        if ($theme === null) {
            $this->_basePath = $app->getBasePath();
        } else {
            $this->_basePath = $theme->getBasePath();
        }

        $this->_basePathLength = strlen($this->_basePath) ;
        
        return parent::init();
    }
    
    public function renderFile($context, $sourceFile, $data, $return)
    {
        // create template and configure template 
        $templateFile = "protected/".substr($sourceFile, $this->_basePathLength);
        $template = new PHPTAL($templateFile);
        foreach($this->options as $key => $val) {
            $method = 'set' . strtoupper($key[0]) . substr($key, 1);
            if(method_exists($template, $method)) {
                $template->$method($val);
            }
        }
        
        // set translator
        if ($this->_translator) {
            $template->setTranslator($this->_translator);
        }
        
        // se values
        $template->set($this->contextPath, $context);
        $template->set($this->userPath, Yii::app()->user);
        foreach($data as $key => $val) {
            $template->set($key, $val);
        }
        
        // rendering
        $result = $template->execute();

        if ($return) {
            return $result;
        }
        echo $result;
    }
    
}
