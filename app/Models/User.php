<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Mail\VerifyUserEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'name',
    'email',
    'role',
    'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * Get the attributes that should be cast.
   *
   * @return array<string, string>
   */
  protected function casts(): array
  {
    return [
      'email_verified_at' => 'datetime',
      'password' => 'hashed',
    ];
  }

  public function sendEmailVerificationNotification()
  {
    $url = URL::temporarySignedRoute(
      'verification.verify',
      now()->addDay(),
      [
        'id' => $this->getKey(),
        'hash' => sha1($this->getEmailForVerification()),
      ]
    );

    Mail::to($this->email)->send(new VerifyUserEmail($url));
  }

  public function eproPengguna()
  {
    return $this->hasOne(EproPengguna::class, 'pen_idusers');
  }
}
