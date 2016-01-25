<?php
if (!defined('IN_COPPERMINE')) die('Not in Coppermine...');

class Html5upload {

	public $h5u_config_default = array(
		'concurrent'=>3,
		'upldsize'=>0,
		'autoedit'=>1,
		'acptmime'=>'image/*',
		'enabtitl'=>0,
		'enabdesc'=>0,
		'enabkeys'=>1,
		'enabusr1'=>0,
		'enabusr2'=>0,
		'enabusr3'=>0,
		'enabusr4'=>0
		);
	public $sys_max_chnk_size;
	public $sys_max_upl_size;

	public function __construct ()
	{
		global $CONFIG;

		$this->sys_max_chnk_size = min($this->to_bytes(ini_get('upload_max_filesize')), $this->to_bytes(ini_get('post_max_size')), $this->to_bytes(ini_get('memory_limit')));
		$this->sys_max_upl_size = min($CONFIG['max_upl_size'] * 1024, $this->sys_max_chnk_size);
	}

	public function help_button ($guid)
	{
		global $CONFIG;
		return '&nbsp;<a class="greybox" href="plugins/html5upload/help.php?t=' . $CONFIG['theme'] . '&l='.$CONFIG['lang']
			. '&g='.$guid.'" title="Help"><img src="images/help.gif" width="13" height="11" border="0" alt=""></a>';
	}

	// convert string in form n(K|M|G) to an integer value
	public function to_bytes ($val)
	{
		$val = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		switch($last) {
			case 'g': $val *= 1024;
			case 'm': $val *= 1024;
			case 'k': $val *= 1024;
		}
		return $val;
	}

	// convert integer value to n(K|M|G) string
	public function to_KMG ($val=0)
	{
		$sizm = 'K';
		if ($val) {
			if ($val % 0x40000000 == 0) {
				$sizm = 'G';
				$val >>= 30;
			} elseif ($val % 0x100000 == 0) {
				$sizm = 'M';
				$val >>= 20;
			} else {
				$val >>= 10;
			}
		}
		return $val.$sizm;
	}

}

global $h5a_upload;
$h5a_upload = new Html5upload();
