<?php
class Kwc_Newsletter_Controller extends Kwc_Directories_Item_Directory_Controller
{
    protected $_defaultOrder = array('field' => 'create_date', 'direction' => 'DESC');

    protected $_buttons = array(
        'save',
        'delete',
        'reload',
        'add',
        'duplicate'
    );

    protected function _initColumns()
    {
        $this->_columns->add(new Kwf_Grid_Column('subject', trlKwf('Subject'), 300));
        $this->_columns->add(new Kwf_Grid_Column('create_date', trlKwf('Creation Date'), 120))
            ->setRenderer('localizedDatetime');
        $this->_columns->add(new Kwf_Grid_Column('info_short', trlKwf('Status'), 400));
        parent::_initColumns();
    }

    public function jsonDuplicateAction()
    {
        if (!isset($this->_permissions['duplicate']) || !$this->_permissions['duplicate']) {
            throw new Kwf_Exception("Duplicate is not allowed.");
        }

        $ids = $this->getRequest()->getParam($this->_primaryKey);
        $ids = explode(';', $ids);
        $this->view->data = array('duplicatedIds' => array());

        $parentTarget = Kwf_Component_Data_Root::getInstance()
            ->getComponentByDbId($this->_getParam('componentId'));

        foreach ($ids as $id) {
            $sourceId = $this->_getParam('componentId').'_'.$id;
            $source = Kwf_Component_Data_Root::getInstance()
                ->getComponentByDbId($sourceId);

            // Switch off observer due to performance - it's not necessary here
            Kwf_Component_ModelObserver::getInstance()->disable();
            $newDetail = Kwf_Util_Component::duplicate($source, $parentTarget);
            Kwf_Util_Component::afterDuplicate($source, $newDetail);
            Kwf_Component_ModelObserver::getInstance()->enable();

            $newDetailRow = $newDetail->row;
            $newDetailRow->create_date = date('Y-m-d H:i:s');
            $newDetailRow->last_sent_date = null;
            $newDetailRow->count_sent = 0;
            $newDetailRow->status = null;
            $newDetailRow->save();

            $mailRow = $newDetail->getChildComponent('-mail')->getComponent()->getRow();
            $mailRow->subject = trlKwf('Copy of').' '.$mailRow->subject;
            $mailRow->save();
        }
    }
}
