<?php

namespace App\Service\Transaction;

interface TransactionInterface
{
    public function beginTransaction();
    public function commitTransaction();
    public function rollbackTransaction();
}