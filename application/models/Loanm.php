<?php
use Illuminate\Database\Eloquent\Model as Eloquent;
class Loanm extends Eloquent
{
    public $table = "loans";

    public function customers()
    {
    	return $this->belongsToMany(Customerm::class);
    }
    
}
