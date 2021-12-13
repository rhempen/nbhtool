<?php namespace Model;

class PersonLanguage extends \Base\Record
{
    public $table_name = 'person_has_language';

    public $fields = [
        'person_id' => [
            'type' => 'int',
            'required' => True
        ],
        'language_id' => [
            'type' => 'int',
            'required' => True
        ]
    ];
}

?>
