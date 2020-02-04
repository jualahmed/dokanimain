<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Purchaseinfom extends Eloquent
{
    public $table = "purchase_info";

    protected $primaryKey = 'purchase_id';

    const CREATED_AT = 'purchase_doc';
	const UPDATED_AT = 'purchase_dom';
    
}
