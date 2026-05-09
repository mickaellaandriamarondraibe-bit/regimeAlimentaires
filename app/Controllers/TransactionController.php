<?php 
namespace App\Controllers;
use App\Models\CodeModel;

class TransactionController extends BaseController
{
    private $transactionModel;
    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function transaction(){
        return view('template/transaction');
    }

    
}