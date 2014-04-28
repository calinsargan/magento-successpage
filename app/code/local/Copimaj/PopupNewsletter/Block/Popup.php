<?php
class Copimaj_PopupNewsletter_Block_Popup extends Mage_Core_Block_Template
{
	var $_code = 'popup_newsletter';
	var $_value = 1;
	var $_interval = 30; // days

	public function cook()
	{
		if (!$this->_isCooked()) 
			return setcookie($this->_code, $this->_value, time() + $this->_getInterval(), '/');
		else 
			return false;
	}

	private function _isCooked()
	{
		return ($_COOKIE[$this->_code]);
	}

	private function _getInterval()
	{
		return 60 * 60 * 24 * $this->_interval;
	}

	/* delayer addon */
	var $_delayer = 5;
	var $_codeDelay = 'popup_delay_nl_first';
	var $_diff;

	public function cookDelay()
	{
		if (!isset($_COOKIE[$this->_codeDelay])) {
			$expire = time() + $this->_getInterval();
			$flag = setcookie($this->_codeDelay, time(), $expire, '/');
		} else {
			$this->_diff = time() - $_COOKIE[$this->_codeDelay];
		}
	}

	public function isReady()
	{
		return $this->_delayer - $this->_diff;
	}

	public function getCookieCode()
	{
		return $this->_code;
	}

	public function getCookieJs($id)
	{
		?>
		<script type="text/javascript">
		var popup = jQuery("#<?php echo $id ?>");
			popup.dialog({
				width: 600,
				height: 250,
				autoOpen: false
			})	

		function popupf() {
		if (!jQuery.cookie("<?php echo $this->_code ?>")) {
				var date = new Date();
				<?php 
				$dateLimit = $this->_isCooked() ? $this->_isCooked() : time();
				?>
				date.setTime((<?php echo $dateLimit; ?> + <?php echo $this->_getInterval() + 1 ?>) * 1000);
				jQuery.cookie("<?php echo $this->_code ?>", "true", { expires: date, path: '/' });
				// do popup action
				popup.dialog("open");
			}
		}
		<?php if ($this->isReady() > 0) : ?>
		window.setTimeout(popupf, <?php echo $this->isReady() * 1000 ?>);
		<?php else : ?>
		popupf();
		<?php endif; ?>
		</script>
		<?php
	}
}