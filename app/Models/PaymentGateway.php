<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
  use HasFactory;
  public $timestamps = false;

  protected $fillable = ['name', 'information', 'status'];


  public function convertAutoData()
  {
    return  json_decode($this->information, true);
  }

  public function getAutoDataText()
  {
    $text = $this->convertAutoData();
    return end($text);
  }
}
