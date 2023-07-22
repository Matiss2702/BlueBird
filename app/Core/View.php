<?php

namespace App\Core;

class View {

    private String $view;
    private String $template;
    private Array $data = [];
    private Array $scripts = [];

    public function __construct(String $view, String $template = "back") {
        $this->setView($view);
        $this->setTemplate($template);
    }

    public function assign(String $key, $value): void
    {
        $this->data[$key] = $value;
    }
    
    public function assignToTemplate(String $key, $value): void
    {
        $this->templateData[$key] = $value;
    }

    public function addScript(String $scriptPath): void
    {
        if (file_exists(__DIR__ . '/../../public' . $scriptPath)) {
            $this->scripts[] = $scriptPath;
        } else {
            die("La script ".$scriptPath." n'éxiste pas");
        }
    }

    /**
     * @param String $view
     * @return void
     */
    private function setView(String $view): void
    {
        $this->view = __DIR__ . "/../Views/$view.view.php";
        if (!file_exists($this->view)) {
            die("La vue ".$this->view." n'éxiste pas");
        }
    }

    /**
     * @param String $template
     * @return void
     */
    private function setTemplate(String $template): void
    {
        $this->template = __DIR__ . "/../Views/$template.tpl.php";
        if (!file_exists($this->view)) {
            die("Le template ".$this->view." n'éxiste pas");
        }
    }
    

    public function partial(String $name, array $config = [], array $errors = []) {
        $file = __DIR__ . "/../Views/Partials/$name.partial.php";

        if (!file_exists($file)) {
            die("Le partial ".$name." n'éxiste pas");
        }
        extract($this->data);
        include __DIR__ . "/../Views/Partials/$name.partial.php";
    }

    public function render()
    {
        extract($this->data);

        ob_clean();
        ob_start();
        include $this->template;
        $content = ob_get_clean();

        echo $content;
        exit();
    }
}