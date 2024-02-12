<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
  protected $table="Tareas";
  protected $primaryKey="idTarea";
  public $timestamps = false;
  protected $fillable = [
    'idTarea', 'titulo', 'descripcion', 'fechaVenc', 'idEstadoF', 'idUsuarioF'
];
    use HasFactory;
}