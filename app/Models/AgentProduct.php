<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Laratrust;

class AgentProduct extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'agent_id';
    protected $table = 'agent_products';

    protected $fillable = [
        'agent_id',
        'product_id',
    ];

    public function agent(){
        return $this->belongsTo(Organization::class, 'agent_id', 'id');
    }

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
