<?php declare(strict_types = 1);

namespace Warengo\AsyncControl;

use Nette\Application\UI\Control;

final class AsyncControlContainer extends Control {

	/** @var Control[] */
	private $components = [];

	/** @var bool */
	private $show = false;

	public function addControl(Control $control, string $name): void {
		$this->addComponent($control, $name);

		$this->components[$name] = $control;
	}

	public function handleLoad(): void {
		$this->show = true;

		if ($this->getPresenter()->isAjax()) {
			$this->redrawControl();
		}
	}

	public function renderLink(): void {
		echo $this->link('load!');
	}

	public function render(): void {
		$template = $this->getTemplate();
		$template->setFile(__DIR__ . '/templates/asyncControl.latte');

		$template->components = $this->components;
		$template->show = $this->show;

		$template->render();
	}

}
