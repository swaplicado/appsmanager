<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_company';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'erp_companies';

    protected $fillable = ['company_code', 
                            'company_name', 
                            'company_db_name', 
                            'is_active', 
                            'is_deleted', 
                            'created_by', 
                            'updated_by'];
}
