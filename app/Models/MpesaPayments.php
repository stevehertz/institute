<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MpesaPayments extends Model
{
    protected $table = 'mpesa_payments';
    protected $fillable = [
        'TransID',
        'TransTime',
        'TransAmount',
        'BusinessShortCode',
        'BillRefNumber',
        'InvoiceNumber',
        'OrgAccountBalance',
        'ThirdPartyTransID',
        'CustomerPhone',
        'FirstName',
        'MiddleName',
        'LastName',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];
    public $sortable = ['FirstName', 'CustomerPhone', 'TransTime'];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice')->withTrashed();
    }
}
