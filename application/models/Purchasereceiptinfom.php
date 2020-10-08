<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Purchasereceiptinfom extends Eloquent
{
    public $table = "purchase_receipt_info";

    protected $primaryKey = 'receipt_id';

    const CREATED_AT = 'receipt_doc';
	const UPDATED_AT = 'receipt_dom';
    
}
