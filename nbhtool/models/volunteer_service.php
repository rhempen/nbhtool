<?php namespace Model;

class VolunteerService extends \Base\Record
{
    public $table_name = 'volunteer_provides_service';

    public $fields = [
        'volunteer_id' => [
            'type' => 'int',
            'required' => True
        ],
        'service_id' => [
            'type' => 'int',
            'required' => True
        ],
    ];

    public function service()
    {
        return new \Model\Service($this->field('service_id')->data());
    }

    public function volunteer()
    {
        return new \Model\Volunteer($this->field('volunteer_id')->data());
    }
}

?>
