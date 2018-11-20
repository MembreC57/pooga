<?php namespace AutoMenu;

use Gc7\Helper\Gc7Tip;

require 'Form.php';

class BootstrapForm extends Form {

	public function input ( $name ) {
		return $this->surround( '
		<label for "' . $name . '">' . ucfirst( $name ) . '</label>
		<input type="text" name="' . $name . '" id="' . GC7Tip::toCamelCase( $name ) . '" value="' . $this->getValue( $name ) . '" />' );
	}

	/**
	 * @param $html
	 *
	 * @return string
	 */
	protected function surround ( $html ) {
		return '<div class="form-group">' . $html . '
	</div>

';
	}

	/**
	 * @return string
	 */
	public function recaptchav2Test () {
		return $this->surround( '<div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>' );
	}

	/**
	 * @return string
	 */
	public function submit () {
		return $this->surround( '
		<button type="submit" class="btn addDoss">Créer le nouveau dossier</button>' );
	}

	/**
	 * @return string
	 */
	public function submitTxt ( $txt = null ) {
		return $this->surround( '
		<button type="submit" class="btn addDoss">' . $txt . '</button>' );
	}

}
