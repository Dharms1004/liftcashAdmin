<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function __construct(){
    	$this->heading = [];
    	$this->data = [];
    }
    public function collection(Collection $collection)
    {
       if(!empty($collection)){
       	foreach ($collection as $key => $rows) {
       		foreach ($rows as $k => $columns) {
	       		if($key == 0){
	       			$this->heading[$k] = $columns;
	       		}else{
	       			$this->data[$key] = $columns;
	       		}
       		}
       	}
       }
       	return $this->data;
	}

}
