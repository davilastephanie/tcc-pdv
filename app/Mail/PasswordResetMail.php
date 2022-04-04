<?php

namespace App\Mail;

use App\Models\AuthModel;

class PasswordResetMail extends Mail
{
    /**
     * @var AuthModel
     */
    private $user;

    private $token;

    public function __construct(AuthModel $user, $token)
    {
        $this->user  = $user;
        $this->token = $token;
    }

    public function build()
    {
        $this->to($this->user->email);

        $this->subject('Redefinição de senha');
        $this->view('emails.password-reset');

        $this->with('user', $this->user);
        $this->with('token', $this->token);

        return $this->removeDuplicateEmail();
    }
}
