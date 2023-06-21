<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_branch';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'erp_branches';

    protected $fillable = ['branch_name', 
                            'is_active', 
                            'is_deleted', 
                            'created_by', 
                            'updated_by'];
}
