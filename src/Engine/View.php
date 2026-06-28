<?php

namespace TomTroc\Engine;

class View
{
    private string $layout = __DIR__ . "/../../views/layouts/main.php";

    private string $title;

    /**
     * @todo This is so uselesss....
     */
    public function __construct(string $title)
    {
        $this->title = $title;
    }

    /**
     * Render a view template with the provided data.
     * @param string $template The name of the template to render.
     * @param array $data An associative array of data to pass to the view.
     */
    public function render(string $template, array $data = []): void
    {
        // Rendre les données disponibles dans la vue
        extract($data);

        // Charger les utilitaires partagés avant de rendre la vue
        require_once __DIR__ . '/../services/Utils.php';

        // Capturer le contenu de la vue
        ob_start();
        require __DIR__ . "/../../views/pages/{$template}.php";
        $content = ob_get_clean();

        // Injecter dans le layout
        require $this->layout;
    }

    /**
     * Render a partial view template with the provided data.
     * @param string $template The name of the partial template to render.
     * @param array $data An associative array of data to pass to the partial view.
     */
    public function partial(string $template, array $data = []): void
    {
        extract($data);
        require __DIR__ . "/../../views/partials/{$template}.php";
    }
}
