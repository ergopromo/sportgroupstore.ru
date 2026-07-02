<?
return [
	'block' =>
		[
			'name' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_TITLE'),
			'section' => 'other',
		],
    'fields' =>
		[
			'title' =>
				[
					'name' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_FIELD_TITLE'),
					'type' => 'input',
					'group' => 'titles',
					'value' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_FIELD_TITLE_VALUE'),
                ],
            'contact_page_url' =>
                [
                    'name' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_FIELD_CONTACTS_URL'),
                    'type' => 'input',
                    'group' => 'settings',
                    'value' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_FIELD_CONTACTS_URL_VALUE'),
                ],
		],
	'groups' =>
		[
			'titles' =>
				[
					'name' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_GROUP_TITLES'),
                ],
            'settings' =>
				[
					'name' => \Bitrix\Main\Localization\Loc::getMessage('ADDRESSES_GROUP_SETTINGS'),
				],
		],
	'ext' =>
		[
			'js' =>
                [$_SERVER['DOCUMENT_ROOT'].'/local/templates/.default/components/sotbit/regions.maps/origami_address_block/script.js'
                ],
            'css' =>
                [$_SERVER['DOCUMENT_ROOT'].'/local/templates/.default/components/sotbit/regions.maps/origami_address_block/style.css'
                ],
		],
    'style'  =>
        [
            'padding-top' => [
                'value' => '15'
            ],
            'padding-bottom' => [
                'value' => '15'
            ],
        ],
]
?>