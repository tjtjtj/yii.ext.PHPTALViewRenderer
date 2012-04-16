## PHPTAL renderer for Yii Framework

### Installation

- Extract the release file under protected/extensions.
- <a href="https://github.com/pornel/PHPTAL">Download</a> and extract all PHPTAL files from pornel-PHPTAL-______.zip\pornel-PHPTAL-______\classes\ under protected/vendors/PHPTAL.
- Add to your config file 'components' section:

        'viewRenderer'=>array(
            'class'=>'ext.PHPTALViewRenderer.PHPTALViewRenderer',
            'fileExtension' => '.html',
            'options' => array(
                'forceReparse'=>true,
            ),
            'tales' => array(
                'class'=>'ext.PHPTALViewRenderer.YiiFormatter',
                ),
            'translator' => array(
                'class'=>'ext.PHPTALViewRenderer.YiiTranslator',
            ),
        ),


### Usage

- See <a href="http://phptal.org/manuals.html">PHPTAL manuals</a>
- Yii::app() �ɂ� path:app �ŃA�N�Z�X�ł��܂�
- �J�����g�R���g���[���̃v���p�e�B�ɂ� path:this/pageTitle �ŃA�N�Z�X�ł��܂�


### Widget usage example

PHPTAL�̓�����O��Ă��܂��܂����A<?php ?> �^�O�ŃE�B�W�F�b�g���g�����Ƃ��ł��܂��B

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
            'items'=>array(
                array('label'=>'Home', 'url'=>array('post/index')),
                array('label'=>'About', 'url'=>array('site/page', 'view'=>'about')),
                array('label'=>'Contact', 'url'=>array('site/contact')),
                array('label'=>'Login', 'url'=>array('site/login'), 'visible'=>Yii::app()->user->isGuest),
                array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('site/logout'), 'visible'=>!Yii::app()->user->isGuest)
            ),
        )); ?>
    </div><!-- mainmenu -->

### Sample blog demo view files 

��ƒ��ł����A�u���O�T���v����Y�t���܂����Bhtml�t�@�C����PHPTAL���������̂ł��B
