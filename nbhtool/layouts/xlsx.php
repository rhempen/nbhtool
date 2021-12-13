<?php namespace Layout;

class Xlsx extends \Base\Layout
{
    private $template = NULL;
    private $template_base_path = NULL;

    public function render($template_name=NULL, $clean = false)
    {
        $table_sheet_name =
            is_array($this->value) &&
            array_key_exists('table_sheet_name', $this->value) &&
            is_string($this->value['table_sheet_name']) ?
            $this->value['table_sheet_name'] :
            'NBHTool Daten-Export';
        $table_columns_filter =
            is_array($this->value) &&
            array_key_exists('table_columns_filter', $this->value) &&
            is_array($this->value['table_columns_filter']) ?
            $this->value['table_columns_filter'] :
            array();
        $table_columns_name =
            is_array($this->value) &&
            array_key_exists('table_columns_name', $this->value) &&
            is_array($this->value['table_columns_name']) ?
            $this->value['table_columns_name'] :
            array();
        $table_timestamp_columns =
            is_array($this->value) &&
            array_key_exists('table_timestamp_columns', $this->value) &&
            is_array($this->value['table_timestamp_columns']) ?
            $this->value['table_timestamp_columns'] :
            array();
        $table_file_name =
            is_array($this->value) &&
            array_key_exists('table_file_name', $this->value) ?
            $this->value['table_file_name'] :
            'export_table';
        $table_data =
            is_array($this->value) &&
            array_key_exists('table_data', $this->value) &&
            is_array($this->value['table_data']) ?
            $this->value['table_data'] :
            array();
        $table_timestamp = date('Y-m-d-H-i-s');
        $table_export_data = array();
        $table_export_head = array();
        if(count($table_columns_filter) > 0)
        {
            $table_export_head = $table_columns_filter;
        }
        foreach($table_export_head as &$head)
        {
            if(array_key_exists($head, $table_columns_name))
            {
                $head = $table_columns_name[$head];
            }
        }
        array_push($table_export_data, $table_export_head);
        foreach($table_data as $record)
        {
            $table_record = array();
            foreach($table_columns_filter as $column_key)
            {
                    $field_string = '';
                    if(array_search($column_key, $table_timestamp_columns) !== FALSE)
                    {
                        if($record[$column_key] != 0)
                        {
                            $field_string = date("d.m.Y", $record[$column_key]);
                        }
                        else
                        {
                            $field_string = '';
                        }
                    }
                    else
                    {
                        $field_string = $record[$column_key];
                    }
                    array_push($table_record, $field_string);
            }
            array_push($table_export_data, $table_record);
        }
        $objPHPExcel = new \PHPExcel;
        $objPHPExcel->getActiveSheet()->fromArray($table_export_data, NULL, 'A1');
        $objPHPExcel->getActiveSheet()->setTitle($table_sheet_name);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'.$table_timestamp.'_'.$table_file_name.'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
}

?>
