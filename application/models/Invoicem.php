<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Invoicem extends Eloquent
{
    public $table = "invoice_info";
    protected $primaryKey = 'invoice_id';
    
}
