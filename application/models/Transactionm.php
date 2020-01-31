<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Transactionm extends Eloquent
{
    public $table = "transaction_info";
    protected $primaryKey = 'transaction_id';

    
}
?>