<?php

namespace Sprint\Migration;

use Adv\AdvApplication\Migration\SprintMigrationBase;
use Adv\CatalogBundle\Enum\Hlblock;


class CreateStoresLockingHlBlock20210713092711 extends SprintMigrationBase
{
    protected $description = 'Создание HL-блока "Блокировка торговых объектов"';

    protected $moduleVersion = '3.15.1';

    protected const HL_TITLE_EN = 'Trade objects locking';
    protected const HL_TITLE_RU = 'Блокировка торговых объектов';

    private $hlHelper;

    public function __construct()
    {
        parent::__construct();
        $this->hlHelper = $this->getHelperManager()->Hlblock();
    }

    public function up()
    {
        $hlBlockId = $this->hlHelper->saveHlblock([
            'NAME' => Hlblock::CODE_STORES_LOCKING,
            'TABLE_NAME' => 'stores_locking',
            'LANG'       =>
                [
                    'ru' =>
                        [
                            'NAME' => self::HL_TITLE_RU,
                        ],
                    'en' =>
                        [
                            'NAME' => self::HL_TITLE_EN,
                        ],
                ],
        ]);

        foreach ($this->getHlFieldsList() as $field) {
            $this->hlHelper->saveField( $hlBlockId, $field);
        }
    }

    public function down()
    {
        $this->hlHelper->deleteHlblockIfExists(Hlblock::CODE_STORES_LOCKING);
    }

    private function getHlFieldsList(): array
    {
        return [
            'UF_STORE_ID' => [
                'FIELD_NAME' => 'UF_STORE_ID',
                'USER_TYPE_ID' => 'integer',
                'XML_ID' => 'UF_STORE_ID',
                'SORT' => 100,
                'MULTIPLE' => 'N',
                'REQUIRED' => 'Y',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'I',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
                'SETTINGS' => [
                    'SIZE' => 18,
                    'DEFAULT_VALUE' => 0
                ],
                'EDIT_FORM_LABEL' => [
                    'en' => 'Store ID',
                    'ru' => 'ID Аптеки'
                ],
                'LIST_COLUMN_LABEL' => [
                    'en' => 'Store ID',
                    'ru' => 'ID Аптеки'
                ],
                'LIST_FILTER_LABEL' => [
                    'en' => 'Store ID',
                    'ru' => 'ID Аптеки'
                ]
            ],
            'UF_ELEMENT_ID' => [
                'FIELD_NAME' => 'UF_ELEMENT_ID',
                'USER_TYPE_ID' => 'integer',
                'XML_ID' => 'UF_ELEMENT_ID',
                'SORT' => 100,
                'MULTIPLE' => 'N',
                'REQUIRED' => 'Y',
                'MANDATORY' => 'N',
                'SHOW_FILTER' => 'I',
                'SHOW_IN_LIST' => 'Y',
                'EDIT_IN_LIST' => 'Y',
                'IS_SEARCHABLE' => 'N',
                'SETTINGS' => [
                    'SIZE' => 18,
                    'DEFAULT_VALUE' => 0
                ],
                'EDIT_FORM_LABEL' => [
                    'en' => 'Element ID',
                    'ru' => 'ID элемента'
                ],
                'LIST_COLUMN_LABEL' => [
                    'en' => 'Element ID',
                    'ru' => 'ID элемента'
                ],
                'LIST_FILTER_LABEL' => [
                    'en' => 'Element ID',
                    'ru' => 'ID элемента'
                ]
            ]
        ];
    }
}
