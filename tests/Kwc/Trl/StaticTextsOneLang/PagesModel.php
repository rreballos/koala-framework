<?php
class Kwc_Trl_StaticTextsOneLang_PagesModel extends Kwc_Root_Category_GeneratorModel
{
    public function __construct()
    {
        $config['proxyModel'] = new Kwf_Model_FnF(array(
            'data' => array(
                array('id'=>50, 'pos'=>1, 'visible'=>true, 'name'=>'TrlTest', 'filename' => 'trltest',
                    'parent_id'=>'root', 'component'=>'trltest', 'is_home'=>false, 'hide'=>false),
            )
        ));
        parent::__construct($config);
    }
}
