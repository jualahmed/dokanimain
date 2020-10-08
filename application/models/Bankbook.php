<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Bankbook extends Eloquent
{
    public $table = "bank_book";

    protected $primaryKey = 'bb_id';
    
}
