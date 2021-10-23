<?php

namespace App\Policies\CSP;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CustomPolicy extends Policy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    // public function configure(){
    //     $this
    //     ->addGeneralDirectives()
    //     ->addDirectivesForGoogleFonts();
    // }

    // public function addGeneralDirectives() : self {
    //     return $this
    //         ->addDirective(Directive::BASE, 'self')
    //         ->addDirective(Directive::CONNECT, 'self')
    //         ->addDirective(Directive::DEFAULT, 'self')
    //         ->addNonceForDirective(Directive::SCRIPT)
    //         ->addNonceForDirective(Directive::STYLE)
    //         ->addDirective(Directive::SCRIPT, ['self', 'unsafe-inline'])
    //         ->addDirective(Directive::STYLE, ['self', 'unsafe-inline'])

    //         ->addDirective(Directive::IMG, [
    //             '*',
    //             'unsafe-inline',
    //             'data:',
    //         ])

    //         ->addDirective(Directive::OBJECT, 'none')
    //         ->addDirective(Directive::FORM_ACTION, 'self')
    //         ->addDirective(Directive::MEDIA, ['*', 'unsafe-inline'])
    //         ->addDirective(Directive::WORKER, 'self')
    //         ->addDirective(Directive::CHILD, 'none')
    //         ->addDirective(Directive::FRAME_ANCESTORS , 'none');
    // }

    // public function addDirectivesForGoogleFonts() : self {
    //     return $this
    //         ->addDirective(Directive::FONT, 'fonts.gstatic.com')
    //         ->addDirective(Directive::SCRIPT, ['self', 'unsafe-inline', 'https://fonts.googleapis.com/'])
    //         ->addDirective(Directive::STYLE, ['self', 'unsafe-inline', 'https://fonts.googleapis.com/']);
    // }
}
