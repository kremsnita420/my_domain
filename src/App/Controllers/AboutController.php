<?php

declare(strict_types=1);

namespace App\Controllers;

use Framework\TemplateEngine;
use App\Config\Paths;


class AboutController
{
    private TemplateEngine $view;
    public function __construct()
    {
        $this->view = new TemplateEngine(Paths::VIEW);
    }

    public function about()
    {


        echo $this->view->render('about', [
            'title' => 'About Page',
            'dangerousString' => '<script>alert("XSS Attack!");</script>'
        ]);
    }
}
