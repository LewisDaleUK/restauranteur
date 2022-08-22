<?php

namespace Lewisdaleuk\Restauranteur\Core;

/**
 * Root class for representing a view. Handles rendering a template via the render function
 */
class View {
	private \Twig\Environment $twig;
	protected $template;

	public function __construct(
		protected string $template_name,
	) {
		$loader = new \Twig\Loader\FilesystemLoader(__PROJECT_ROOT__ . '/views/');
		$this->twig = new \Twig\Environment($loader, [
			'cache' => __PROJECT_ROOT__ . '/.cache',
		]);
		$this->template = $this->twig->load($template_name);
	}

	/**
	 * Render the view
	 */
	public function render(array $data = []) {
    	return $this->template->render($data);
	}
}
?>
