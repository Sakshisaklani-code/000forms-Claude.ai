<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    /**
     * Verify form recipient email.
     */
    public function verify(string $token)
    {
        $form = Form::where('email_verification_token', $token)->first();

        if (!$form) {
            return view('pages.verification-result', [
                'success' => false,
                'message' => 'Invalid or expired verification link.',
            ]);
        }

        if ($form->email_verified) {
            return view('pages.verification-result', [
                'success' => true,
                'message' => 'This email has already been verified.',
                'form' => $form,
            ]);
        }

        $form->update([
            'email_verified' => true,
            'email_verified_at' => now(),
            'email_verification_token' => null,
        ]);

        return view('pages.verification-result', [
            'success' => true,
            'message' => 'Email verified successfully! Your form is now active.',
            'form' => $form,
        ]);
    }
}
