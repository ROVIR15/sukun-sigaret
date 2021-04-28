<?php
namespace sgpb;
require_once(dirname(__FILE__).'/SGPopup.php') ;
class HtmlPopup extends SGPopup
{

	public function getOptionValue($optionName, $forceDefaultValue = false)
	{
		return parent::getOptionValue($optionName, $forceDefaultValue);
	}

	public function getPopupTypeOptionsView()
	{
		return array();
	}

	public function getPopupTypeMainView()
	{
		return array();
	}

	public function getPopupTypeContent()
	{
		$htmlContent = '';
		$popupContent = $this->getContent();
		$htmlContent .= '<div class="sgpb-scroll-wrapper sgpb-main-html-content-wrapper">';
		$htmlContent .= $popupContent;
		$htmlContent .= '</div>';

		$htmlContent .= '<style>';
		$htmlContent .= '.sgpb-popup-builder-content-html {';
		$htmlContent .= 'width: 100%;';
		$htmlContent .= 'height: 100%;';
		$htmlContent .= 'overflow: auto;}';
		$htmlContent .= '.sgpb-main-html-content-wrapper{overflow: auto !important;}';
		$htmlContent .= '</style>';

		return $htmlContent;
	}

	public function getExtraRenderOptions()
	{
		return array();
	}
}