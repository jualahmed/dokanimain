<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Cashbook extends Eloquent
{
    public $table = "cash_book";

    protected $primaryKey = 'cb_id';
    
}
