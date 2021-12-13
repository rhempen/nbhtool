<?php namespace Model;

class Service extends \Base\Record
{
    public $table_name = 'service';
    public $model = 'Model\Service';

    public function sub_services()
    {
        $result_obj = array();
        if($this->field('id'))
        {
            $result = \DB::$handle->select(
                'service',
                ['id'],
                ['parent_service_id' => $this->field('id')->data(), 'ORDER' => ['text' => 'ASC']]
            );
            foreach($result as $sub_service)
            {
                array_push($result_obj, new \Model\Service($sub_service['id']));
            }
        }
        return $result_obj;
    }

    public function parent_service()
    {
        if($this->field('parent_service_id')->data())
        {
            $result = \DB::$handle->get(
                'service',
                ['id'],
                ['id' => $this->field('parent_service_id')->data(), 'ORDER' => ['text' => 'ASC']]
            );
            return new \Model\Service($result['id']);
        }
        return NULL;
    }
}

?>
