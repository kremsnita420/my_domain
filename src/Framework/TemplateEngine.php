<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    public function __construct(private string $basePath)
    {
    }

    public function render(string $template, array $data = [])
    {
        $templatePath = $this->resolve($template . '.php');

        extract($data, EXTR_SKIP);

        ob_start();

        if (!file_exists($templatePath))
        {
            throw new \RuntimeException("Template not found: " . $templatePath);
        }

        include $templatePath;

        $output = ob_get_contents();

        ob_end_clean();
        return $output;
    }

    public function resolve(string $path): string
    {
        return $this->basePath . '/' . $path;
    }
}
