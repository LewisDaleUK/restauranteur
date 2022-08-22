<?php

namespace Lewisdaleuk\Restauranteur\Core;

/**
 * Root class for representing a view. Handles rendering a template via the render function
 */
class View {
	public function __construct(
		protected string $template,
		protected object $data
	) {}

	/**
	 * Render the view
	 */
	public function render() {
		ob_start();
		ob_clean();

		include __PROJECT_ROOT__ . '/views/' . $this->template;
		$content = ob_get_contents();
    ob_end_clean();
    return $content;
	}
}
?>
