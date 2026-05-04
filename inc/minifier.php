<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

class MINIFIER
{
	public function __construct( $html )
	{
		$this->_html = str_replace("\r\n", "\n", trim($html));
	}

	public function minify()
	{
		$this->_placeholders	= array();
		$this->_replacementHash = 'MINIFYHTML' . md5( $_SERVER['REQUEST_TIME'] );
		
		$this->_html = preg_replace_callback(
			'/(\\s*)<script(\\b[^>]*?>)([\\s\\S]*?)<\\/script>(\\s*)/i',
			array( $this, '_removeScriptCB' ),
			$this->_html
		);

		$this->_html = preg_replace_callback(
			'/\\s*<style(\\b[^>]*>)([\\s\\S]*?)<\\/style>\\s*/i',
			array( $this, '_removeStyleCB' ),
			$this->_html
		);

		$this->_html = preg_replace_callback(
			'/<!--([\\s\\S]*?)-->/',
			array( $this, '_commentCB' ),
			$this->_html
		);

		$this->_html = preg_replace_callback(
			'/\\s*<pre(\\b[^>]*?>[\\s\\S]*?<\\/pre>)\\s*/i',
			array( $this, '_removePreCB' ),
			$this->_html
		);

		$this->_html = preg_replace_callback(
			'/\\s*<textarea(\\b[^>]*?>[\\s\\S]*?<\\/textarea>)\\s*/i',
			array( $this, '_removeTextareaCB' ),
			$this->_html
		);

		$this->_html = preg_replace( '/^\\s+|\\s+$/m', '', $this->_html );
		$this->_html = preg_replace(
			'/\\s+(<\\/?(?:area|article|aside|base(?:font)?|blockquote|body|canvas|caption|center|col(?:group)?|dd|dir|div|dl|dt|fieldset|figcaption|figure|footer|form|frame(?:set)?|h[1-6]|head|header|hgroup|hr|html|legend|li|link|main|map|menu|meta|nav|ol|opt(?:group|ion)|output|p|param|section|t(?:able|body|head|d|h||r|foot|itle)|ul|video)\\b[^>]*>)/i',
			'$1',
			$this->_html
		);

		$this->_html = preg_replace(
			'/>(\\s(?:\\s*))?([^<]+)(\\s(?:\s*))?</',
			'>$1$2$3<',
			$this->_html
		);

		$this->_html = str_replace(
			array_keys( $this->_placeholders ),
			array_values( $this->_placeholders ),
			$this->_html
		);

		$this->_html = str_replace(
			array_keys( $this->_placeholders ),
			array_values( $this->_placeholders ),
			$this->_html
		);
		return $this->_html;
	}

	protected function _commentCB( $m )
	{
		return ( 0 === strpos( $m[1], '[' ) || false !== strpos( $m[1], '<![' ) ) ? $m[0] : '';
	}

	protected function _reservePlace( $content )
	{
		$placeholder = '%' . $this->_replacementHash . count( $this->_placeholders ) . '%';
		$this->_placeholders[$placeholder] = $content;
		return $placeholder;
	}

	protected $_replacementHash = null;
	protected $_placeholders = array();

	protected function _removePreCB( $m )
	{
		return $this->_reservePlace( "<pre{$m[1]}" );
	}

	protected function _removeTextareaCB( $m )
	{
		return $this->_reservePlace( "<textarea{$m[1]}" );
	}

	protected function _removeStyleCB( $m )
	{
		$openStyle = "<style{$m[1]}";
		$css = $m[2];
		$css = preg_replace( '/(?:^\\s*<!--|-->\\s*$)/', '', $css );
		$css = call_user_func( 'trim', $css );
		return $this->_reservePlace( "{$openStyle}{$css}</style>" );
	}

	protected function _removeScriptCB( $m )
	{
		$openScript = "<script{$m[2]}";
		$js = $m[3];
		$ws1 = ( $m[1] === '' ) ? '' : ' ';
		$ws2 = ( $m[4] === '' ) ? '' : ' ';
		$js = preg_replace( '/(?:^\\s*<!--\\s*|\\s*(?:\\/\\/)?\\s*-->\\s*$)/', '', $js );
		$js = trim( $js );
		return $this->_reservePlace( "{$ws1}{$openScript}{$js}</script>{$ws2}" );
	}

}
