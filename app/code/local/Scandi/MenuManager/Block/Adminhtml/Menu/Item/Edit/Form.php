<?php
/**
 * Scandi_MenuManager
 *
 * @category Scandi
 * @package Scandi_MenuManager
 * @author Scandiweb <info@scandiweb.com>
 * @copyright Copyright (c) 2013 Scandiweb, Ltd (http://scandiweb.com)
 * @license http://opensource.org/licenses/afl-3.0.php Academic Free License (AFL 3.0)
 */

/**
 * MenuManager menu item edit form
 *
 * @category    Scandi
 * @package     Scandi_MenuManager
 */
class Scandi_MenuManager_Block_Adminhtml_Menu_Item_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        /* @var $model Scandi_MenuManager_Model_Item*/
        $model = Mage::registry('menumanager_menu_item');
        $menuId = $this->getRequest()->getParam('menu_id');

        $form = new Varien_Data_Form(array(
            'method' => 'post',
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save_item', array('menu_id' => $menuId)),
        ));

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('scandi_menumanager')->__('General Information'))
        );

        if ($model->getItemId()) {
            $fieldset->addField('item_id', 'hidden', array(
                'name'  => 'item_id',
            ));
        }

        if ($model->getMenuId()) {
            $fieldset->addField('menu_id', 'hidden', array(
                'name'  => 'menu_id',
            ));
        }

        if ($model->getIdentifier()) {
            $fieldset->addField('identifier', 'hidden', array(
                'name' => 'identifier',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('scandi_menumanager')->__('Title'),
            'title'     => Mage::helper('scandi_menumanager')->__('Title'),
            'required'  => true,
        ));

        $fieldset->addField('parent_id', 'select', array(
            'name'      => 'parent_id',
            'label'     => Mage::helper('scandi_menumanager')->__('Parent'),
            'title'     => Mage::helper('scandi_menumanager')->__('Parent'),
            'options'   => $model->getCollection()
                ->addMenuFilter($menuId)
                ->toItemOptionArray(),
            'required'  => true,
        ));

        $fieldset->addField('url', 'text', array(
            'name'      => 'url',
            'label'     => Mage::helper('scandi_menumanager')->__('Url'),
            'title'     => Mage::helper('scandi_menumanager')->__('Url'),
            'note'      => Mage::helper('cms')->__('Use " / " For Item With Base Url.')
        ));

        $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'label'     => Mage::helper('scandi_menumanager')->__('Url Window Type'),
            'title'     => Mage::helper('scandi_menumanager')->__('Url Window Type'),
            'options'   => $model->getAvailableTypes(),
            'required'  => true
        ));

        $fieldset->addField('css_class', 'text', array(
            'name'      => 'css_class',
            'label'     => Mage::helper('scandi_menumanager')->__('CSS Class'),
            'title'     => Mage::helper('scandi_menumanager')->__('CSS Class'),
            'note'      => Mage::helper('cms')->__('Space Separated Class Names')
        ));

        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => Mage::helper('scandi_menumanager')->__('Position'),
            'title'     => Mage::helper('scandi_menumanager')->__('Position'),
            'class'     => 'validate-number',
            'required'  => true
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('scandi_menumanager')->__('Status'),
            'title'     => Mage::helper('scandi_menumanager')->__('Menu Item Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('scandi_menumanager')->__('Enabled'),
                '0' => Mage::helper('scandi_menumanager')->__('Disabled'),
            ),
        ));

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        Mage::dispatchEvent(
            'adminhtml_cms_menu_item_edit_prepare_form',
            array('form' => $form)
        );

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
