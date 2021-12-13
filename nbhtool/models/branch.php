<?php namespace Model;

class Branch extends \Base\Record
{
    public $table_name = 'branch';

    public $fields = [
        'id' => [
            'type' => 'int',
            'required' => True
        ],
        'name' => [
            'type' => 'string',
            'required' => True
        ],
        'address_line1' => [
            'type' => 'string',
        ],
        'address_line2' => [
            'type' => 'string',
        ],
        'phone1' => [
            'type' => 'string',
        ],
        'phone2' => [
            'type' => 'string',
        ],
        'zip_code' => [
            'type' => 'string',
        ],
        'city' => [
            'type' => 'string',
        ],
        'email_address' => [
            'type' => 'string',
        ],
        'website' => [
            'type' => 'string',
        ]
    ];

}

?>
