<?php
class Kwf_Model_MirrorCache_SlowMirror_TestModel_SlowModel extends Kwf_Model_FnFFile
{
    protected $_columns = array('id', 'foo');
    protected $_uniqueIdentifier = 'test-mirrorcache-slowmirror-mirror';

    public function import($format, $data, $options = array())
    {
        sleep(5);
        return parent::import($format, $data, $options = array());
    }
}

class Kwf_Model_MirrorCache_SlowMirror_TestModel extends Kwf_Model_MirrorCache
{
    protected $_maxSyncDelay = 10;
    public function __construct()
    {
        $mirrorModel = new Kwf_Model_FnF(array(
            'uniqueIdentifier' => 'test-mirrorcache-slowmirror-src',
            'columns' => array('id', 'foo'),
            'data' => array(
                array('id'=>1, 'foo'=>'bar'),
                array('id'=>2, 'foo'=>'bar2'),
                array('id'=>3, 'foo'=>'bar3'),
            )
        ));
        $config = array(
            'proxyModel' => 'Kwf_Model_MirrorCache_SlowMirror_TestModel_SlowModel',
            'sourceModel' => $mirrorModel,
            'truncateBeforeFullImport' => true,
        );
        parent::__construct($config);
    }
}
